# Entrega de análisis del sistema
## Proyecto Biblioteca DAW (estado actual: en desarrollo)

## 1. Introducción

Este documento recoge una **descripción general del sistema**, la **identificación de actores** y una propuesta de **casos de uso** para el proyecto web de Biblioteca DAW.

Se ha elaborado tomando como base el estado real del repositorio (rutas, controladores, modelos, migraciones, seeders y vistas). Por tanto:

- distingue entre funcionalidades **ya implementadas**;
- funcionalidades **parcialmente implementadas**;
- funcionalidades **previstas** pero aún no cerradas.

Este enfoque permite presentar una entrega funcional coherente, incluso cuando el proyecto no está finalizado al 100%.

---

## 2. Descripción general del sistema

### 2.1. Propósito del sistema

Biblioteca DAW es una aplicación web para centralizar servicios de biblioteca, combinando:

- una zona pública de consulta (catálogo, actividades, información);
- una zona privada para usuarios registrados;
- una zona de administración para gestión interna.

El sistema busca cubrir tanto la difusión de contenido (libros, eventos, noticias) como procesos operativos (registro/login, gestión de usuarios y recursos).

### 2.2. Tipo de aplicación y stack

- **Framework backend:** Laravel (PHP)
- **Frontend:** Blade templates + CSS/Bootstrap
- **Persistencia:** MySQL (vía migraciones Laravel)
- **Autenticación:** Guards separados para usuario (`web`) y administrador (`admin`)

### 2.3. Arquitectura funcional (alto nivel)

El sistema está organizado por capas:

1. **Presentación (Vistas Blade):**
   - páginas públicas;
   - páginas de usuario autenticado;
   - páginas del panel administrador.

2. **Aplicación (Controladores):**
   - `HomeController` para home y destacados;
   - controladores de autenticación para usuario y admin;
   - estructura preparada para ampliar lógica de negocio.

3. **Dominio y datos (Modelos + BD):**
   - `Usuario`, `Admin`, `Libro`, `Evento`, `MetodosPago`;
   - relaciones principales (por ejemplo, evento asociado a usuario organizador).

### 2.4. Módulos funcionales identificados

#### Módulo A. Portal público
Permite navegar sin autenticación por:
- página principal (`/biblioteca`);
- catálogo (`/catalogo`);
- actividades (`/actividades`);
- servicios digitales (`/serviciosDigitales`);
- contacto (`/contacto`);
- búsqueda (`/buscar`).

#### Módulo B. Gestión de identidad
Incluye:
- registro de nuevos usuarios;
- login de usuario;
- login de administrador;
- cierre de sesión por perfil.

#### Módulo C. Zona de usuario autenticado
Contiene rutas para:
- inicio de usuario;
- perfil;
- alquilar, comprar, vender, publicar;
- organizar evento.

> Estado actual: las rutas y vistas existen; parte de la lógica avanzada aún está pendiente de implementación completa.

#### Módulo D. Gestión de contenidos y recursos (admin)
Incluye acceso a:
- dashboard admin;
- gestión de libros;
- gestión de usuarios;
- gestión de inventario;
- gestión de préstamos;
- estadísticas;
- gestión de contenido web y eventos.

> Estado actual: estructura funcional definida en rutas/vistas; varias pantallas están como base de trabajo y requieren más lógica CRUD/servicios.

#### Módulo E. Agenda/Eventos en home
La home consume eventos y libros desde base de datos:
- eventos ordenados por fecha;
- libros cargados para sección destacada.

> Estado actual: integración principal activa, con comentarios internos que indican mejoras de carrusel/UX todavía en progreso.

### 2.5. Entidades de datos principales

- **Usuario (`usuarios`)**
  - Datos personales y credenciales.
  - Generación automática de `nSocio` en alta.

- **Administrador (`admin`)**
  - Credenciales, rol (`superadmin`, `editor`, `moderador`) y `last_login`.

- **Libro (`libros`)**
  - Metadatos bibliográficos, disponibilidad, formato y opción de operación.

- **Evento (`eventos`)**
  - Título, descripción, fecha/hora, ubicación.
  - Relación con usuario organizador (`usuario_id`).

