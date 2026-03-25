# Entrega 8: Manuales del Proyecto — Sistema de Biblioteca Horae

**Proyecto:** Horae — Sistema de Gestión de Biblioteca  
**Módulo:** Desarrollo de Aplicaciones Web (2.º DAW)  
**Fecha:** Marzo 2026  

---

# PARTE 1: MANUAL DE USUARIO

---

## 1.1 Introducción

Horae es una plataforma web para la gestión integral de una biblioteca pública. Permite a los usuarios registrados consultar el catálogo de libros, alquilar o comprar ejemplares, inscribirse en eventos culturales y contactar con la biblioteca. Los administradores disponen de un panel completo de gestión de contenido, usuarios y libros.

Este manual está dirigido a **usuarios sin conocimientos técnicos**. Se describe cada pantalla, los pasos para realizar las acciones más habituales y las soluciones a los problemas más frecuentes.

---

## 1.2 Acceso a la Aplicación

Abra su navegador web (Chrome, Firefox o Edge) y escriba la dirección:

```
http://localhost:8000
```

Al acceder, será redirigido automáticamente a la **página de inicio** de la biblioteca (`/biblioteca`).

> **📸 Captura 1 — Página de Inicio (Landing Page):**  
> Realice una captura de pantalla de la página principal completa. Debe verse el carrusel de bienvenida con imágenes destacadas, la sección de eventos próximos, los libros destacados y las noticias recientes. Incluya el header con el menú de navegación y el footer.

---

## 1.3 Registro de un Nuevo Usuario

1. En la página de inicio, pulse el botón **"Registro"** del menú de navegación superior.
2. Se mostrará el formulario de registro con los siguientes campos:
   - **Nombre completo** (obligatorio).
   - **Correo electrónico** (obligatorio, debe ser único).
   - **DNI** (obligatorio, debe ser único).
   - **Teléfono móvil** (opcional, si se rellena debe ser único).
   - **Contraseña** (obligatorio, mínimo 8 caracteres).
   - **Confirmar contraseña** (debe coincidir con la anterior).
3. Rellene todos los campos obligatorios y pulse **"Registrarse"**.
4. Si los datos son correctos, se le redirigirá a la página de inicio con un mensaje de confirmación. El sistema generará automáticamente su **número de socio (nSocio)**, un código de 7 caracteres (5 dígitos + 2 letras) que le identificará como miembro.

> **📸 Captura 2 — Formulario de Registro:**  
> Capture el formulario de registro completo (`/registro`). Señale con flechas los campos obligatorios (nombre, email, DNI, contraseña, confirmación). Destaque el botón "Registrarse".

> **📸 Captura 3 — Mensaje de Registro Exitoso:**  
> Capture el mensaje flash de éxito que aparece tras registrarse correctamente.

---

## 1.4 Inicio de Sesión (Login)

1. Pulse **"Iniciar Sesión"** en el menú de navegación.
2. Introduzca su **correo electrónico** y **contraseña**.
3. Opcionalmente, marque la casilla **"Recordarme"** para mantener la sesión activa.
4. Pulse **"Entrar"**.
5. Si las credenciales son correctas, será redirigido al **panel de usuario** (`/inicioUsuario`).

> **📸 Captura 4 — Formulario de Login de Usuario:**  
> Capture la pantalla de login (`/login`). Señale los campos email y contraseña, la casilla "Recordarme" y el botón "Entrar".

---

## 1.5 Panel de Usuario (Dashboard)

Tras iniciar sesión, accederá a su panel personal donde podrá ver un resumen de su actividad. Desde el menú lateral o superior (según el dispositivo) encontrará las siguientes opciones:

| Opción del menú        | Descripción                                              |
|------------------------|----------------------------------------------------------|
| **Inicio**             | Panel principal del usuario                              |
| **Mi Perfil**          | Ver datos personales (nombre, email, DNI, nSocio)        |
| **Editar Perfil**      | Modificar datos personales                               |
| **Mis Consultas**      | Ver las consultas enviadas al formulario de contacto     |
| **Alquilar**           | Explorar libros disponibles para alquiler                |
| **Comprar**            | Explorar libros disponibles para compra                  |
| **Préstamos**          | Consultar préstamos activos                              |
| **Organizar Evento**   | Proponer o crear un evento en la biblioteca              |
| **Vender**             | Publicar un libro a la venta                             |
| **Publicar**           | Publicar contenido en la plataforma                      |
| **Cerrar Sesión**      | Finalizar la sesión actual                               |

> **📸 Captura 5 — Panel de Usuario (Dashboard):**  
> Capture la vista principal del usuario autenticado (`/inicioUsuario`). Debe verse el menú de navegación con todas las opciones disponibles.

> **📸 Captura 6 — Perfil de Usuario:**  
> Capture la pantalla de perfil (`/perfil`) mostrando los datos del usuario (nombre, email, DNI, número de socio).

---

## 1.6 Consultar el Catálogo de Libros

1. Desde el menú de navegación, pulse **"Catálogo"** (accesible sin iniciar sesión).
2. Se mostrará un listado de libros con paginación (12 libros por página).
3. Utilice los **filtros de búsqueda** para encontrar libros:
   - **Búsqueda general:** Busca simultáneamente por título y autor.
   - **Por título:** Filtra libros que contengan el texto indicado en el título.
   - **Por autor:** Filtra por nombre del autor.
   - **Por género:** Filtra por categoría literaria.
