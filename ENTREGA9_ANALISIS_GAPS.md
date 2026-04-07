# 🔍 Entrega 9 — Análisis de Gaps (Secciones Faltantes)

> **Propósito:** Este documento detalla las secciones que **faltan o están incompletas** en la Entrega 9 respecto al índice requerido, e incluye el contenido real del proyecto para que pueda ser integrado directamente.

---

## 📋 Resumen de Cumplimiento

| Sección Requerida | Estado | Observación |
|---|---|---|
| 1.1 Frontend | ✅ Cubierta | Ya documentada en la entrega |
| **1.2 Backend** | ❌ **FALTA** | No existe sección dedicada al backend |
| **1.3 Base de Datos** | ❌ **FALTA** | No existe sección dedicada a la BD |
| 2.1 Validación de Datos | ✅ Cubierta | Ya documentada |
| 2.2 Protección CSRF | ✅ Cubierta | Ya documentada |
| 2.3 Autenticación y Control de Roles | ✅ Cubierta | Ya documentada |
| 2.4 Cifrado de Contraseñas | ✅ Cubierta | Ya documentada |
| **2.5 Protección contra SQL Injection** | ❌ **FALTA** | No existe sección dedicada |
| **2.6 Rate Limiting** | ⚠️ **FALTA + NO IMPLEMENTADO** | Ni documentado ni implementado en código |
| **2.7 XSS (Cross-site Scripting)** | ❌ **FALTA** | Solo mención parcial, no sección dedicada |
| 3.1 Separación de responsabilidades | ✅ Cubierta | Ya documentada |
| 3.2 Ventajas de la modularización | ✅ Cubierta | Ya documentada |
| **3.3 Comunicación entre módulos** | ❌ **FALTA** | No existe sección dedicada |

**Total: 6 secciones faltantes de 13 requeridas.**

---

---

# 📝 CONTENIDO PARA LAS SECCIONES FALTANTES

A continuación se incluye el contenido listo para integrar en la entrega, basado en el análisis real del proyecto.

---

## 1.2 Backend

### Arquitectura del Backend (Laravel 12 / PHP 8.3)

El backend del proyecto sigue el patrón **MVC (Model-View-Controller)** de Laravel 12. Toda petición HTTP pasa por el siguiente flujo:

```
Navegador → public/index.php → bootstrap/app.php → routes/web.php → Controller → Model (Eloquent) → View (Blade)
```

### Estructura de Rutas (`routes/web.php`)

Las rutas están organizadas en **4 bloques diferenciados** según el nivel de acceso:

#### 1. Rutas Públicas (sin autenticación)
Accesibles por cualquier visitante:

```php
// Página principal: carga slides, eventos, libros y noticias
Route::get('/biblioteca', [HomeController::class, 'index'])->name('home');

// Catálogo con filtros de búsqueda (query, titulo, autor, genero)
Route::get('/catalogo', [LibroController::class, 'catalogo'])->name('catalogo');

// Páginas internas de detalle (reciben ID del recurso)
Route::get('/libro/{id}', [LibroController::class, 'paginaInterna'])->name('libro.paginaInterna');
Route::get('/evento/{id}', [EventosController::class, 'paginaInterna'])->name('evento.paginaInterna');
Route::get('/noticia/{id}', [NoticiasController::class, 'paginaInterna'])->name('noticia.paginaInterna');

// Formulario de contacto (POST procesa y envía email)
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.enviar');
```

#### 2. Rutas de Autenticación
Gestión del login/logout para ambos guards:

```php
// Login de usuario estándar
Route::get('/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('usuario.login.mostrar');
Route::post('/login', [LoginControllerUsuario::class, 'login'])->name('usuario.login.procesar');
Route::post('/login/demo', [LoginControllerUsuario::class, 'loginDemo'])->name('usuario.login.demo');

// Login de administrador (ruta separada)
Route::get('/admin/login', [LoginControllerAdmin::class, 'mostrarLogin'])->name('admin.login.mostrar');
Route::post('/admin/login', [LoginControllerAdmin::class, 'login'])->name('admin.login.procesar');
```

#### 3. Rutas de Usuario Autenticado
Protegidas por el middleware `auth:web` (guard de usuario) y `bloquear.demo` (impide escritura a cuentas demo):

