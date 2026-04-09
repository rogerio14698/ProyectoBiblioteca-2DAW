# 🏗️ Auditoría de Arquitectura — Proyecto Horae (Biblioteca DAW)

**Fecha:** 10 de abril de 2026  
**Stack:** Laravel 12, PHP 8.3, MySQL, JavaScript (Vanilla), HTML5, CSS3  
**Alcance:** Revisión completa de MVC, SOLID, Eloquent, autenticación y escalabilidad.

---

## 📋 Índice

1. [Patrón MVC — ¿Se cumple?](#1-patrón-mvc--se-cumple)
2. [Principios SOLID](#2-principios-solid)
3. [Modelos y Relaciones Eloquent](#3-modelos-y-relaciones-eloquent)
4. [Problemas N+1 detectados](#4-problemas-n1-detectados)
5. [Sistema de Autenticación Dual](#5-sistema-de-autenticación-dual)
6. [Escalabilidad: 100K libros + 10K usuarios](#6-escalabilidad-100k-libros--10k-usuarios)
7. [Resumen de hallazgos por prioridad](#7-resumen-de-hallazgos-por-prioridad)
8. [Respuestas directas](#8-respuestas-directas)

---

## 1. Patrón MVC — ¿Se cumple?

**Veredicto: Parcialmente.** El esqueleto es correcto, pero hay fugas de lógica que rompen la separación.

### Violaciones concretas

#### A) Closures con lógica en `routes/web.php`

Hay consultas Eloquent directamente en las rutas, lo cual rompe la "C" de MVC:

```php
// ❌ routes/web.php — lógica de controlador en una closure
Route::get('/admin', function () {
    $mensajes = Contacto::orderBy('created_at', 'desc')->paginate(10);
    return view('bibliotecaDAW.adminViews.administrador', compact('mensajes'));
})->name('admin.dashboard');

Route::get('/actividades', function () {
    $eventos = \App\Models\Evento::orderby('created_at', 'desc')->paginate(6);
    return view('bibliotecaDAW.publicViews.actividadesEventos', ['eventos' => $eventos]);
});
```

Hay **~20 closures** en `routes/web.php` que deberían migrar a métodos de controlador. Esto incluye el dashboard admin, la página de actividades, y todas las vistas placeholder de usuario.

#### B) `HomeController` tiene métodos vacíos de scaffold

`HomeController.php` conserva `create()`, `store()`, `show()`, `edit()`, `update()`, `destroy()` vacíos — código muerto que genera confusión.

#### C) `AdminController` completamente vacío

`AdminController.php` no tiene implementación. Debería absorber la lógica del dashboard que ahora está en la closure de `web.php`.

---

## 2. Principios SOLID

| Principio | Estado | Detalles |
|-----------|--------|----------|
| **S** — Single Responsibility | ⚠️ | `LibroController` mezcla lógica pública (catálogo) con admin (CRUD). `HomeController` combina index con destacados. |
| **O** — Open/Closed | ✅ | No hay violaciones evidentes. |
| **L** — Liskov Substitution | ✅ | `Usuario` y `Admin` ambos extienden `Authenticatable` correctamente. |
| **I** — Interface Segregation | ⚠️ | No se usan interfaces ni contratos. Los controladores dependen directamente de modelos concretos. |
| **D** — Dependency Inversion | ⚠️ | Todos los controladores llaman a Eloquent directamente. No hay capa de servicio/repositorio. |

**Recomendación principal:** Separar `LibroController` en `LibroCatalogoController` (público) y `AdminLibroController` (panel), y mover consultas complejas a una clase Service.

---

## 3. Modelos y Relaciones Eloquent

### Relaciones faltantes

| Modelo | Falta | Impacto |
|--------|-------|---------|
| **`Usuario`** | `hasMany(Reserva::class)` | No se puede hacer `$usuario->reservas` |
| **`Usuario`** | `hasMany(Evento::class)` | No se puede hacer `$usuario->eventos` |
| **`Usuario`** | `hasMany(MetodosPago::class)` | Relación inversa existe pero no la directa |
| **`Libro`** | `hasMany(Reserva::class)` | No se puede hacer `$libro->reservas` |
| **`Admin`** | `hasMany(Noticias::class)` | No se puede saber qué noticias creó un admin |
| **`Noticias`** | `belongsTo(Admin::class)` | Tiene `admin_id` pero no declara la relación |
| **`Contacto`** | Sin relaciones | OK si es intencional |

### Inconsistencias en los modelos

**`Admin` usa mutator manual, `Usuario` usa cast `hashed`:**

```php
// Admin.php — mutator manual ❌
public function setPasswordAttribute($value): void {
    if (is_string($value) && !Hash::isHashed($value)) {
        $this->attributes['password'] = Hash::make($value);
        return;
    }
    $this->attributes['password'] = $value;
}

// Usuario.php — cast automático ✅ (mejor enfoque)
protected function casts(): array {
    return ['password' => 'hashed'];
}
```

Deberías unificar: usar el cast `'hashed'` en `Admin` también y eliminar el mutator.

**`User.php` vs `Usuario.php`:** El modelo `User` (por defecto de Laravel) sigue existiendo pero el sistema usa `Usuario`. Esto genera confusión — el modelo `User` debería eliminarse o documentar que es vestigial.

---

## 4. Problemas N+1 detectados

| Controlador | Método | Problema | Severidad |
|-------------|--------|----------|-----------|
| `HomeController::index()` | `Libro::all()` | Sin `with()`, si Blade accede a relaciones = N+1 | 🟡 Media |
| `HomeController::index()` | `Noticias::paginate(4)` | Sin eager-load del admin autor | 🟡 Media |
| `GestionUsuariosController::index()` | `Usuario::query()->get()` + `Admin::get()` | Sin paginación — carga TODOS los registros en memoria | 🔴 Alta |
| `NoticiasController::gestionNoticias()` | `Noticias::orderBy()->get()` | Sin paginación, carga todas en memoria | 🔴 Alta |
| `EventosController::adminCarrusel()` | `Evento::with('usuario')->get()` | ✅ Correcto — usa `with()` | ✅ OK |
| `ReservaController::historial()` | `Reserva::with(['usuario', 'libro'])->get()` | Eager-load ✅, pero sin paginación 🔴 | 🔴 Alta |
| `ReservaController::activas()` | `Reserva::with([...])->get()` | Mismo: eager-load OK, paginación ausente | 🟡 Media |

**El patrón más peligroso es `->get()` sin `->paginate()` en secciones admin.** Con 100K libros o 10K reservas, estas queries cargarán todo en RAM.

---

## 5. Sistema de Autenticación Dual

**Veredicto: Es correcto para el alcance del proyecto.**

La implementación con 2 guards (`web` + `admin`) es un patrón válido y bien soportado en Laravel.

### Comparativa de alternativas

| Opción | ¿Para este proyecto? | Razón |
|--------|----------------------|-------|
| **Guards duales (actual)** | ✅ Adecuado | Separación clara admin/usuario, tablas distintas, lógica simple |
| **Laravel Breeze** | 🟡 Opcional | Solo ahorraría el scaffolding de login/registro, que ya está hecho |
| **Spatie Permission** | ❌ Prematuro | Solo tiene sentido con 3+ roles y permisos granulares |
| **Guard único + roles** | 🟡 Alternativa | Simplifica la config pero complica el middleware |

### Mejoras necesarias en autenticación

1. **No hay password reset** — ni para usuarios ni para admin.
2. **No hay rate limiting** en las rutas de login — vulnerable a fuerza bruta.
3. `Admin::where('id', $admin->id)->update(...)` debería ser `$admin->update(...)` — query extra innecesaria en `LoginControllerAdmin.php`.

---

## 6. Escalabilidad: 100K libros + 10K usuarios

### A) Ausencia de paginación en panel admin

Estas queries colapsarían con volumen:

```php
// ❌ GestionUsuariosController — carga TODOS los usuarios
$usuarios = $query->orderBy('created_at', 'desc')->get();

// ❌ NoticiasController — carga TODAS las noticias
$noticias = Noticias::orderBy('fecha_publicacion', 'desc')->get();

// ❌ ReservaController — carga TODAS las reservas
$reservas = $query->orderBy('fecha_reserva', 'desc')->get();
```

**Solución:** Cambiar `->get()` por `->paginate(25)` en todos los listados admin.

### B) Selects sin límite en formularios

```php
// ❌ ReservaController::historial()
$usuarios = Usuario::orderBy('name')->get();  // 10K registros en un <select>
$libros = Libro::orderBy('titulo')->get();     // 100K registros en un <select>
```

Con 100K libros, renderizar un `<select>` con 100K `<option>` es inviable.

**Solución:** Usar un campo de búsqueda con autocompletado (AJAX/fetch) en vez de `<select>`.

### C) Índices de base de datos

Faltan índices en columnas que se filtran frecuentemente:

| Columna | Contexto |
|---------|----------|
| `libros.titulo` | Se filtra con LIKE en catálogo |
| `libros.autor` | Se filtra con LIKE |
| `libros.genero` | Se filtra con LIKE |
| `usuarios.name` | Se filtra en gestión |
| `usuarios.dni` | Se filtra en búsqueda |
| `reservas.estado` | Se filtra constantemente |
| `reservas.usuario_id` | FK (probablemente tiene índice ya) |
| `noticias.fecha_publicacion` | Se ordena siempre |

### D) Queries LIKE sin full-text

`WHERE titulo LIKE '%harry%'` no usa índices B-Tree. Con 100K libros, cada búsqueda haría un full table scan.

**Solución a escala:** Índice `FULLTEXT` en MySQL o integrar Scout con Algolia/Meilisearch.

### E) `Libro::all()` en `HomeController::index()`

Carga absolutamente todos los libros para la página principal. Con 100K libros = Out of Memory.

**Solución:** Limitar con `->limit(12)` o `->paginate(12)` según necesidad de la vista.

---

## 7. Resumen de hallazgos por prioridad

| Prioridad | Hallazgo | Archivo(s) afectados |
|-----------|----------|----------------------|
| 🔴 Crítico | `->get()` sin paginar en listados admin | `GestionUsuariosController`, `NoticiasController`, `ReservaController` |
| 🔴 Crítico | `<select>` con todos los usuarios/libros sin límite | `ReservaController::historial()` |
| 🔴 Crítico | `Libro::all()` en la home | `HomeController::index()` |
| 🟠 Alto | ~20 closures con lógica en `web.php` | `routes/web.php` |
| 🟠 Alto | Relaciones Eloquent sin declarar (Usuario→Reservas, Libro→Reservas, etc.) | Modelos |
| 🟠 Alto | Sin rate-limiting en login | Ambos LoginControllers |
| 🟡 Medio | Sin índices en columnas filtradas | Migraciones |
| 🟡 Medio | Inconsistencia password hashing (mutator vs cast) | `Admin.php` vs `Usuario.php` |
| 🟡 Medio | `User.php` modelo vestigial sin usar | `app/Models/User.php` |
| 🟢 Bajo | Controladores vacíos (AdminController, métodos scaffold) | `AdminController.php`, `HomeController.php` |
| 🟢 Bajo | Sin password reset implementado | — |

---

## 8. Respuestas directas

### ¿Estoy siguiendo correctamente MVC y SOLID?

La estructura es correcta (Models / Controllers / Views en los lugares adecuados), pero hay fugas: closures en rutas con queries, un controlador que mezcla público/admin (`LibroController`), y controladores vacíos. SOLID se viola principalmente en **S** (responsabilidad única) y **D** (inversión de dependencia — todo acoplado a Eloquent directo).

### ¿Relaciones optimizadas? ¿N+1?

Las relaciones que existen están bien (`Reserva→Usuario`, `Reserva→Libro`, `Evento→Usuario`). Pero faltan muchas relaciones inversas. El eager-loading se aplica correctamente en `ReservaController` y `EventosController`, pero no en `HomeController` ni `NoticiasController`.

### ¿Auth dual es la mejor práctica?

Sí, para esta escala es adecuado. Spatie Permission sería over-engineering. Lo que falta es rate-limiting y password reset.

### ¿Escalará a 100K libros / 10K usuarios?

**No sin cambios.** Los 3 bloqueantes principales:
1. `->get()` sin paginar
2. `<select>` con todos los registros
3. `LIKE '%..%'` sin full-text search

Resolverlos no requiere reescribir — son **cambios quirúrgicos** en queries y vistas.