4. Los filtros se pueden combinar entre sí. Pulse **"Buscar"** para aplicarlos.
5. Cada libro muestra: portada, título, autor, género, año, editorial, disponibilidad, formato (físico/digital/ambos) y opción de compra o préstamo.

> **📸 Captura 7 — Catálogo de Libros:**  
> Capture la vista del catálogo (`/catalogo`) con varios libros visibles. Señale la zona de filtros de búsqueda (campo de búsqueda, selectores de título/autor/género) y el botón "Buscar".

> **📸 Captura 8 — Catálogo con Filtro Aplicado:**  
> Realice una búsqueda (por ejemplo, por género "Ficción") y capture los resultados filtrados.

---

## 1.7 Consultar Actividades y Eventos

1. Pulse **"Actividades"** en el menú de navegación.
2. Se mostrará el listado de eventos programados (6 por página).
3. Cada evento muestra: título, descripción, fecha y hora, ubicación e imagen.

> **📸 Captura 9 — Listado de Actividades/Eventos:**  
> Capture la vista de actividades (`/actividades`) con varios eventos visibles.

---

## 1.8 Enviar un Formulario de Contacto

1. Pulse **"Contacto"** en el menú de navegación.
2. Rellene los campos del formulario:
   - **Nombre** (obligatorio).
   - **Correo electrónico** (obligatorio, formato válido).
   - **Asunto** (obligatorio).
   - **Mensaje** (obligatorio).
3. Pulse **"Enviar"**.
4. Si el envío es correcto, verá un mensaje de confirmación. El mensaje quedará almacenado y la biblioteca recibirá una notificación por correo electrónico.
5. Si está autenticado, podrá consultar sus mensajes en **"Mis Consultas"** (`/mis-consultas`).

> **📸 Captura 10 — Formulario de Contacto:**  
> Capture el formulario de contacto (`/contacto`) con todos los campos visibles. Señale los campos obligatorios y el botón "Enviar".

> **📸 Captura 11 — Mensaje de Contacto Enviado con Éxito:**  
> Capture el mensaje flash de confirmación tras enviar el formulario.

---

## 1.9 Consultar Servicios Digitales

1. Pulse **"Servicios Digitales"** en el menú de navegación.
2. Se mostrará la información sobre los servicios digitales disponibles en la biblioteca.

> **📸 Captura 12 — Servicios Digitales:**  
> Capture la pantalla de servicios digitales (`/serviciosDigitales`).

---

## 1.10 Cerrar Sesión

1. Pulse **"Cerrar Sesión"** en el menú de navegación.
2. Su sesión se cerrará de forma segura y será redirigido a la página de login.

---

## 1.11 Guía para Administradores

### 1.11.1 Acceso al Panel de Administración

1. Navegue a la dirección: `http://localhost:8000/admin/login`.
2. Introduzca las credenciales de administrador (correo electrónico y contraseña).
3. Pulse **"Entrar"**.
4. Será redirigido al **panel de administración** (`/admin`).

> **📸 Captura 13 — Login de Administrador:**  
> Capture la pantalla de login de administrador (`/admin/login`). Es un formulario independiente del login de usuario normal.

> **📸 Captura 14 — Panel de Administración (Dashboard):**  
> Capture el panel principal de administración (`/admin`) mostrando el menú lateral con todas las secciones de gestión y el conteo de mensajes de contacto.

### 1.11.2 Funciones del Panel de Administración

El administrador dispone de las siguientes secciones:

**Gestión de Contenido Web:**

| Sección                    | Ruta                       | Acciones                                      |
|----------------------------|----------------------------|-----------------------------------------------|
| Gestionar Home             | `/admin/gestionHome`       | Editar contenido de la página principal        |
| Gestionar Carrusel         | `/admin/gestionCarrusel`   | Crear, editar y eliminar eventos del carrusel  |
| Gestionar Noticias         | `/admin/gestionNoticias`   | Administrar noticias y artículos               |
| Gestionar Actividades      | `/admin/gestionActividades`| Administrar eventos y actividades              |
| Gestionar Servicios        | `/admin/gestionServicios`  | Administrar servicios digitales                |
| Gestionar Header/Footer    | `/admin/gestionHeader`     | Editar cabecera y pie de página                |

> **📸 Captura 15 — Gestión del Carrusel (Crear/Editar Evento):**  
> Capture la vista de gestión del carrusel (`/admin/gestionCarrusel`) mostrando el listado de eventos y el formulario de creación/edición. Señale con flechas los botones "Crear", "Editar" y "Eliminar".

**Gestión de Libros:**

| Sección                    | Ruta                       | Acciones                                      |
|----------------------------|----------------------------|-----------------------------------------------|
| Gestionar Libros           | `/admin/gestionarLibros`   | CRUD del catálogo de libros                    |
| Libros Nuevos              | `/admin/librosNuevos`      | Ver nuevas adquisiciones                       |
| Libros Perdidos            | `/admin/librosPerdidos`    | Registrar libros perdidos                      |
| Inventario                 | `/admin/inventario`        | Control de stock de ejemplares                 |
| Libros Prestados           | `/admin/librosPrestados`   | Ver libros actualmente en préstamo             |