```php
Route::middleware(['auth:web', 'bloquear.demo'])->group(function () {
    Route::get('/inicioUsuario', fn() => view(...))->name('usuario.inicio');
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('usuario.perfil');
    Route::get('/mis-consultas', [ContactoController::class, 'misConsultas'])->name('usuario.consultas');
    Route::post('/logout', [LoginControllerUsuario::class, 'logout'])->name('usuario.logout');
    // ... más rutas de gestión de usuario
});
```

#### 4. Rutas de Administrador
Protegidas por el middleware `auth:admin`:

```php
Route::middleware(['auth:admin', 'bloquear.demo'])->group(function () {
    Route::get('/admin', [ContactoController::class, 'index'])->name('admin.inicio');
    Route::post('/admin/gestionCarrusel', [EventosController::class, 'store']);
    Route::patch('/admin/mensajes/{id}/estado', [ContactoController::class, 'updateEstado']);
    Route::delete('/admin/mensajes/{contacto}', [ContactoController::class, 'destroy']);
    // ... más rutas CRUD de administración
});
```

### Controladores

El proyecto cuenta con **10 controladores** organizados por dominio:

| Controlador | Ubicación | Responsabilidad |
|---|---|---|
| `HomeController` | `app/Http/Controllers/` | Página principal (slides, eventos, libros, noticias) |
| `LibroController` | `app/Http/Controllers/` | Catálogo, detalle y alquiler de libros |
| `EventosController` | `app/Http/Controllers/` | CRUD de eventos, inscripción, detalle |
| `ContactoController` | `app/Http/Controllers/` | Formulario de contacto, consultas de usuario, gestión admin |
| `NoticiasController` | `app/Http/Controllers/` | Detalle de noticias |
| `SlideBienvenidaController` | `app/Http/Controllers/` | Gestión de slides del carrusel principal |
| `UsuarioController` | `app/Http/Controllers/Auth/` | Registro y perfil de usuario |
| `LoginControllerUsuario` | `app/Http/Controllers/Auth/` | Login, logout y demo de usuario |
| `LoginControllerAdmin` | `app/Http/Controllers/Admin/Auth/` | Login, logout y demo de admin |
| `AdminController` | `app/Http/Controllers/` | Scaffold base (sin implementar) |

### Middleware Personalizado

El proyecto implementa **1 middleware propio** además de los que incluye Laravel por defecto:

**`BloquearUsuarioDemo`** (`app/Http/Middleware/BloquearUsuarioDemo.php`):

```php
public function handle(Request $request, Closure $next): Response
{
    $esDemo = false;

    // Comprueba si el usuario logueado (web o admin) es una cuenta demo
    if ($usuario = Auth::guard('web')->user()) {
        if ($usuario->is_demo) $esDemo = true;
    }
    if ($admin = Auth::guard('admin')->user()) {
        if ($admin->is_demo) $esDemo = true;
    }

    // Si NO es demo, deja pasar la petición
    if (!$esDemo) return $next($request);

    // Si ES demo, bloquea métodos de escritura (POST, PUT, PATCH, DELETE)
    // Solo permite GET y la acción de logout
    // ...
}
```

Este middleware se registra como alias en `bootstrap/app.php`:

```php
$middleware->alias([
    'bloquear.demo' => \App\Http\Middleware\BloquearUsuarioDemo::class,
]);
```

### Ciclo de vida de una petición típica

Ejemplo: Un usuario busca "Cervantes" en el catálogo.

1. El navegador envía `GET /catalogo?query=Cervantes`
2. `routes/web.php` lo enruta a `LibroController@catalogo`
3. El controlador **valida** el input (`max:120`, `string`, `nullable`)
4. Construye una query Eloquent con `->where('titulo', 'like', '%Cervantes%')`
5. Eloquent genera SQL parametrizado → MySQL lo ejecuta de forma segura
6. El controlador devuelve la vista `catalogo.blade.php` con los resultados paginados
7. Blade renderiza el HTML usando `{{ }}` (escape automático de XSS)
8. Laravel devuelve la respuesta HTTP al navegador

---

## 1.3 Base de Datos

### Motor y Configuración

