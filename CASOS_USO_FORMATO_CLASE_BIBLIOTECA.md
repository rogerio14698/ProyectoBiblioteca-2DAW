# Casos de uso (formato típico de clase)
## Proyecto Biblioteca DAW

> Base del documento: estado actual del repositorio (rutas, controladores, vistas y modelos visibles).
> 
> Nota de alcance: el proyecto está en desarrollo, por eso cada caso de uso incluye estado (**Implementado / Parcial / Previsto**).

---

## Grupo A. Casos de uso actuales (implementados o parciales)

### CU-01 — Consultar portal público

| Campo               | Detalle                                                                                                                                                                                                                       |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Visitante                                                                                                                                                                                                                     |
| Actores secundarios | Sistema web                                                                                                                                                                                                                   |
| Objetivo            | Navegar por la información pública de la biblioteca.                                                                                                                                                                          |
| Precondiciones      | Ninguna.                                                                                                                                                                                                                      |
| Flujo principal     | 1) El visitante accede a `/biblioteca` o a una ruta pública. 2) El sistema muestra contenido de la página solicitada. 3) El visitante navega entre secciones públicas (catálogo, actividades, servicios, contacto, búsqueda). |
| Flujo alternativo   | A1) Si la URL no existe, el sistema devuelve error HTTP (404 u otro según configuración).                                                                                                                                     |
| Postcondiciones     | No se modifica información en BD.                                                                                                                                                                                             |
| Estado              | **Implementado**                                                                                                                                                                                                              |

### CU-02 — Registrarse como usuario

| Campo               | Detalle                                                                                                                                                                                                                                                                                                                       |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Visitante                                                                                                                                                                                                                                                                                                                     |
| Actores secundarios | Base de datos                                                                                                                                                                                                                                                                                                                 |
| Objetivo            | Crear una cuenta de usuario en la plataforma.                                                                                                                                                                                                                                                                                 |
| Precondiciones      | No estar autenticado; disponer de datos válidos de registro.                                                                                                                                                                                                                                                                  |
| Flujo principal     | 1) El visitante abre formulario de registro. 2) Introduce nombre, email, DNI, móvil (opcional), contraseña y confirmación. 3) El sistema valida formato y unicidad. 4) El sistema crea el usuario en `usuarios`. 5) Se genera `nSocio` automáticamente y se hashea la contraseña. 6) Se redirige a home con mensaje de éxito. |
| Flujo alternativo   | A1) Email/DNI/móvil duplicado: se muestran errores de validación. A2) Contraseña no válida o confirmación incorrecta: se muestran errores de validación.                                                                                                                                                                      |
| Postcondiciones     | Nuevo usuario persistido correctamente.                                                                                                                                                                                                                                                                                       |
| Estado              | **Implementado**                                                                                                                                                                                                                                                                                                              |

### CU-03 — Iniciar sesión como usuario

| Campo               | Detalle                                                                                                                                                                                                                  |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Actor principal     | Usuario registrado                                                                                                                                                                                                       |
| Actores secundarios | Base de datos, sistema de autenticación Laravel (`guard web`)                                                                                                                                                            |
| Objetivo            | Acceder al área privada de usuario.                                                                                                                                                                                      |
| Precondiciones      | Usuario registrado con credenciales válidas.                                                                                                                                                                             |
| Flujo principal     | 1) El usuario abre login. 2) Introduce email y contraseña. 3) El sistema valida datos. 4) Se intenta autenticación con `Auth::guard('web')`. 5) Si es correcto, se regenera sesión. 6) Se redirige al inicio de usuario. |
| Flujo alternativo   | A1) Credenciales incorrectas: mensaje de error. A2) Fallo de conexión BD: mensaje técnico controlado.                                                                                                                    |
| Postcondiciones     | Sesión de usuario iniciada.                                                                                                                                                                                              |
| Estado              | **Implementado**                                                                                                                                                                                                         |

### CU-04 — Cerrar sesión como usuario

| Campo               | Detalle                                                                                                                                           |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Usuario registrado                                                                                                                                |
| Actores secundarios | Sistema de autenticación Laravel                                                                                                                  |
| Objetivo            | Finalizar sesión de forma segura.                                                                                                                 |
| Precondiciones      | Usuario autenticado en guard `web`.                                                                                                               |
| Flujo principal     | 1) El usuario solicita logout. 2) El sistema cierra sesión (`logout`). 3) Invalida sesión y regenera token CSRF. 4) Redirige al login de usuario. |
| Flujo alternativo   | A1) Si la sesión ya no existe, el sistema redirige a zona pública/login.                                                                          |
| Postcondiciones     | Sesión finalizada.                                                                                                                                |
| Estado              | **Implementado**                                                                                                                                  |