- **Método de pago (`metodos_pago`)**
  - Soporte para tarjeta/PayPal mediante token y datos mínimos.

### 2.6. Estado de madurez del proyecto

Para la entrega, se puede considerar una madurez tipo **MVP ampliado en construcción**:

- ✅ Base de arquitectura y autenticación separada por perfiles.
- ✅ Modelado de datos principal y seeders disponibles.
- ✅ Navegación y estructura de pantallas construidas.
- ⚠️ Parte de la lógica de negocio (operaciones reales de préstamo/compra/publicación/gestión avanzada) todavía parcial o pendiente.
- ⚠️ Varias pantallas administrativas están orientadas a completar en siguientes iteraciones.

---

## 3. Identificación de actores del sistema

A continuación se identifican **todos los actores relevantes**: actuales y potenciales (si se completa el alcance previsto del proyecto).

## 3.1. Actores primarios

### Actor 1: Visitante (no autenticado)
Persona que navega la web sin iniciar sesión.

**Objetivos principales:**
- informarse sobre la biblioteca;
- revisar catálogo/eventos;
- decidir si registrarse.

**Permisos actuales:**
- acceso a secciones públicas;
- acceso a formulario de login/registro;
- consulta de contenidos visibles en home.

### Actor 2: Usuario registrado (socio)
Persona con cuenta en `usuarios` que inicia sesión por guard `web`.

**Objetivos principales:**
- acceder a servicios personalizados;
- operar con funcionalidades de usuario (alquiler/compra/venta/publicación/eventos).

**Permisos actuales (según rutas):**
- acceso a área privada (`/inicio`, `/perfil`, etc.);
- cierre de sesión.

**Permisos esperados al cierre del proyecto:**
- gestión completa de perfil y medios de pago;
- operaciones completas de libros y eventos con persistencia y trazabilidad.

### Actor 3: Administrador
Usuario interno autenticado con guard `admin`.

**Objetivos principales:**
- mantener catálogo, usuarios y contenido;
- supervisar operación global de la plataforma.

**Permisos actuales (según rutas):**
- acceso a panel y submódulos de gestión;
- logout de administrador.

**Permisos esperados al cierre del proyecto:**
- CRUD completo en cada módulo;
- validaciones de negocio, auditoría y estadísticas consolidadas.

## 3.2. Actores secundarios / externos (dependiendo del alcance final)

### Actor 4: Sistema de base de datos (MySQL)
No humano, pero crítico en todos los casos de uso persistentes.

**Rol funcional:**
- almacenar usuarios, admin, libros, eventos y métodos de pago;
- garantizar integridad por restricciones y claves foráneas.

### Actor 5: Pasarela/proveedor de pago (potencial)
Actor externo previsto por el modelo `metodos_pago` (token, provider, PayPal).

**Rol funcional esperado:**
- tokenización/validación de métodos de pago;
- autorización de pagos (si se implementa compra real).

> Nota: en el estado actual, este actor aparece modelado en datos, pero su integración transaccional no está cerrada.

### Actor 6: Servicio de notificaciones (potencial)
Posible actor futuro para avisos (confirmación de eventos, recordatorios, etc.).

> Nota: no se identifica implementación explícita completa en el estado revisado, pero es actor habitual para el alcance funcional planteado.

---

## 4. Catálogo de casos de uso

Se presentan casos de uso en dos grupos:

- **Grupo A: implementados o parcialmente implementados** (basados en rutas/controladores existentes).
- **Grupo B: previstos y recomendados** para cierre funcional.

### Convenciones de estado
- **Implementado:** existe flujo funcional backend + ruta/vista operativa.
- **Parcial:** existe estructura, pero faltan reglas de negocio y/o persistencia completa.
- **Previsto:** funcionalidad coherente con diseño, pendiente de implementación.

---

## 4.1. Grupo A — Casos de uso actuales

## CU-01 Consultar portal público
- **Actor principal:** Visitante
- **Objetivo:** Navegar por información general sin autenticarse.
- **Precondiciones:** Ninguna.
- **Disparador:** Entrada a `/biblioteca` o páginas públicas.
- **Flujo principal:**
  1. El visitante accede a una URL pública.
  2. El sistema muestra contenido informativo.
  3. El visitante puede navegar entre secciones.