- **Motor:** MySQL (a través de XAMPP en local, Amazon RDS en producción)
- **Charset:** `utf8mb4` con collation `utf8mb4_unicode_ci` (soporte completo de emojis y caracteres especiales)
- **Modo estricto:** Activado (`'strict' => true` en `config/database.php`)
- **Credenciales:** Almacenadas en `.env` (nunca en el código fuente)

```php
// config/database.php
'mysql' => [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', '127.0.0.1'),
    'database'  => env('DB_DATABASE', 'laravel'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', ''),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'strict'    => true,
],
```

### Esquema de Tablas (Migraciones)

El proyecto define **9 tablas propias** mediante el sistema de migraciones de Laravel (`database/migrations/`):

| Tabla | Migración | Descripción |
|---|---|---|
| `usuarios` | `2026_02_06_232113_usuario_registrado.php` | Usuarios registrados del sistema |
| `admin` | `2026_02_15_212655_admin_table.php` | Administradores del sistema |
| `libros` | `2026_02_06_231355_crear_libro_tabla_admin.php` | Catálogo de libros |
| `eventos` | `2026_02_16_175209_eventos_index.php` | Actividades y eventos |
| `noticias` | `2026_03_06_230439_create_noticias_table.php` | Noticias publicadas |
| `contactos` | `2026_03_11_184728_create_contactos_table.php` | Mensajes del formulario de contacto |
| `metodos_pago` | `2026_02_07_000322_metodos_pago.php` | Métodos de pago asociados a usuarios |
| `slide_bienvenidas` | `2026_03_18_091413_create_slide_bienvenidas_table.php` | Slides del carrusel principal |
| `cache` / `sessions` / `jobs` | Migraciones por defecto de Laravel | Infraestructura del framework |

### Diagrama de Relaciones

```
┌──────────────┐       1:N        ┌──────────────┐
│   USUARIOS   │─────────────────▶│   EVENTOS    │
│              │                  │              │
│  id (PK)     │                  │  usuario_id  │──► FK con CASCADE
│  name        │                  │  titulo      │
│  email (UQ)  │       1:N        │  aforo       │
│  dni (UQ)    │─────────────────▶│  asistentes  │
│  movil (UQ)  │                  │  plazas_lib. │──► Columna calculada (aforo - asistentes)
│  nSocio (UQ) │                  └──────────────┘
│  password    │
│  is_demo     │       1:N        ┌──────────────┐
└──────────────┘─────────────────▶│ METODOS_PAGO │
                                  │              │
                                  │  usuario_id  │──► FK con CASCADE
                                  │  token       │──► Cifrado (APP_KEY)
                                  │  last_four   │
                                  └──────────────┘

┌──────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────────┐
│   LIBROS     │    │  NOTICIAS    │    │  CONTACTOS   │    │ SLIDE_BIENVENIDAS│
│              │    │              │    │              │    │                  │
│  Sin FK      │    │  Sin FK      │    │  Sin FK      │    │  Sin FK          │
│  isbn        │    │  categoria   │    │  estado      │    │  posicion        │
│  portada_img │    │  destacado   │    │  email       │    │  imagen          │
└──────────────┘    └──────────────┘    └──────────────┘    └──────────────────┘
```

### Claves Foráneas y Restricciones

**Foreign Keys implementadas:**

```php
// Tabla eventos → usuario que lo creó
$table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');

// Tabla metodos_pago → usuario dueño del método
$table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
```

**Columna calculada (Stored Generated Column):**

```php
// Tabla eventos: plazas_libres se calcula automáticamente por MySQL
$table->integer('plazas_libres')->storedAs('aforo - asistentes');
```

**Restricciones de unicidad:**

```php
// Tabla usuarios: campos únicos para evitar duplicados
$table->string('email')->unique();
$table->string('dni')->unique();
$table->string('movil')->nullable()->unique();
$table->string('nSocio')->unique();
```

### Modelos Eloquent

Cada tabla tiene su modelo correspondiente en `app/Models/`:

- **`Usuario`** → tabla `usuarios` — Implementa `Authenticatable` para el guard `web`
- **`Admin`** → tabla `admin` — Implementa `Authenticatable` para el guard `admin`
- **`Libro`** → tabla `libros` — Sin relaciones
- **`Evento`** → tabla `eventos` — Relación `belongsTo(Usuario::class)`
- **`Noticias`** → tabla `noticias` — Sin relaciones
- **`Contacto`** → tabla `contactos` — Sin relaciones
- **`MetodosPago`** → tabla `metodos_pago` — Relación `belongsTo(Usuario::class)`, token cifrado
- **`SlideBienvenida`** → tabla `slide_bienvenidas` — Sin relaciones

Todos los modelos definen `$fillable` para proteger contra asignación masiva.

### Seeders y Factories

El proyecto usa Factories de Laravel para generar datos de prueba:

```php
// LibroSeeder.php — genera 500 libros con portadas únicas
Libro::factory()->count(500)->create();

// EventosSeeder.php — crea 3 eventos con imágenes de Unsplash
// NoticiasSeeder.php — crea 5 noticias con categorías variadas
// AdminSeeder.php — crea el administrador por defecto
// ContactoSeeder.php — crea mensajes de prueba
```

---

## 2.5 Protección contra SQL Injection

### ¿Qué es SQL Injection?

SQL Injection es un ataque donde un usuario malicioso introduce código SQL a través de campos de entrada (formularios, URLs), con el objetivo de manipular las consultas a la base de datos. Esto puede provocar:
- Lectura no autorizada de datos (contraseñas, emails)
- Modificación o eliminación de registros
- Escalada de privilegios

### Protección implementada en el proyecto

**El proyecto está 100% protegido contra SQL Injection** gracias a dos mecanismos:

#### 1. Eloquent ORM con Consultas Parametrizadas

Todo acceso a la base de datos se realiza a través de **Eloquent ORM**, que genera automáticamente consultas con **prepared statements** (parámetros vinculados). Esto significa que los datos del usuario **nunca** se concatenan directamente en las consultas SQL.

**Ejemplo real del proyecto — Búsqueda en el catálogo** (`LibroController.php`):

```php
// El usuario escribe "Cervantes" en el buscador
// Eloquent genera: SELECT * FROM libros WHERE titulo LIKE ? con parámetro '%Cervantes%'
// NUNCA genera: SELECT * FROM libros WHERE titulo LIKE '%Cervantes%' (concatenación directa)

$libros = Libro::query()
    ->when($searchQuery !== '', fn($query) => $query->where(function ($subQuery) use ($searchQuery) {
        $subQuery->where('titulo', 'like', "%{$searchQuery}%")
            ->orWhere('autor', 'like', "%{$searchQuery}%")
            ->orWhere('genero', 'like', "%{$searchQuery}%");
    }))
    ->paginate(12);
```

Aunque el código PHP muestra `"%{$searchQuery}%"`, Laravel internamente lo convierte en un parámetro vinculado (`?`), no en concatenación directa.

**Ejemplo real — Búsqueda por ID** (`EventosController.php`):

```php
// findOrFail usa vinculación de parámetros automáticamente
$evento = Evento::findOrFail($id);
```

**Ejemplo real — Filtro de consultas** (`ContactoController.php`):

```php
// where() siempre parametriza el valor del email
$mensajes = Contacto::where('email', $usuario->email)
    ->orderBy('created_at', 'desc')
    ->paginate(10);
```

#### 2. Ausencia total de Raw SQL

Se verificó que **no existe ningún uso de Raw SQL** en todo el proyecto:

- ❌ `DB::raw()` — 0 ocurrencias
- ❌ `DB::select()` — 0 ocurrencias
- ❌ `DB::statement()` — 0 ocurrencias
- ❌ `->whereRaw()` — 0 ocurrencias
- ❌ `->selectRaw()` — 0 ocurrencias

**AGENTS.md** del proyecto establece como regla: *"Prohibido el uso de Raw SQL. Toda interacción con DB debe realizarse vía modelos."*

### ¿Cómo funciona internamente?

Cuando Eloquent ejecuta:
```php
Libro::where('titulo', 'like', "%{$busqueda}%")->get();
```

Laravel genera internamente:
```sql
SELECT * FROM `libros` WHERE `titulo` LIKE ? 
-- Binding: ['%Cervantes%']
```

