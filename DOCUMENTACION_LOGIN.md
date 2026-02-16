# Documentación: Sistema de Login - Usuarios y Administradores

## Problema Identificado

El proyecto tiene dos sistemas de autenticación diferentes:
- **Usuarios normales**: pueden registrarse, iniciar sesión y acceder a su perfil
- **Administradores**: tienen acceso a un panel especial con funcionalidades de gestión

El problema era que **ambos usaban la misma vista de login** (`login.blade.php`), lo que causaba confusión y no permitía que los administradores accedieran correctamente al panel.

---

## Solución Implementada

### Paso 1: Crear una vista de login separada para administradores

Se creó la carpeta y archivo:
```
resources/views/admin/auth/login.blade.php
```

**Este archivo contiene:**
- Un formulario POST que envía datos a `admin.login.procesar`
- Campos: email y contraseña
- Opción de "Recuérdame"
- Un enlace para que usuarios normales accedan a su login

**Diferencia clave:**
```blade
<!-- Login de Admin -->
<form action="{{ route('admin.login.procesar') }}" method="POST">
```

vs

```blade
<!-- Login de Usuario Normal -->
<form action="{{ route('usuario.login.procesar') }}" method="POST">
```

### Paso 2: Actualizar la vista de login de usuarios normales

Se modificó:
```
resources/views/bibliotecaDAW/login.blade.php
```

**Cambios realizados:**
- ✅ Agregué validación de errores
- ✅ Agregué link al login de administrador
- ✅ Agregué link al registro
- ✅ Mejoré la presentación visual

**Nuevo contenido:**
```blade
<p><a href="{{ route('admin.login.mostrar') }}">¿Eres administrador? Inicia sesión aquí</a></p>
```

---

## Flujo de Autenticación

### Para Usuarios Normales

```
1. Usuario accede a: /login
   ↓
2. Ve el formulario (login.blade.php)
   ↓
3. Introduce email y contraseña
   ↓
4. Se envía POST a: route('usuario.login.procesar')
   ↓
5. LoginControllerUsuario valida credenciales
   ↓
6. Si es correcto → redirige a: /inicio (usuario.inicio)
   ↓
7. Usuario ve su panel: inicioLogin.blade.php
```

### Para Administradores

```
1. Admin accede a: /admin/login
   ↓
2. Ve el formulario (admin/auth/login.blade.php)
   ↓
3. Introduce email y contraseña
   ↓
4. Se envía POST a: route('admin.login.procesar')
   ↓
5. LoginControllerAdmin valida credenciales
   ↓
6. Si es correcto → redirige a: /admin (admin.dashboard)
   ↓
7. Admin ve el panel: Admin/administrador.blade.php
```

---

## Archivos Involucrados

### 1. Vistas (Views)

| Archivo                                         | Propósito                  | URL            |
| ----------------------------------------------- | -------------------------- | -------------- |
| `resources/views/bibliotecaDAW/login.blade.php` | Login de usuarios normales | `/login`       |
| `resources/views/admin/auth/login.blade.php`    | Login de administradores   | `/admin/login` |

### 2. Controladores (Controllers)

| Archivo                                                    | Métodos                                 | Propósito                  |
| ---------------------------------------------------------- | --------------------------------------- | -------------------------- |
| `app/Http/Controllers/Auth/LoginControllerUsuario.php`     | `mostrarLogin()`, `login()`, `logout()` | Gestiona login de usuarios |
| `app/Http/Controllers/Admin/Auth/LoginControllerAdmin.php` | `mostrarLogin()`, `login()`, `logout()` | Gestiona login de admins   |

### 3. Rutas (Routes)

En `routes/web.php`:

```php
// ===============================================
// LOGIN DE USUARIO NORMAL
// ===============================================
Route::get('/login', [LoginControllerUsuario::class, 'mostrarLogin'])->name('usuario.login.mostrar');
Route::post('/login', [LoginControllerUsuario::class, 'login'])->name('usuario.login.procesar');

// ===============================================
// LOGIN DE ADMINISTRADOR
// ===============================================
Route::get('/admin/login', [LoginControllerAdmin::class, 'mostrarLogin'])->name('admin.login.mostrar');
Route::post('/admin/login', [LoginControllerAdmin::class, 'login'])->name('admin.login.procesar');
```

### 4. Modelos (Models)

| Modelo               | Tabla      | Guard   |
| -------------------- | ---------- | ------- |
| `App\Models\Usuario` | `usuarios` | `web`   |
| `App\Models\Admin`   | `admins`   | `admin` |

---

## Guards - ¿Qué son?