### CU-05 — Iniciar sesión como administrador

| Campo               | Detalle                                                                                                                                                                                                         |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                                                                                                                   |
| Actores secundarios | Base de datos, sistema de autenticación Laravel (`guard admin`)                                                                                                                                                 |
| Objetivo            | Acceder al panel administrativo.                                                                                                                                                                                |
| Precondiciones      | Cuenta admin válida y activa.                                                                                                                                                                                   |
| Flujo principal     | 1) El admin abre login admin. 2) Introduce email/contraseña. 3) El sistema valida. 4) Intenta autenticación con `Auth::guard('admin')`. 5) Regenera sesión. 6) Actualiza `last_login`. 7) Redirige a dashboard. |
| Flujo alternativo   | A1) Credenciales inválidas: error de autenticación. A2) Fallo BD: error técnico controlado.                                                                                                                     |
| Postcondiciones     | Sesión admin iniciada y fecha de último login actualizada.                                                                                                                                                      |
| Estado              | **Implementado**                                                                                                                                                                                                |

### CU-06 — Navegar por módulo administrador

| Campo               | Detalle                                                                                                              |
| ------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                        |
| Actores secundarios | Sistema web                                                                                                          |
| Objetivo            | Entrar en secciones de administración (libros, usuarios, inventario, préstamos, estadísticas, contenido).            |
| Precondiciones      | Sesión admin activa (`auth:admin`).                                                                                  |
| Flujo principal     | 1) El admin entra al dashboard. 2) Selecciona un submódulo de gestión. 3) El sistema carga la vista correspondiente. |
| Flujo alternativo   | A1) Si no está autenticado como admin, middleware bloquea el acceso y redirige.                                      |
| Postcondiciones     | Navegación administrativa realizada; sin cambios de datos por sí sola.                                               |
| Estado              | **Parcial**                                                                                                          |

### CU-07 — Visualizar agenda de eventos en home

| Campo               | Detalle                                                                                                                                                            |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Actor principal     | Visitante / Usuario registrado                                                                                                                                     |
| Actores secundarios | Base de datos                                                                                                                                                      |
| Objetivo            | Consultar próximos eventos en la portada.                                                                                                                          |
| Precondiciones      | Existencia de eventos en BD o seeders.                                                                                                                             |
| Flujo principal     | 1) Se carga `/biblioteca`. 2) `HomeController` consulta eventos ordenados por fecha y su organizador. 3) La vista renderiza la sección agenda/carrusel de eventos. |
| Flujo alternativo   | A1) Si no hay eventos, la sección se muestra vacía o con contenido mínimo.                                                                                         |
| Postcondiciones     | No hay escritura en BD.                                                                                                                                            |
| Estado              | **Implementado** (con mejoras visuales pendientes)                                                                                                                 |

### CU-08 — Visualizar libros en portada/destacados

| Campo               | Detalle                                                                                             |
| ------------------- | --------------------------------------------------------------------------------------------------- |
| Actor principal     | Visitante / Usuario registrado                                                                      |
| Actores secundarios | Base de datos                                                                                       |
| Objetivo            | Consultar libros mostrados en la home.                                                              |
| Precondiciones      | Existencia de libros en BD.                                                                         |
| Flujo principal     | 1) El sistema consulta libros para home/destacados. 2) Se renderizan tarjetas de libros en portada. |
| Flujo alternativo   | A1) Si no hay libros, la sección queda sin elementos.                                               |
| Postcondiciones     | No hay escritura en BD.                                                                             |
| Estado              | **Parcial** (existen desajustes por revisar entre datos mostrados y estructura de libro)            |

---

## Grupo B. Casos de uso previstos (pendientes de cierre funcional)

### CU-09 — Gestionar perfil de usuario

| Campo               | Detalle                                                                                                |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| Actor principal     | Usuario registrado                                                                                     |
| Actores secundarios | Base de datos                                                                                          |
| Objetivo            | Consultar y editar datos de perfil.                                                                    |
| Precondiciones      | Usuario autenticado.                                                                                   |
| Flujo principal     | 1) El usuario abre perfil. 2) Visualiza datos actuales. 3) Edita campos permitidos. 4) Guarda cambios. |
| Flujo alternativo   | A1) Datos no válidos: se informa error de validación.                                                  |
| Postcondiciones     | Perfil actualizado en BD.                                                                              |
| Estado              | **Previsto/Parcial**                                                                                   |

### CU-10 — Gestionar métodos de pago