> **📸 Captura 16 — Gestión de Libros:**  
> Capture la pantalla de gestión de libros (`/admin/gestionarLibros`) con el listado y las opciones CRUD.

**Gestión de Usuarios:**

| Sección                    | Ruta                          | Acciones                                   |
|----------------------------|-------------------------------|--------------------------------------------|
| Gestionar Usuarios         | `/admin/gestionUsuarios`      | Ver y administrar cuentas de usuario       |
| Sanciones                  | `/admin/gestionSanciones`     | Gestionar sanciones                        |
| Historial Reservas         | `/admin/historialReservas`    | Consultar historial de reservas            |
| Reservas Activas           | `/admin/reservasActivas`      | Ver reservas en curso                      |
| Dar de baja usuario        | `/admin/darBaja/{id}`         | Desactivar cuenta de usuario               |

> **📸 Captura 17 — Gestión de Usuarios:**  
> Capture la pantalla de gestión de usuarios (`/admin/gestionUsuarios`).

**Mensajes de Contacto:**

| Sección                    | Ruta                          | Acciones                                   |
|----------------------------|-------------------------------|--------------------------------------------|
| Ver Mensajes               | `/admin/mensajes`             | Listado paginado de mensajes recibidos     |
| Cambiar Estado             | `/admin/mensajes/{id}/estado` | Marcar como pendiente/en proceso/leído     |
| Eliminar Mensaje           | `/admin/mensajes/{id}`        | Borrar mensaje                             |

> **📸 Captura 18 — Gestión de Mensajes de Contacto:**  
> Capture la lista de mensajes (`/admin/mensajes`) mostrando los estados (pendiente, en proceso, leído). Señale los botones de cambio de estado y eliminación.

**Roles y Permisos:**

- Sección: `/admin/gestionRoles`  
- El sistema soporta tres roles de administrador: **Superadmin**, **Editor** y **Moderador**.

> **📸 Captura 19 — Roles y Permisos:**  
> Capture la pantalla de gestión de roles (`/admin/gestionRoles`).

---

## 1.12 Solución de Problemas Comunes

### Problema: "No puedo iniciar sesión"
- **Causa probable:** Correo electrónico o contraseña incorrectos.
- **Solución:** Verifique que escribe el correo exacto con el que se registró. La contraseña distingue entre mayúsculas y minúsculas. Si olvidó su contraseña, contacte con la biblioteca.

### Problema: "Error de conexión a la base de datos al iniciar sesión"
- **Causa probable:** El servidor de base de datos no está arrancado.
- **Solución:** Contacte con el soporte técnico de la biblioteca. Si es el administrador, asegúrese de que el servicio MySQL de XAMPP está activo.

### Problema: "El registro dice que mi email o DNI ya existe"
- **Causa probable:** Ya existe una cuenta con ese email o DNI.
- **Solución:** Intente iniciar sesión con esos datos. Si no recuerda su contraseña, contacte con soporte.

### Problema: "El formulario de contacto dice que hay un error"
- **Causa probable:** Algún campo obligatorio está vacío o el email no tiene formato válido.
- **Solución:** Revise que todos los campos marcados como obligatorios están rellenados y que el correo tiene formato correcto (ejemplo@dominio.com).

### Problema: "La página aparece en blanco o con error 500"
- **Causa probable:** Error interno del servidor.
- **Solución:** Recargue la página (F5). Si persiste, cierre sesión y vuelva a entrar. Si el error continúa, contacte con soporte técnico.

### Problema: "No encuentro un libro en el catálogo"
- **Causa probable:** El filtro de búsqueda es demasiado restrictivo.
- **Solución:** Pruebe a buscar solo por una parte del título o autor. Elimine filtros adicionales (género) para ampliar los resultados.

### Problema: "La página no carga correctamente (estilos rotos)"
- **Causa probable:** Los archivos CSS/JS no se han compilado o el servidor Vite no está activo.
- **Solución:** Si es el administrador técnico, ejecute `npm run build` o inicie el servidor de desarrollo con `npm run dev`.

> **📸 Captura 20 — Ejemplo de Error de Validación:**  
> Capture un intento de login con credenciales incorrectas mostrando el mensaje de error. También capture un formulario de registro con campos vacíos para mostrar los mensajes de validación en rojo.

---

# PARTE 2: MANUAL DEL PROGRAMADOR

---

## 2.1 Requisitos Técnicos del Sistema

### Software necesario para el entorno de desarrollo:

| Requisito           | Versión mínima   | Descripción                                              |
|---------------------|-------------------|----------------------------------------------------------|
| **PHP**             | 8.2+              | Lenguaje del backend. El proyecto usa PHP 8.3.           |
| **Composer**        | 2.x               | Gestor de dependencias PHP.                              |
| **Node.js**         | 18+ (LTS)         | Necesario para compilar assets frontend con Vite.        |
| **npm**             | 9+                | Gestor de paquetes JavaScript (incluido con Node.js).    |
| **MySQL**           | 8.0+              | Sistema de gestión de base de datos relacional.          |
| **XAMPP**           | 8.2+              | Paquete integrado (Apache + MySQL + PHP) para Windows.   |
| **Git**             | 2.x               | Control de versiones.                                    |