Los **guards** son sistemas de autenticación separados. Laravel soporta tener múltiples tipos de usuarios.

En `config/auth.php`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',  // Usa tabla usuarios
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins', // Usa tabla admins
    ],
],
```

**Esto significa:**
- `Auth::guard('web')` → autentica contra tabla `usuarios`
- `Auth::guard('admin')` → autentica contra tabla `admins`

---

## Comparativa: Usuario vs Admin

| Acción       | Usuario Normal                     | Administrador                            |
| ------------ | ---------------------------------- | ---------------------------------------- |
| **Registro** | ✅ Puede registrarse en `/registro` | ❌ No puede auto-registrarse              |
| **Login**    | `/login` → LoginControllerUsuario  | `/admin/login` → LoginControllerAdmin    |
| **Panel**    | `/inicio` (inicioLogin.blade.php)  | `/admin` (Admin/administrador.blade.php) |
| **Logout**   | POST `/logout`                     | POST `/admin/logout`                     |
| **Table**    | `usuarios`                         | `admins`                                 |
| **Guard**    | `auth:web`                         | `auth:admin`                             |

---

## Cómo usar el sistema

### Usuario Normal

```
1. Ir a http://localhost/registro
2. Completar formulario
3. Se guarda en tabla "usuarios"
4. Ir a http://localhost/login
5. Ingresar email y contraseña
6. Accede a http://localhost/inicio
```

### Administrador

```
1. Admin debe estar inserido en tabla "admins"
   (NO hay auto-registro para admins)
2. Ir a http://localhost/admin/login
3. Ingresar email y contraseña del admin
4. Accede a http://localhost/admin
```

---

## Middleware de Protección

En `routes/web.php` se utilizan middlewares para proteger rutas:

```php
// Solo usuarios autenticados como usuarios normales
Route::middleware(['auth:web'])->group(function () {
    Route::get('/inicio', ...)->name('usuario.inicio');
    Route::get('/perfil', ...)->name('usuario.perfil');
    // ... más rutas
});

// Solo usuarios autenticados como administradores
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', ...)->name('admin.dashboard');
    Route::get('/admin/libros', ...)->name('admin.libros');
    // ... más rutas
});
```

Esto garantiza que:
- Un usuario normal NO puede acceder a `/admin`
- Un admin NO puede acceder a `/inicio`

---

## Errores Comunes y Soluciones

### Error: "Credenciales incorrectas"
- Verifica que el usuario está registrado en la tabla correcta
- Verifica que la contraseña es la correcta (están hasheadas)

### Error: "No se encuentra la ruta"
- Usuarios deben ir a `/login` (no `/admin/login`)
- Admins deben ir a `/admin/login` (no `/login`)

### Admin no llega al panel después de login
- Verifica que el admin existe en la tabla `admins`
- Verifica que el guard en `auth.php` está configurado correctamente

---

## Resumen de cambios

| Cambio                         | Archivo                                         | Tipo            |
| ------------------------------ | ----------------------------------------------- | --------------- |
| Crear vista login admin        | `resources/views/admin/auth/login.blade.php`    | ➕ Nuevo         |
| Actualizar vista login usuario | `resources/views/bibliotecaDAW/login.blade.php` | ✏️ Modificado    |
| Crear carpeta admin            | `resources/views/admin/auth/`                   | ➕ Nueva carpeta |

---

## Diagrama de flujo

```
                    ┌─────────────────┐
                    │   Visitante     │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │  ¿Quién eres?   │
                    └────────┬────────┘
                             │
            ┌────────────────┼────────────────┐
            │                │                │
      ┌─────▼──────┐   ┌────▼────┐    ┌─────▼──────┐
      │  Usuario   │   │  Admin   │    │ Sin cuenta │
      │  Normal    │   │          │    │   (nuevo)  │
      └─────┬──────┘   └────┬────┘    └─────┬──────┘
            │               │               │
       /login          /admin/login       /registro
            │               │               │
    ┌───────▼───────┐ ┌────▼────┐  ┌──────▼──────┐
    │ Valida contra │ │ Valida  │  │   Crea      │
    │ tabla usuarios│ │ contra  │  │   usuario   │
    │               │ │ tabla   │  │ en BD       │
    │               │ │ admins  │  │             │
    └───────┬───────┘ └────┬────┘  └──────┬──────┘
            │              │              │
     /inicio (usuario)  /admin   Redirige a /login
```

---

## Videos o Documentación Adicional

Para más información sobre autenticación en Laravel:
- [Laravel Authentication](https://laravel.com/docs/11.x/authentication)
- [Guards - Multiple User Models](https://laravel.com/docs/11.x/authentication#adding-custom-guards)