- **Flujos alternativos:**
  - A1: ruta no existente → respuesta de error HTTP.
- **Postcondiciones:** Sin cambios de estado persistentes.
- **Estado:** **Implementado**.

## CU-02 Registrarse como usuario
- **Actor principal:** Visitante
- **Objetivo:** Crear cuenta de usuario en la plataforma.
- **Precondiciones:** No estar autenticado como usuario/admin.
- **Disparador:** Envío de formulario de registro.
- **Flujo principal:**
  1. El visitante abre formulario de registro.
  2. Introduce nombre, email, DNI, móvil (opcional) y contraseña confirmada.
  3. El sistema valida formato y unicidad.
  4. Se crea registro en `usuarios`.
  5. El sistema redirige a la home con mensaje de éxito.
- **Flujos alternativos:**
  - A1: email/DNI/móvil duplicado → error de validación.
  - A2: contraseña inválida o confirmación distinta → error de validación.
- **Postcondiciones:** Usuario persistido con contraseña hasheada y `nSocio` generado.
- **Estado:** **Implementado**.

## CU-03 Iniciar sesión como usuario
- **Actor principal:** Usuario registrado
- **Objetivo:** Acceder al área privada de usuario.
- **Precondiciones:** Cuenta existente y activa.
- **Disparador:** Envío de login usuario.
- **Flujo principal:**
  1. El usuario introduce email y contraseña.
  2. El sistema valida campos.
  3. Se intenta autenticación con guard `web`.
  4. Si es correcta, se regenera sesión.
  5. Redirección a inicio de usuario.
- **Flujos alternativos:**
  - A1: credenciales incorrectas → mensaje de error.
  - A2: fallo de conexión BD → mensaje técnico controlado.
- **Postcondiciones:** Sesión autenticada de usuario.
- **Estado:** **Implementado**.

## CU-04 Cerrar sesión como usuario
- **Actor principal:** Usuario registrado
- **Objetivo:** Finalizar sesión de forma segura.
- **Precondiciones:** Usuario autenticado.
- **Disparador:** Acción logout.
- **Flujo principal:**
  1. El usuario solicita cerrar sesión.
  2. El sistema ejecuta logout en guard `web`.
  3. Invalida sesión y regenera token CSRF.
  4. Redirige al login.
- **Postcondiciones:** Sesión cerrada.
- **Estado:** **Implementado**.

## CU-05 Iniciar sesión como administrador
- **Actor principal:** Administrador
- **Objetivo:** Acceder al panel administrativo.
- **Precondiciones:** Cuenta admin válida.
- **Disparador:** Envío de login admin.
- **Flujo principal:**
  1. El admin introduce credenciales.
  2. El sistema valida campos.
  3. Intenta autenticación guard `admin`.
  4. Regenera sesión.
  5. Actualiza `last_login`.
  6. Redirige al dashboard admin.
- **Flujos alternativos:**
  - A1: credenciales inválidas.
  - A2: error de conexión a BD.
- **Postcondiciones:** Sesión admin activa y último acceso actualizado.
- **Estado:** **Implementado**.

## CU-06 Navegar por módulo admin
- **Actor principal:** Administrador
- **Objetivo:** Acceder a secciones de gestión (libros, usuarios, inventario, etc.).
- **Precondiciones:** Autenticación admin activa.
- **Disparador:** Acceso a rutas `/admin/*`.
- **Flujo principal:**
  1. El admin entra al dashboard.
  2. Selecciona un submódulo.
  3. El sistema carga vista correspondiente.
- **Flujos alternativos:**
  - A1: no autenticado como admin → bloqueo por middleware.
- **Postcondiciones:** Navegación interna en panel.
- **Estado:** **Parcial** (estructura lista; lógica funcional profunda pendiente en varios submódulos).

## CU-07 Visualizar agenda de eventos en home
- **Actor principal:** Visitante / Usuario registrado
- **Objetivo:** Consultar próximos eventos.
- **Precondiciones:** Eventos cargados en BD (o seeders).
- **Disparador:** Carga de `/biblioteca`.
- **Flujo principal:**
  1. HomeController obtiene eventos ordenados por fecha.
  2. Se incluye relación de organizador (`usuario`).
  3. La vista renderiza carrusel/listado.