| Campo               | Detalle                                                                                                                              |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| Actor principal     | Usuario registrado                                                                                                                   |
| Actores secundarios | Base de datos, proveedor de pago (potencial)                                                                                         |
| Objetivo            | Añadir, editar o eliminar métodos de pago.                                                                                           |
| Precondiciones      | Usuario autenticado; integración de pago definida.                                                                                   |
| Flujo principal     | 1) El usuario accede a gestión de pago. 2) Selecciona tipo (tarjeta/PayPal/otro). 3) El sistema valida y guarda token/datos mínimos. |
| Flujo alternativo   | A1) Datos de pago inválidos: error de validación. A2) Proveedor externo no disponible: operación no completada.                      |
| Postcondiciones     | Método de pago asociado al usuario.                                                                                                  |
| Estado              | **Previsto/Parcial**                                                                                                                 |

### CU-11 — Alquilar libro

| Campo               | Detalle                                                                                                                                         |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Usuario registrado                                                                                                                              |
| Actores secundarios | Base de datos                                                                                                                                   |
| Objetivo            | Solicitar préstamo de un libro disponible.                                                                                                      |
| Precondiciones      | Usuario autenticado; libro disponible; reglas de préstamo cumplidas.                                                                            |
| Flujo principal     | 1) El usuario selecciona libro. 2) Solicita préstamo. 3) El sistema valida disponibilidad y reglas. 4) Registra préstamo y fecha de devolución. |
| Flujo alternativo   | A1) Libro sin disponibilidad. A2) Usuario con restricciones de préstamo.                                                                        |
| Postcondiciones     | Préstamo registrado; disponibilidad actualizada.                                                                                                |
| Estado              | **Previsto**                                                                                                                                    |

### CU-12 — Comprar libro/recurso

| Campo               | Detalle                                                                                             |
| ------------------- | --------------------------------------------------------------------------------------------------- |
| Actor principal     | Usuario registrado                                                                                  |
| Actores secundarios | Proveedor de pago (potencial), base de datos                                                        |
| Objetivo            | Realizar compra de un recurso habilitado.                                                           |
| Precondiciones      | Usuario autenticado; método de pago válido; recurso con opción compra.                              |
| Flujo principal     | 1) El usuario selecciona recurso. 2) Confirma compra. 3) Se procesa pago. 4) Se registra operación. |
| Flujo alternativo   | A1) Pago rechazado/no autorizado. A2) Recurso no disponible.                                        |
| Postcondiciones     | Compra registrada y estado del recurso actualizado.                                                 |
| Estado              | **Previsto**                                                                                        |

### CU-13 — Publicar/vender contenido por usuario

| Campo               | Detalle                                                                                                                                            |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Usuario registrado                                                                                                                                 |
| Actores secundarios | Base de datos, administrador (si hay moderación)                                                                                                   |
| Objetivo            | Publicar contenido o ponerlo en venta según reglas de la plataforma.                                                                               |
| Precondiciones      | Usuario autenticado; permisos y reglas de publicación definidas.                                                                                   |
| Flujo principal     | 1) El usuario abre formulario de publicación/venta. 2) Introduce datos. 3) El sistema valida. 4) Se guarda como publicado o pendiente de revisión. |
| Flujo alternativo   | A1) Datos incompletos/incorrectos. A2) Contenido rechazado por moderación.                                                                         |
| Postcondiciones     | Contenido registrado con su estado correspondiente.                                                                                                |
| Estado              | **Previsto**                                                                                                                                       |

### CU-14 — Organizar evento

| Campo               | Detalle                                                                                                                                                  |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Usuario registrado                                                                                                                                       |
| Actores secundarios | Base de datos                                                                                                                                            |
| Objetivo            | Crear un evento asociado al usuario organizador.                                                                                                         |
| Precondiciones      | Usuario autenticado.                                                                                                                                     |
| Flujo principal     | 1) El usuario accede a “organizar evento”. 2) Completa título, descripción, fecha y ubicación. 3) El sistema valida y guarda el evento con `usuario_id`. |
| Flujo alternativo   | A1) Datos inválidos. A2) Fecha/hora no permitida por reglas futuras.                                                                                     |
| Postcondiciones     | Evento creado y disponible para consulta.                                                                                                                |
| Estado              | **Previsto/Parcial**                                                                                                                                     |

### CU-15 — Gestionar libros (admin)