El driver PDO de PHP envía la consulta y los parámetros **por separado** al servidor MySQL. MySQL compila la consulta primero y luego aplica los parámetros como datos puros, haciendo **imposible** que un valor inyectado altere la estructura de la consulta.

---

## 2.6 Rate Limiting

### ¿Qué es Rate Limiting?

Rate Limiting (limitación de tasa) es una medida de seguridad que **restringe el número de peticiones** que un usuario puede realizar en un periodo de tiempo. Protege contra:
- **Ataques de fuerza bruta** al login (probar miles de contraseñas)
- **Spam** en formularios de contacto
- **DoS (Denegación de Servicio)** por exceso de peticiones

### ⚠️ Estado actual: NO IMPLEMENTADO

**El proyecto actualmente NO tiene Rate Limiting configurado.** Esto significa que:

- Las rutas `/login` y `/admin/login` aceptan peticiones ilimitadas (vulnerable a fuerza bruta)
- El formulario `/contacto` acepta envíos ilimitados (vulnerable a spam)
- No hay protección global contra peticiones excesivas

### Implementación Recomendada

Para añadir Rate Limiting al proyecto habría que:

#### Paso 1: Definir los limitadores en `AppServiceProvider.php`

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

public function boot(): void
{
    // Limitar intentos de login: máximo 5 intentos por minuto por IP
    RateLimiter::for('login', function ($request) {
        return Limit::perMinute(5)->by($request->ip());
    });

    // Limitar envíos de contacto: máximo 3 por minuto por IP
    RateLimiter::for('contacto', function ($request) {
        return Limit::perMinute(3)->by($request->ip());
    });
}
```

#### Paso 2: Aplicar el middleware a las rutas sensibles

```php
// routes/web.php
Route::post('/login', [LoginControllerUsuario::class, 'login'])
    ->middleware('throttle:login')
    ->name('usuario.login.procesar');

Route::post('/admin/login', [LoginControllerAdmin::class, 'login'])
    ->middleware('throttle:login')
    ->name('admin.login.procesar');

Route::post('/contacto', [ContactoController::class, 'store'])
    ->middleware('throttle:contacto')
    ->name('contacto.enviar');
```

#### Paso 3: Respuesta al usuario cuando excede el límite

Laravel automáticamente devuelve un error **HTTP 429 (Too Many Requests)** cuando se excede el límite, con la cabecera `Retry-After` indicando cuántos segundos debe esperar.

---

## 2.7 XSS (Cross-Site Scripting)

### ¿Qué es XSS?

XSS (Cross-Site Scripting) es un ataque donde un usuario malicioso inyecta código JavaScript en páginas web que son visualizadas por otros usuarios. Tipos:

- **Stored XSS:** El script se guarda en la base de datos (ej: en un mensaje de contacto) y se ejecuta cuando un admin lo visualiza.
- **Reflected XSS:** El script se envía en la URL y se refleja en la página sin sanitizar.

### Protecciones implementadas en el proyecto

#### 1. Escape automático de Blade (`{{ }}`)

Blade, el motor de plantillas de Laravel, **escapa automáticamente** toda variable renderizada con la sintaxis `{{ }}`. Esto convierte caracteres peligrosos como `<`, `>`, `"`, `'` y `&` en entidades HTML inofensivas.

**Ejemplo real del proyecto** — Catálogo (`catalogo.blade.php`):

```blade
{{-- Si $libro->titulo contiene "<script>alert('xss')</script>", se renderiza como texto plano --}}
<h5>{{ $libro->titulo }}</h5>
<p>{{ $libro->autor }}</p>
```

Blade internamente ejecuta `htmlspecialchars($libro->titulo, ENT_QUOTES, 'UTF-8')`, lo que produce:

```html
<h5>&lt;script&gt;alert(&#039;xss&#039;)&lt;/script&gt;</h5>
```

El navegador muestra el texto literal, **sin ejecutar** ningún script.

#### 2. Sanitización de entrada con `strip_tags()`

Antes de guardar datos introducidos por el usuario en la base de datos, se eliminan etiquetas HTML:

**Ejemplo real del proyecto** — Formulario de contacto (`ContactoController.php`):