- **Flujos alternativos:**
  - A1: sin eventos → sección sin elementos.
- **Postcondiciones:** Sin escritura en BD.
- **Estado:** **Implementado** con mejoras pendientes de UX/carrusel.

## CU-08 Visualizar libros en portada/destacados
- **Actor principal:** Visitante / Usuario registrado
- **Objetivo:** Revisar libros visibles en portada.
- **Precondiciones:** Libros existentes en tabla `libros`.
- **Disparador:** Carga de home o ruta de destacados.
- **Flujo principal:**
  1. El sistema consulta libros.
  2. Renderiza tarjetas en portada.
- **Flujos alternativos:**
  - A1: sin libros → sección vacía.
- **Postcondiciones:** Sin escritura en BD.
- **Estado:** **Parcial** (consulta activa; hay desajustes a revisar entre campos mostrados y modelo/migración).

---

## 4.2. Grupo B — Casos de uso previstos (recomendados para cierre)

## CU-09 Gestionar perfil de usuario
- **Actor principal:** Usuario registrado
- **Objetivo:** Editar datos personales y preferencias.
- **Precondiciones:** Usuario autenticado.
- **Flujo esperado:** visualizar perfil, editar datos, guardar cambios.
- **Estado:** **Previsto/Parcial**.

## CU-10 Gestionar métodos de pago
- **Actor principal:** Usuario registrado
- **Objetivo:** Añadir/actualizar/eliminar métodos de pago tokenizados.
- **Precondiciones:** Usuario autenticado.
- **Flujo esperado:** alta de tarjeta/PayPal, validación y guardado seguro del token.
- **Estado:** **Previsto/Parcial** (modelo y migración existen).

## CU-11 Alquilar libro
- **Actor principal:** Usuario registrado
- **Objetivo:** Solicitar préstamo de libro.
- **Precondiciones:** disponibilidad del ejemplar y reglas de préstamo vigentes.
- **Flujo esperado:** seleccionar libro, confirmar préstamo, registrar fecha límite.
- **Estado:** **Previsto**.

## CU-12 Comprar libro o recurso
- **Actor principal:** Usuario registrado
- **Objetivo:** Ejecutar compra de recursos habilitados.
- **Precondiciones:** método de pago válido y artículo con opción compra.
- **Flujo esperado:** confirmar compra, autorizar pago, registrar operación.
- **Estado:** **Previsto**.

## CU-13 Publicar/vender contenido por usuario
- **Actor principal:** Usuario registrado
- **Objetivo:** Publicar o vender elementos permitidos por plataforma.
- **Precondiciones:** usuario autenticado y reglas de publicación.
- **Flujo esperado:** formulario, revisión, aprobación/publicación.
- **Estado:** **Previsto**.

## CU-14 Organizar evento
- **Actor principal:** Usuario registrado
- **Objetivo:** Crear evento asociado a su cuenta.
- **Precondiciones:** usuario autenticado.
- **Flujo esperado:** introducir datos del evento, validar, persistir con `usuario_id`.
- **Estado:** **Previsto/Parcial** (estructura de datos ya disponible).

## CU-15 Gestionar libros (admin CRUD)
- **Actor principal:** Administrador
- **Objetivo:** Alta/edición/baja/control de estado de libros.
- **Precondiciones:** admin autenticado con permisos.
- **Flujo esperado:** operaciones CRUD y control de inventario.
- **Estado:** **Previsto/Parcial**.

## CU-16 Gestionar usuarios (admin)
- **Actor principal:** Administrador
- **Objetivo:** Supervisar cuentas, estados y actividad.
- **Precondiciones:** admin autenticado.
- **Flujo esperado:** búsqueda, edición, bloqueo/activación.
- **Estado:** **Previsto/Parcial**.