| Campo               | Detalle                                                                                                 |
| ------------------- | ------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                           |
| Actores secundarios | Base de datos                                                                                           |
| Objetivo            | Administrar el catálogo de libros (alta, edición, baja, estado).                                        |
| Precondiciones      | Admin autenticado con permisos suficientes.                                                             |
| Flujo principal     | 1) El admin entra al módulo libros. 2) Ejecuta operación CRUD. 3) El sistema valida y persiste cambios. |
| Flujo alternativo   | A1) Datos inválidos. A2) Restricciones de integridad (por préstamos activos, etc.).                     |
| Postcondiciones     | Catálogo actualizado.                                                                                   |
| Estado              | **Previsto/Parcial**                                                                                    |

### CU-16 — Gestionar usuarios (admin)

| Campo               | Detalle                                                                                             |
| ------------------- | --------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                       |
| Actores secundarios | Base de datos                                                                                       |
| Objetivo            | Supervisar y administrar cuentas de usuario.                                                        |
| Precondiciones      | Admin autenticado.                                                                                  |
| Flujo principal     | 1) El admin entra al módulo usuarios. 2) Busca/filtra usuarios. 3) Edita estado o datos permitidos. |
| Flujo alternativo   | A1) Usuario no encontrado. A2) Operación no permitida por rol/permisos.                             |
| Postcondiciones     | Datos/estado de usuarios actualizados.                                                              |
| Estado              | **Previsto/Parcial**                                                                                |

### CU-17 — Gestionar eventos (admin)

| Campo               | Detalle                                                                                                       |
| ------------------- | ------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                 |
| Actores secundarios | Base de datos                                                                                                 |
| Objetivo            | Revisar, editar o eliminar eventos publicados.                                                                |
| Precondiciones      | Admin autenticado.                                                                                            |
| Flujo principal     | 1) El admin abre módulo eventos. 2) Consulta listado. 3) Ejecuta acción de gestión (editar/eliminar/moderar). |
| Flujo alternativo   | A1) Evento no encontrado. A2) Restricción por estado del evento.                                              |
| Postcondiciones     | Eventos actualizados según acciones administrativas.                                                          |
| Estado              | **Previsto/Parcial**                                                                                          |

### CU-18 — Gestionar inventario y préstamos

| Campo               | Detalle                                                                                                                    |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                              |
| Actores secundarios | Base de datos                                                                                                              |
| Objetivo            | Controlar stock, préstamos, devoluciones e incidencias.                                                                    |
| Precondiciones      | Admin autenticado; modelo de préstamos definido.                                                                           |
| Flujo principal     | 1) El admin abre módulo inventario/préstamos. 2) Revisa estado operativo. 3) Ejecuta acciones de corrección/actualización. |
| Flujo alternativo   | A1) Inconsistencia de stock. A2) Préstamo en estado no editable.                                                           |
| Postcondiciones     | Inventario y estados de préstamo actualizados.                                                                             |
| Estado              | **Previsto**                                                                                                               |

### CU-19 — Gestionar contenido editorial web

| Campo               | Detalle                                                                                                       |
| ------------------- | ------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                 |
| Actores secundarios | Sistema web, base de datos                                                                                    |
| Objetivo            | Editar noticias, destacados, horarios y contenido institucional.                                              |
| Precondiciones      | Admin autenticado con permiso de edición de contenido.                                                        |
| Flujo principal     | 1) El admin entra al módulo de contenido. 2) Selecciona bloque/página. 3) Edita y guarda. 4) Publica cambios. |
| Flujo alternativo   | A1) Contenido inválido/no permitido. A2) Error al guardar/publicar.                                           |
| Postcondiciones     | Contenido público actualizado.                                                                                |
| Estado              | **Previsto/Parcial**                                                                                          |

### CU-20 — Consultar estadísticas operativas

| Campo               | Detalle                                                                                                           |
| ------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Actor principal     | Administrador                                                                                                     |
| Actores secundarios | Base de datos                                                                                                     |
| Objetivo            | Obtener métricas de uso y operación del sistema.                                                                  |
| Precondiciones      | Admin autenticado; datos históricos disponibles.                                                                  |
| Flujo principal     | 1) El admin abre módulo estadísticas. 2) Selecciona periodo/filtros. 3) El sistema calcula y muestra indicadores. |
| Flujo alternativo   | A1) Sin datos para el periodo. A2) Filtro no válido.                                                              |
| Postcondiciones     | No hay cambio persistente; se obtiene información para toma de decisiones.                                        |
| Estado              | **Previsto/Parcial**                                                                                              |

---

## Resumen rápido para entrega

- Este archivo traduce el catálogo funcional a **formato académico de caso de uso**.
- Se mantiene la trazabilidad con el estado real del proyecto (**implementado/parcial/previsto**).
- Puede usarse como base directa para diagramas UML de casos de uso o para la memoria técnica final.