```php
// El usuario podría escribir: <script>document.cookie</script> en el campo mensaje
// strip_tags() elimina TODAS las etiquetas HTML/JS antes de guardar
$mensajeLimpio = strip_tags($request->input('mensaje'));
$contacto->mensaje = $mensajeLimpio;
$contacto->save();
```

#### 3. Escape en correos electrónicos (`e()`)

Cuando se envía el mensaje de contacto por email, se usa la función `e()` de Laravel para escape adicional:

**Ejemplo real del proyecto** — Plantilla de email (`emails/contacto.blade.php`):

```blade
{{-- e() escapa HTML, nl2br() convierte saltos de línea en <br> --}}
{!! nl2br(e($mensaje)) !!}
```

Aquí se usa `{!! !!}` (sin escape) pero el contenido ya viene pre-escapado con `e()`, lo cual es seguro.

#### 4. Contenido no escapado (`{!! !!}`) — Usos seguros

El proyecto usa `{!! !!}` solo en los siguientes casos, todos seguros:

| Archivo | Uso | ¿Seguro? |
|---|---|---|
| `vendor/pagination/*.blade.php` | `{!! __('Showing') !!}` — Traducciones de Laravel | ✅ No es input de usuario |
| `emails/contacto.blade.php` | `{!! nl2br(e($mensaje)) !!}` — Pre-escapado con `e()` | ✅ Escapado manualmente |

**No hay ningún uso de `{!! !!}` con datos de usuario sin sanitizar.**

#### 5. Cabecera X-Requested-With (AJAX)

Axios se configura con la cabecera `X-Requested-With` para identificar peticiones AJAX legítimas:

```javascript
// resources/js/bootstrap.js
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

#### 6. Ausencia de innerHTML con datos de usuario

Se verificó que **ningún archivo JavaScript propio** usa `innerHTML`, `insertAdjacentHTML` o `document.write` con datos proporcionados por el usuario. El único uso de `innerHTML` se encuentra en la librería externa Swiper (`public/vendor/swiper/swiper-bundle.min.js`).

---

## 3.3 Comunicación entre Módulos

### ¿Cómo se comunican los módulos del proyecto?

La comunicación entre los diferentes módulos (Controllers, Models, Views) sigue patrones definidos por el framework Laravel:

### 1. Controller → View (Paso de datos a las vistas)

El controlador obtiene datos del modelo y los inyecta en la vista Blade. Se usan dos patrones:

**Patrón A: Array asociativo (preferido)**

```php
// HomeController.php — La página principal necesita datos de 4 modelos distintos
public function index()
{
    $slideBienvenidas = SlideBienvenida::orderBy('posicion')->get();
    $eventos = Evento::with('usuario:id,name')->orderBy('fecha_hora')->paginate(6);
    $libros = Libro::all();
    $noticias = Noticias::orderBy('created_at', 'desc')->paginate(4);

    // Envía las 4 colecciones a la vista como variables
    return view('bibliotecaDAW.index', [
        'slideBienvenidas' => $slideBienvenidas,
        'eventos' => $eventos,
        'libros' => $libros,
        'noticias' => $noticias,
    ]);
}
```

**Patrón B: Helper `compact()`**

```php
// EventosController.php — Pasa un solo modelo
public function paginaInterna($id)
{
    $evento = Evento::findOrFail($id);
    return view('bibliotecaDAW.publicViews.paginasInternas.paginaInternaEvento', compact('evento'));
}
```

### 2. View → Controller (Formularios y enlaces)

Las vistas envían datos al backend a través de formularios con token CSRF:

```blade
{{-- contacto.blade.php — El formulario envía datos al ContactoController --}}
<form method="POST" action="{{ route('contacto.enviar') }}">
    @csrf
    <input type="text" name="nombre" value="{{ old('nombre') }}">
    <input type="email" name="email" value="{{ old('email') }}">
    <textarea name="mensaje">{{ old('mensaje') }}</textarea>
    <button type="submit">Enviar</button>
</form>
```

### 3. Model → Controller (Eloquent Relationships / Eager Loading)

Los modelos definen relaciones que los controladores aprovechan con **Eager Loading** para evitar el problema N+1:

```php
// Modelo Evento — define la relación con Usuario
public function usuario(): BelongsTo
{
    return $this->belongsTo(Usuario::class, 'usuario_id');
}