## CU-17 Gestionar eventos (admin)
- **Actor principal:** Administrador
- **Objetivo:** Moderar/editar/eliminar eventos publicados.
- **Precondiciones:** admin autenticado.
- **Flujo esperado:** listado eventos, revisión, acciones de moderación.
- **Estado:** **Previsto/Parcial**.

## CU-18 Gestionar inventario y préstamos
- **Actor principal:** Administrador
- **Objetivo:** Controlar stock, préstamos activos, incidencias y devoluciones.
- **Precondiciones:** admin autenticado.
- **Flujo esperado:** panel operativo con métricas y acciones.
- **Estado:** **Previsto**.

## CU-19 Gestionar contenido editorial de la web
- **Actor principal:** Administrador
- **Objetivo:** Actualizar noticias, destacados, horarios y contenidos institucionales.
- **Precondiciones:** admin autenticado.
- **Flujo esperado:** edición de bloques de contenido y publicación.
- **Estado:** **Previsto/Parcial**.

## CU-20 Consultar estadísticas operativas
- **Actor principal:** Administrador
- **Objetivo:** Analizar uso de la plataforma (usuarios, préstamos, eventos, etc.).
- **Precondiciones:** datos históricos disponibles.
- **Flujo esperado:** panel de indicadores por periodos.
- **Estado:** **Previsto/Parcial**.

---

## 5. Matriz rápida actor vs casos de uso

| Actor                         | Casos de uso principales                                             |
| ----------------------------- | -------------------------------------------------------------------- |
| Visitante                     | CU-01, CU-02, CU-07, CU-08                                           |
| Usuario registrado            | CU-03, CU-04, CU-07, CU-08, CU-09, CU-10, CU-11, CU-12, CU-13, CU-14 |
| Administrador                 | CU-05, CU-06, CU-15, CU-16, CU-17, CU-18, CU-19, CU-20               |
| BD MySQL (externo técnico)    | Soporte transversal a todos los CU con persistencia                  |
| Proveedor de pago (potencial) | CU-10, CU-12                                                         |

---

## 6. Requisitos funcionales derivados (resumen de entrega)

1. El sistema debe permitir navegación pública sin autenticación.
2. El sistema debe permitir registro de usuario con validación y unicidad.
3. El sistema debe separar autenticación de usuario y admin con guards distintos.
4. El sistema debe restringir por middleware las áreas privadas.
5. El sistema debe mostrar en home información de eventos y libros desde BD.
6. El sistema debe permitir al administrador acceder a módulos de gestión.
7. El sistema deberá completar la lógica de negocio de operaciones de usuario/admin en siguientes iteraciones.

---

## 7. Riesgos y puntos pendientes para cerrar el proyecto

- Inconsistencia potencial entre algunos campos usados en vistas y atributos reales de modelos/migraciones.
- Módulos privados con interfaz creada pero lógica backend incompleta.
- Integración de pago modelada pero no cerrada extremo a extremo.
- Necesidad de definir reglas de negocio detalladas para préstamos, reservas, compras y publicación.
- Necesidad de robustecer control de errores, auditoría y pruebas funcionales integrales.

---

## 8. Estructura actual del sistema web (UI + CSS responsive)

Esta sección describe **cómo está organizado realmente el frontend hoy** tras los cambios de CSS, tomando como base los archivos activos del proyecto.

## 8.1. Carga de estilos en ejecución

En `resources/views/layouts/app.blade.php` se están cargando estas fuentes de estilo:

1. `@vite(['resources/css/app.css', 'resources/js/app.js'])`
2. Bootstrap CDN (`bootstrap.min.css`)
3. Bootstrap Icons CDN
4. `{{ asset('css/app.css') }}`
5. `{{ asset('css/main.css') }}`

En la práctica, el estilo visual principal de la web se concentra en **`public/css/main.css`** y sus imports modulares.

## 8.2. Arquitectura CSS vigente (por capas)

`public/css/main.css` organiza el sistema por capas en este orden:

1. `normalize/normalize.css`
2. `variables/variables.css`
3. `variables/botones.css`
4. `Globales/globales.css`
5. `variables/paginacion.css`
6. `variables/btnSlider.css`
7. `secciones/header.css`
8. `secciones/footer.css`
9. `paneles/Invitado/paginaPrincipal.css`
10. `paneles/Invitado/actividadesYEventos.css`
11. `paneles/Invitado/contacto.css`
12. `paneles/Invitado/login.css`
13. `paneles/Invitado/registro.css`
14. `panelAdmin/navAdmin.css`
15. `panelAdmin/dashboard.css`