### Extensiones PHP requeridas:
- `pdo_mysql` — Conexión a MySQL.
- `mbstring` — Soporte multibyte para strings.
- `openssl` — Encriptación y hashing.
- `tokenizer` — Análisis sintáctico de PHP.
- `xml` — Procesamiento de documentos XML.
- `ctype`, `json`, `fileinfo`, `bcmath` — Funcionalidades core de Laravel.

> **Nota:** XAMPP incluye todas estas extensiones habilitadas por defecto.

---

## 2.2 Configuración Inicial del Proyecto

### Paso 1: Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO> ProyectoBiblioteca-2DAW
cd ProyectoBiblioteca-2DAW
```

### Paso 2: Instalar dependencias PHP

```bash
composer install
```

Esto descargará todas las dependencias definidas en `composer.json`: Laravel 12, Tinker, PHPUnit, Faker, Pint, etc.

### Paso 3: Configurar el archivo de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edite el archivo `.env` con los datos de su base de datos:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=
```

### Paso 4: Crear la base de datos

Abra phpMyAdmin (http://localhost/phpmyadmin) o la consola MySQL y cree la base de datos:

```sql
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Paso 5: Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará todas las tablas (usuarios, admin, libros, eventos, noticias, contactos, metodos_pago, slide_bienvenidas) y cargará datos de prueba, incluyendo:
- **3 cuentas de administrador**: admin@test.com (superadmin), editor@test.com (editor), moderador@test.com (moderador).
- Libros, eventos, noticias y slides de ejemplo.

### Paso 6: Instalar dependencias frontend

```bash
npm install
```

Instala: Vite 7, Axios, laravel-vite-plugin y concurrently.

### Paso 7: Compilar assets

Para desarrollo (con recarga en caliente):

```bash
npm run dev
```

Para producción:

```bash
npm run build
```

### Paso 8: Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`.

### Comando rápido (todo en uno):

El proyecto incluye un script `composer setup` que ejecuta todos los pasos:

```bash
composer setup
```

Y un script `composer dev` que arranca simultáneamente el servidor, cola de trabajos, visor de logs y Vite:

```bash
composer dev
```

---

## 2.3 Arquitectura del Sistema

### Patrón: MVC (Modelo-Vista-Controlador)

```
ProyectoBiblioteca-2DAW/
├── app/
│   ├── Http/Controllers/          ← Controladores (lógica de peticiones)
│   │   ├── HomeController.php           → Página de inicio
│   │   ├── LibroController.php          → Catálogo de libros
│   │   ├── EventosController.php        → Gestión de eventos/carrusel
│   │   ├── ContactoController.php       → Formulario de contacto
│   │   ├── NoticiasController.php       → Noticias (placeholder)
│   │   ├── Auth/
│   │   │   ├── LoginControllerUsuario.php  → Login de usuarios
│   │   │   └── UsuarioController.php       → Registro de usuarios
│   │   └── Admin/Auth/
│   │       └── LoginControllerAdmin.php    → Login de administradores
│   ├── Mail/
│   │   └── ContactoRecibido.php       ← Mailable para notificaciones
│   └── Models/                        ← Modelos Eloquent ORM
│       ├── Usuario.php                  → Usuarios registrados
│       ├── Admin.php                    → Administradores
│       ├── Libro.php                    → Libros del catálogo
│       ├── Evento.php                   → Eventos y actividades
│       ├── Noticias.php                 → Noticias
│       ├── Contacto.php                 → Mensajes de contacto
│       ├── SlideBienvenida.php          → Slides del carrusel
│       └── MetodosPago.php              → Métodos de pago
│
├── resources/
│   ├── views/                         ← Vistas Blade
│   │   ├── layouts/                     → Layouts maestros (app, header, footer, nav)
│   │   └── bibliotecaDAW/
│   │       ├── index.blade.php          → Landing page
│   │       ├── publicViews/             → Vistas públicas (login, registro, catálogo, contacto)
│   │       ├── userViews/               → Vistas de usuario autenticado (perfil, préstamos)
│   │       └── adminViews/              → Panel de administración
│   │           ├── GestionarContenidoWeb/  → Gestión de contenido
│   │           ├── GestionarLibros/        → Gestión de libros
│   │           ├── GestionarUsuarios/      → Gestión de usuarios
│   │           ├── GestionarRoles/         → Roles y permisos
│   │           └── mensajes/               → Mensajes de contacto
│   ├── css/
│   │   ├── app.css                    → Entrada principal CSS (importa variables y sobreescrituras)
│   │   └── sobreescribirBoostrap.css  → Override de estilos Bootstrap
│   └── js/
│       ├── app.js                     → Entrada principal JS (importa módulos)
│       ├── bootstrap.js               → Configuración de Axios
│       ├── iniciarSwiper.js           → Inicialización del carrusel Swiper
│       └── mediaQuery*.js            → Scripts responsivos para cada tipo de navegación
│
├── routes/
│   └── web.php                        ← Definición de todas las rutas
│
├── database/
│   ├── migrations/                    ← Migraciones de esquema
│   ├── seeders/                       ← Datos de prueba
│   └── factories/                     ← Fábricas para testing
│
├── config/                            ← Configuración de Laravel
│   └── auth.php                         → Configuración multi-guard (web + admin)
│
├── public/                            ← Directorio público (Apache DocumentRoot)
│   ├── index.php                        → Punto de entrada
│   ├── build/                           → Assets compilados por Vite
│   └── img/                             → Imágenes estáticas
│
└── tests/                             ← Tests automatizados (PHPUnit)
    ├── Feature/                         → Tests funcionales
    └── Unit/                            → Tests unitarios
```

### Componentes Clave del Backend

**Sistema de Autenticación Dual (Multi-Guard):**

El proyecto implementa dos guards de autenticación independientes definidos en `config/auth.php`:

- **Guard `web`** → Modelo `Usuario` → Tabla `usuarios`: Para usuarios registrados de la biblioteca.
- **Guard `admin`** → Modelo `Admin` → Tabla `admin`: Para administradores con roles (superadmin, editor, moderador).

Cada guard tiene su propio controlador de login, su propia lógica de sesión y sus propias rutas protegidas por middleware (`auth:web` y `auth:admin` respectivamente).

**Modelos principales y sus relaciones:**

- `Usuario` — Genera automáticamente un número de socio (`nSocio`) al crearse. Hash automático de contraseña.
- `Admin` — Soporta tres roles. Registra fecha de último login (`last_login`).
- `Libro` — Enumeraciones para disponibilidad (`disponible`/`prestado`), formato (`fisico`/`digital`/`ambos`) y opción de compra/préstamo.
- `Evento` — Relación BelongsTo con Usuario. Campo computado `plazas_libres` (aforo - asistentes). Prioridad (baja/media/alta).
- `Contacto` — Estado del mensaje (pendiente → en_proceso → leído).
- `MetodosPago` — Token de pago encriptado con Laravel Encryption. Relación BelongsTo con Usuario.

**Sistema de Email:**

La clase `ContactoRecibido` (Mailable) envía notificaciones cuando un usuario envía el formulario de contacto. El email incluye los datos del remitente y permite responder directamente gracias al campo ReplyTo.

### Componentes Clave del Frontend

- **Layout Blade** (`layouts/app.blade.php`): Layout maestro que carga Bootstrap 5.3.3 vía CDN, incluye header, footer y navegación condicional según el guard autenticado.
- **Vite**: Procesa `resources/css/app.css` y `resources/js/app.js` como puntos de entrada. Genera los bundles en `public/build/`.
- **Variables CSS personalizadas** (`resources/css/variables.css`): Sistema de tokens de diseño. Todo el estilo se basa en variables CSS (colores, sombras, espaciado).
- **JavaScript Vanilla**: Sin frameworks JS (React, Vue, etc.). Usa funciones flecha, módulos ES6 y scripts de media queries para responsive.

---

## 2.4 Esquema de la Base de Datos

### Tablas principales:

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────────┐
│     usuarios      │     │      admin        │     │     libros        │
├──────────────────┤     ├──────────────────┤     ├──────────────────┤
│ id (PK)          │     │ id (PK)          │     │ id (PK)          │
│ name             │     │ name             │     │ titulo           │
│ email (unique)   │     │ email (unique)   │     │ autor            │
│ dni (unique)     │     │ password          │     │ genero           │
│ movil (unique?)  │     │ last_login       │     │ anio             │
│ password         │     │ rol (enum)       │     │ editorial        │
│ nSocio (unique)  │     │ remember_token   │     │ disponibilidad   │
│ remember_token   │     │ timestamps       │     │ formato (enum)   │
│ timestamps       │     └───────┬──────────┘     │ opcion_compra    │
└───────┬──────────┘             │                 │ cantidad_ejemplares│
        │                        │                 │ isbn (unique)    │
        │ 1:N                    │ 1:N             │ portada_img      │
        ▼                        ▼                 │ timestamps       │
┌──────────────────┐     ┌──────────────────┐     └──────────────────┘
│     eventos       │     │    noticias       │
├──────────────────┤     ├──────────────────┤     ┌──────────────────┐
│ id (PK)          │     │ id (PK)          │     │   contactos       │
│ titulo           │     │ titulo           │     ├──────────────────┤
│ descripcion      │     │ contenido        │     │ id (PK)          │
│ fecha_hora       │     │ autor            │     │ nombre           │
│ ubicacion        │     │ fecha_publicacion│     │ email            │
│ aforo            │     │ imagen_url       │     │ asunto           │
│ asistentes       │     │ destacado (bool) │     │ mensaje          │
│ plazas_libres    │     │ categoria        │     │ estado (enum)    │
│ imagen_url       │     │ enlace_externo   │     │ timestamps       │
│ usuario_id (FK)──┤     │ admin_id (FK)────┤     └──────────────────┘
│ prioridad        │     │ timestamps       │
│ timestamps       │     └──────────────────┘     ┌──────────────────┐
└──────────────────┘                               │  metodos_pago     │
                         ┌──────────────────┐     ├──────────────────┤
                         │ slide_bienvenidas │     │ id (PK)          │
                         ├──────────────────┤     │ usuario_id (FK)──┤
                         │ id (PK)          │     │ type (enum)      │
                         │ titulo           │     │ provider         │
                         │ descripcion      │     │ token (encrypted)│
                         │ imagen           │     │ last_four        │
                         │ url              │     │ paypal_email     │
                         │ timestamps       │     │ timestamps       │
                         └──────────────────┘     └──────────────────┘
```

**Relaciones con claves foráneas:**
- `eventos.usuario_id` → `usuarios.id` (CASCADE ON DELETE)
- `noticias.admin_id` → `admin.id` (SET NULL ON DELETE)
- `metodos_pago.usuario_id` → `usuarios.id` (CASCADE ON DELETE)

---

## 2.5 Rutas de la API / Web

### Rutas Públicas (sin autenticación):

| Método | URI                  | Controlador                      | Función            |
|--------|----------------------|----------------------------------|---------------------|
| GET    | `/`                  | Redirect → `/biblioteca`         | Redirección          |
| GET    | `/biblioteca`        | HomeController@index             | Página de inicio     |
| GET    | `/catalogo`          | LibroController@catalogo         | Catálogo de libros   |
| GET    | `/actividades`       | Closure (paginación de Evento)   | Listado de eventos   |
| GET    | `/contacto`          | ContactoController@create        | Formulario contacto  |
| POST   | `/contacto`          | ContactoController@store         | Enviar contacto      |
| GET    | `/serviciosDigitales`| Closure                          | Servicios digitales  |
| GET    | `/login`             | LoginControllerUsuario@mostrarLogin | Login usuario     |
| POST   | `/login`             | LoginControllerUsuario@login     | Procesar login       |
| GET    | `/registro`          | UsuarioController@showRegistro   | Registro usuario     |
| POST   | `/registro`          | UsuarioController@store          | Crear usuario        |
| GET    | `/admin/login`       | LoginControllerAdmin@mostrarLogin| Login admin          |
| POST   | `/admin/login`       | LoginControllerAdmin@login       | Procesar login admin |

### Rutas Protegidas — Usuario (`auth:web`):

| Método | URI              | Función                        |
|--------|------------------|--------------------------------|
| GET    | `/inicioUsuario` | Dashboard de usuario           |
| GET    | `/perfil`        | Ver perfil                     |
| GET    | `/perfilEditar`  | Formulario editar perfil       |
| PUT    | `/perfilEditar`  | Guardar cambios perfil         |
| GET    | `/mis-consultas` | Consultas del usuario          |
| GET    | `/alquilar`      | Alquilar libros                |
| GET    | `/prestamos`     | Ver préstamos                  |
| GET    | `/comprar`       | Comprar libros                 |
| GET    | `/organizarEvento`| Organizar evento              |
| GET    | `/vender`        | Vender libros                  |
| GET    | `/publicar`      | Publicar contenido             |
| POST   | `/logout`        | Cerrar sesión                  |

### Rutas Protegidas — Administrador (`auth:admin`):

| Método | URI                              | Función                        |
|--------|----------------------------------|--------------------------------|
| GET    | `/admin`                         | Dashboard admin                |
| GET    | `/admin/gestionRoles`            | Gestión roles y permisos       |
| GET    | `/admin/gestionHome`             | Gestión página inicio          |
| GET    | `/admin/gestionCarrusel`         | Gestión carrusel (lista)       |
| POST   | `/admin/gestionCarrusel`         | Crear evento carrusel          |
| PUT    | `/admin/gestionCarrusel/{id}`    | Editar evento carrusel         |
| DELETE | `/admin/gestionCarrusel/{id}`    | Eliminar evento carrusel       |
| GET    | `/admin/gestionNoticias`         | Gestión noticias               |
| GET    | `/admin/gestionActividades`      | Gestión actividades            |
| GET    | `/admin/gestionServicios`        | Gestión servicios              |
| GET    | `/admin/gestionCatalogo`         | Gestión catálogo               |
| GET    | `/admin/gestionHeader`           | Gestión header                 |
| GET    | `/admin/gestionFooter`           | Gestión footer                 |
| GET    | `/admin/gestionUsuarios`         | Gestión usuarios               |
| GET    | `/admin/gestionSanciones`        | Gestión sanciones              |
| GET    | `/admin/historialReservas`       | Historial reservas             |
| GET    | `/admin/reservasActivas`         | Reservas activas               |
| GET    | `/admin/publicacionesUser`       | Publicaciones usuarios         |
| POST   | `/admin/darBaja/{id}`            | Dar de baja usuario            |
| GET    | `/admin/gestionarCancelaciones`  | Gestionar cancelaciones        |
| GET    | `/admin/gestionarLibros`         | Gestionar libros               |
| GET    | `/admin/librosNuevos`            | Libros nuevos                  |
| GET    | `/admin/librosPerdidos`          | Libros perdidos                |
| GET    | `/admin/inventario`              | Inventario                     |
| GET    | `/admin/librosPrestados`         | Libros prestados               |
| GET    | `/admin/mensajes`                | Mensajes de contacto           |
| PATCH  | `/admin/mensajes/{id}/estado`    | Cambiar estado mensaje         |
| DELETE | `/admin/mensajes/{contacto}`     | Eliminar mensaje               |
| GET    | `/admin/gestionContacto`         | Gestión contacto               |
| POST   | `/admin/logout`                  | Cerrar sesión admin            |

---

## 2.6 Ejecución de Tests

El proyecto utiliza PHPUnit 11.5 como framework de testing.

```bash
# Ejecutar todos los tests
php artisan test

# O usando PHPUnit directamente
./vendor/bin/phpunit

# Limpiar caché y ejecutar tests (script definido)
composer test
```

Los tests se encuentran en:
- `tests/Feature/` — Tests funcionales (rutas, controladores, flujos completos).
- `tests/Unit/` — Tests unitarios (modelos, lógica aislada).

Las fábricas (factories) disponibles para generar datos de prueba son:
- `UsuarioFactory` — Genera usuarios con datos aleatorios.
- `EventosFactory` — Genera eventos con fechas futuras.
- `LibroFactory` — Genera libros con datos ficticios.
- `UserFactory` — Factory por defecto de Laravel (no se usa activamente).

---

## 2.7 Guía de Despliegue en Servidor (VPS con Apache)

### Requisitos del servidor:
- **Sistema operativo:** Ubuntu 22.04 LTS o superior.
- **Servidor web:** Apache 2.4 con `mod_rewrite` habilitado.
- **PHP:** 8.2+ con extensiones: pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo, bcmath, curl.
- **MySQL:** 8.0+.
- **Composer:** 2.x.
- **Node.js:** 18+ LTS (solo para compilar assets).

### Pasos de despliegue:

**1. Preparar el servidor:**

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 mysql-server php8.3 php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-bcmath php8.3-tokenizer php8.3-fileinfo unzip git -y
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**2. Instalar Composer:**

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**3. Instalar Node.js (para compilar assets):**

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

**4. Clonar el proyecto:**

```bash
cd /var/www
sudo git clone <URL_REPOSITORIO> biblioteca
cd biblioteca
```

**5. Instalar dependencias y configurar:**

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
cp .env.example .env
php artisan key:generate
```

**6. Configurar `.env` para producción:**

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=biblioteca_user
DB_PASSWORD=contraseña_segura

MAIL_MAILER=smtp
MAIL_HOST=smtp.tuproveedor.com
MAIL_PORT=587
MAIL_USERNAME=correo@tudominio.com
MAIL_PASSWORD=contraseña_correo
MAIL_ENCRYPTION=tls
```

**7. Crear la base de datos y migrar:**

```bash
sudo mysql -u root -p
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'biblioteca_user'@'localhost' IDENTIFIED BY 'contraseña_segura';
GRANT ALL PRIVILEGES ON biblioteca.* TO 'biblioteca_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

php artisan migrate --force
php artisan db:seed  # Solo si desea datos de prueba
```

**8. Permisos de carpetas:**

```bash
sudo chown -R www-data:www-data /var/www/biblioteca
sudo chmod -R 755 /var/www/biblioteca
sudo chmod -R 775 /var/www/biblioteca/storage
sudo chmod -R 775 /var/www/biblioteca/bootstrap/cache
```

**9. Configurar VirtualHost de Apache:**

Crear archivo `/etc/apache2/sites-available/biblioteca.conf`:

```apache
<VirtualHost *:80>
    ServerName tudominio.com
    DocumentRoot /var/www/biblioteca/public

    <Directory /var/www/biblioteca/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/biblioteca_error.log
    CustomLog ${APACHE_LOG_DIR}/biblioteca_access.log combined
</VirtualHost>
```

```bash
sudo a2ensite biblioteca.conf
sudo a2dissite 000-default.conf
sudo systemctl restart apache2
```

**10. Optimizar para producción:**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Despliegue alternativo con Nginx:

Si prefiere Nginx, el bloque de servidor sería:

```nginx
server {
    listen 80;
    server_name tudominio.com;
    root /var/www/biblioteca/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

# PARTE 3: METODOLOGÍAS Y TECNOLOGÍAS

---

## 3.1 Tecnologías Detectadas en el Proyecto

### Backend

| Tecnología         | Versión    | Uso en el proyecto                                           |
|--------------------|------------|--------------------------------------------------------------|
| **PHP**            | 8.2+       | Lenguaje principal del servidor                              |
| **Laravel**        | 12.0       | Framework MVC para el backend completo                       |
| **Eloquent ORM**   | (Laravel)  | Interacción con la base de datos mediante modelos            |
| **Blade**          | (Laravel)  | Motor de plantillas para generar HTML dinámico               |
| **Artisan**        | (Laravel)  | CLI para migraciones, seeders, caché y servidor de desarrollo|

### Frontend

| Tecnología              | Versión    | Uso en el proyecto                                      |
|-------------------------|------------|---------------------------------------------------------|
| **HTML5**               | —          | Estructura semántica de todas las vistas                |
| **CSS3**                | —          | Estilos personalizados con variables CSS (:root tokens) |
| **JavaScript (Vanilla)**| ES6+       | Funcionalidades interactivas (carrusel, responsive nav) |
| **Bootstrap**           | 5.3.3      | Framework CSS para layout (grid) y componentes UI       |
| **Bootstrap Icons**     | 1.11.3     | Iconografía de la interfaz                              |

### Base de Datos

| Tecnología   | Versión   | Uso en el proyecto                              |
|--------------|-----------|--------------------------------------------------|
| **MySQL**    | 8.0+      | Base de datos relacional principal               |

### Herramientas de Build

| Herramienta              | Versión   | Uso en el proyecto                              |
|--------------------------|-----------|--------------------------------------------------|
| **Vite**                 | 7.0.7     | Bundler de assets CSS y JS con HMR              |
| **laravel-vite-plugin**  | 2.0.0     | Integración de Vite con Laravel                  |
| **Axios**                | 1.11.0    | Cliente HTTP para peticiones AJAX (configurado)  |
| **Concurrently**         | 9.0.1     | Ejecutar múltiples procesos en paralelo (dev)    |
| **Composer**             | 2.x       | Gestor de dependencias PHP                       |
| **npm**                  | 9+        | Gestor de dependencias JavaScript                |

### Testing

| Herramienta              | Versión   | Uso en el proyecto                              |
|--------------------------|-----------|--------------------------------------------------|
| **PHPUnit**              | 11.5.3    | Framework de testing para PHP                    |
| **Mockery**              | 1.6+      | Librería de mocking para tests                   |
| **Faker**                | 1.23+     | Generación de datos ficticios para testing       |
| **Laravel Pint**         | 1.24+     | Formateador de código PHP (estilo PSR-12)        |
| **Collision**            | 8.6+      | Mejor visualización de errores en consola        |

---

## 3.2 Herramientas de Desarrollo Utilizadas

| Herramienta           | Propósito                                                           |
|-----------------------|---------------------------------------------------------------------|
| **Visual Studio Code**| Editor de código principal con extensiones para PHP, Blade y CSS    |
| **GitHub Copilot**    | Asistente de IA para autocompletar y generar código                 |
| **Git**               | Control de versiones distribuido                                     |
| **GitHub**            | Plataforma de alojamiento del repositorio y colaboración            |
| **XAMPP**             | Entorno local de desarrollo (Apache + MySQL + PHP para Windows)     |
| **phpMyAdmin**        | Interfaz web para administrar MySQL (incluido en XAMPP)             |
| **Navegador Web**     | Chrome/Firefox para pruebas y depuración (DevTools)                 |
| **Laravel Pail**      | Visor de logs en tiempo real desde la terminal                      |
| **Laravel Tinker**    | Consola REPL para interactuar con la aplicación en tiempo real      |

---

## 3.3 Metodología de Desarrollo

El proyecto sigue un enfoque de **desarrollo iterativo incremental**, donde las funcionalidades se implementan y entregan en fases sucesivas (entregas). Cada entrega añade nuevas funcionalidades sobre la base anterior.

### Principios aplicados:
- **MVC (Modelo-Vista-Controlador):** Separación estricta entre lógica de negocio (modelos), presentación (vistas Blade) y control de flujo (controladores).
- **DRY (Don't Repeat Yourself):** Reutilización de layouts, componentes Blade (`@include`) y variables CSS centralizadas.
- **Convenciones de Laravel:** Uso de migraciones para esquema, seeders para datos de prueba, factories para testing, guards para autenticación múltiple.
- **Seguridad:** Validación de datos en servidor (`$request->validate()`), protección CSRF en formularios (`@csrf`), hasheo automático de contraseñas (bcrypt), encriptación de tokens de pago, sanitización de HTML en entradas del usuario.
- **Accesibilidad:** Etiquetas semánticas HTML5 (`<main>`, `<section>`, `<header>`, `<footer>`), jerarquía de encabezados, skip links.

---

## 3.4 Resumen de Capturas de Pantalla Recomendadas

| N.º | Pantalla | Ruta | Descripción de la captura |
|-----|----------|------|---------------------------|
| 1 | Página de Inicio | `/biblioteca` | Carrusel, eventos, libros y noticias |
| 2 | Formulario de Registro | `/registro` | Campos obligatorios señalados |
| 3 | Registro Exitoso | `/biblioteca` | Mensaje flash de confirmación |
| 4 | Login de Usuario | `/login` | Campos y botón "Entrar" |
| 5 | Dashboard de Usuario | `/inicioUsuario` | Menú completo visible |
| 6 | Perfil de Usuario | `/perfil` | Datos personales y nSocio |
| 7 | Catálogo de Libros | `/catalogo` | Filtros de búsqueda y libros |
| 8 | Catálogo Filtrado | `/catalogo?genero=...` | Resultados tras búsqueda |
| 9 | Actividades/Eventos | `/actividades` | Listado de eventos |
| 10 | Formulario de Contacto | `/contacto` | Campos y botón "Enviar" |
| 11 | Contacto Enviado | `/contacto` | Mensaje flash de éxito |
| 12 | Servicios Digitales | `/serviciosDigitales` | Página de servicios |
| 13 | Login de Admin | `/admin/login` | Formulario admin |
| 14 | Dashboard Admin | `/admin` | Panel con menú de gestión |
| 15 | Gestión Carrusel | `/admin/gestionCarrusel` | CRUD con botones señalados |
| 16 | Gestión Libros | `/admin/gestionarLibros` | Listado y opciones CRUD |
| 17 | Gestión Usuarios | `/admin/gestionUsuarios` | Panel de usuarios |
| 18 | Mensajes Contacto | `/admin/mensajes` | Estados y botones de acción |
| 19 | Roles y Permisos | `/admin/gestionRoles` | Pantalla de gestión de roles |
| 20 | Errores de Validación | `/login` + `/registro` | Mensajes de error en rojo |

---

*Fin del documento — Entrega 8: Manuales del Proyecto*