// Controlador — carga los eventos CON su usuario en una sola consulta SQL
$eventos = Evento::with('usuario:id,name')->latest()->get();
// Esto genera: SELECT * FROM eventos + SELECT id, name FROM usuarios WHERE id IN (...)
// En lugar de: SELECT * FROM eventos + N consultas individuales de usuario
```

### 4. Controller → Controller (Redirecciones)

Los controladores no se llaman entre sí directamente. En su lugar, utilizan **redirecciones HTTP** con rutas nombradas:

```php
// Después de un login exitoso, redirige a la ruta del inicio de usuario
return redirect()->intended(route('usuario.inicio'));

// Después de guardar un contacto, redirige de vuelta con mensaje flash
return redirect()->back()->with('success', 'Tu mensaje ha sido enviado exitosamente.');
```

### 5. Layout → Secciones (Herencia de Blade)

El sistema de layouts permite que las vistas hijas inyecten contenido en el layout padre:

```blade
{{-- Layout padre (app.blade.php) — define los "huecos" --}}
<head>
    @stack('head')  {{-- Cola de CSS/meta adicionales --}}
</head>
<body>
    @include('layouts.header')  {{-- Componente reutilizable --}}
    @yield('content')           {{-- Contenido principal --}}
    @include('layouts.footer')
    @stack('scripts')           {{-- Cola de JS adicionales --}}
</body>

{{-- Vista hija (catalogo.blade.php) — rellena los huecos --}}
@extends('layouts.app')
@section('title', 'Catálogo')
@section('content')
    <h1>Catálogo de Libros</h1>
    {{-- contenido de la página --}}
@endsection
@push('scripts')
    <script>/* JS específico del catálogo */</script>
@endpush
```

### 6. Middleware → Request Pipeline

El middleware intercepta las peticiones ANTES de que lleguen al controlador. Es el mecanismo de comunicación entre la capa de seguridad y la capa de negocio:

```
Petición HTTP
    │
    ▼
┌──────────────────┐
│   auth:web       │ ← ¿Está logueado? Si no, redirige a /login
├──────────────────┤
│  bloquear.demo   │ ← ¿Es cuenta demo? Si sí, bloquea escritura
├──────────────────┤
│   Controller     │ ← Procesa la lógica de negocio
├──────────────────┤
│   Response       │ ← Devuelve vista Blade al navegador
└──────────────────┘
```

### 7. Model Events (Eventos del ciclo de vida)

Los modelos pueden ejecutar lógica automáticamente cuando ocurren eventos del ciclo de vida:

```php
// Usuario.php — Genera nSocio automáticamente al crear un nuevo usuario
protected static function booted()
{
    static::creating(function ($usuario) {
        $usuario->nSocio = self::generarNSocio();
    });
}
```

### 8. Sesiones (Comunicación entre peticiones)

Los controladores usan la sesión para pasar mensajes entre peticiones (flash messages):

```php
// ContactoController.php — Guarda mensaje de éxito en la sesión
return redirect()->back()->with('success', 'Tu mensaje ha sido enviado exitosamente.');
```

```blade
{{-- En la vista — Muestra el mensaje si existe en la sesión --}}
@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
```

---

## ⚡ Acciones Necesarias para Completar la Entrega

### Prioridad Alta (contenido obligatorio faltante)
1. **Añadir sección 1.2 Backend** — Copiar el contenido de este documento
2. **Añadir sección 1.3 Base de Datos** — Copiar el contenido de este documento
3. **Añadir sección 2.5 SQL Injection** — Copiar el contenido de este documento
4. **Añadir sección 2.7 XSS** — Copiar el contenido de este documento
5. **Añadir sección 3.3 Comunicación entre módulos** — Copiar el contenido de este documento

### Prioridad Media (funcionalidad faltante)
6. **Implementar Rate Limiting** — El código no lo tiene. Seguir los pasos de la sección 2.6 para implementarlo antes de documentarlo como "adoptado"

### Apunte
- Si no se va a implementar Rate Limiting antes de la entrega, en la sección 2.6 se puede documentar como *"medida pendiente de implementación"*, explicando qué es, por qué es importante, y cómo se implementaría, tal como se redacta arriba.