Interpretación funcional:

- **Base global:** reset + variables + estilos comunes.
- **Secciones compartidas:** cabecera y pie para toda la web.
- **Módulos por área:** invitado (público) y administración.

## 8.3. Sistema de breakpoints y mediaqueries implementadas

En `variables/variables.css` existen tokens de referencia:

- `--MQ-movil: 576px`
- `--MQ-Tablet: 768px`
- `--MQ-Desktop: 1200px`
- `--MQ-Desktop-XL: 1400px`

Sin embargo, en los módulos activos las mediaqueries se aplican de forma literal (`768px`, `1200px`).

### Breakpoint tablet (`min-width: 768px`)

- `paneles/Invitado/paginaPrincipal.css`
  - `.agendaContenedor` pasa a `repeat(3, 1fr)`.
  - `.noticiasContenedor` pasa a `repeat(2, 1fr)`.
- `paneles/Invitado/actividadesYEventos.css`
  - `.actividadesEventos` cambia para envolver tarjetas y repartir espacio (`wrap` + `space-around`).
- `paneles/Invitado/contacto.css`
  - Se estructura la sección de contacto en columnas con `grid`/`flex` (`.contenedor-columnas`, `.contacto-container`).

### Breakpoint desktop (`min-width: 1200px`)

- `secciones/header.css`
  - `.navContenedor` cambia de columna a fila.
  - `.navLista` pasa a mostrarse en fila.
  - `.btnMenu` se oculta.
  - `.navBuscador` se muestra.
- `secciones/footer.css`
  - `.footer` cambia de columna a `grid` de 3 columnas.
  - Ajustes de alineación en `.footerHorarios` y `.footerContacto`.
- `paneles/Invitado/paginaPrincipal.css`
  - `.bienvenida` cambia a grid de 2 columnas.
  - Imagen principal de bienvenida aumenta de tamaño para escritorio.

### Breakpoint móvil (`max-width: 768px`)

- `panelAdmin/dashboard.css`
  - `.dashboard-body` colapsa a una columna.
  - Se reduce separación superior y se elimina margen solapado de tarjetas.

## 8.4. Comportamiento responsive actual por zonas de la web

1. **Header público:** móvil-first con menú colapsado; navegación completa visible en desktop.
2. **Home (`paginaPrincipal.css`):** layout base para móvil, expansión progresiva en tablet/desktop para agenda, noticias y hero.
3. **Contacto:** inicialmente en bloque vertical; en tablet se reorganiza a dos columnas.
4. **Actividades/Eventos:** tarjetas con disposición básica en móvil y distribución envolvente en tablet.
5. **Panel admin (dashboard):** diseño multicolumna en escritorio y simplificación a una sola columna en móvil.
6. **Footer:** bloque vertical en móvil y rejilla de 3 columnas en desktop.

## 8.5. Estado técnico del CSS en la versión actual

- El sistema está organizado de forma modular y por áreas funcionales.
- El enfoque responsive es **mobile-first** en la mayor parte de estilos públicos, con ampliación en `768px` y `1200px`.
- Bootstrap convive con CSS propio, pero el aspecto principal depende de estilos personalizados en `main.css` y archivos importados.
- Existe al menos un archivo de sobreescritura (`public/css/sobreEscribirBoostrap.css`) actualmente comentado, sin efecto visual activo.

---

## 9. Conclusión

El sistema Biblioteca DAW presenta una base sólida de arquitectura y autenticación multi-rol, con una parte pública operativa y una estructura clara para áreas privadas de usuario y administración.

Para una entrega académica/profesional, puede afirmarse que el proyecto se encuentra en una fase funcional intermedia-avanzada: **el núcleo está construido, pero aún requiere completar varios casos de uso de negocio para considerarse finalizado al 100%**.

Este documento deja identificados actores, alcance actual y hoja funcional de cierre para las próximas iteraciones.