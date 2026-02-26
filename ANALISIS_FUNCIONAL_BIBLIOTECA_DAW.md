# Análisis funcional del sistema - Biblioteca DAW

## 1) Descripción general del sistema

Este proyecto es una aplicación web de una biblioteca, desarrollada con Laravel, donde hay una parte pública y otra privada.

- En la parte pública, cualquier visitante puede entrar a la página principal, ver libros destacados, consultar actividades/eventos y navegar por secciones como catálogo, contacto y servicios digitales.
- También existe un sistema de autenticación para dos perfiles: usuario normal y administrador.
- Cuando un usuario inicia sesión, puede acceder a servicios adicionales (perfil, alquilar, comprar, vender, publicar y organizar eventos).
- Cuando un administrador inicia sesión, accede a un panel para gestionar contenido (libros, usuarios, inventario, préstamos, estadísticas y eventos).

A nivel de datos, el sistema trabaja principalmente con:
- Usuarios (`usuarios`)
- Administradores (`admin`)
- Libros (`libro`)
- Eventos (`eventos`)

La página principal combina información de libros y eventos para mostrar una vista general de la biblioteca.

---

## 2) Identificación de actores

### Actor 1: Visitante (usuario no registrado)
Persona que entra en la web sin iniciar sesión.

**Qué puede hacer:**
- Ver la home de la biblioteca.
- Consultar catálogo, actividades y servicios digitales.
- Ir a login y registro.
- Buscar libros.

### Actor 2: Usuario registrado
Persona que tiene cuenta e inicia sesión con el guard `web`.

**Qué puede hacer:**
- Todo lo del visitante.
- Acceder a su zona privada.
- Gestionar acciones relacionadas con libros (por ejemplo alquilar/comprar/vender/publicar, según vistas del proyecto).
- Organizar eventos.
- Cerrar sesión.

### Actor 3: Administrador
Usuario con permisos de administración que inicia sesión con el guard `admin`.

**Qué puede hacer:**
- Acceder al panel de administración.
- Gestionar contenido de la web.
- Gestionar libros, usuarios, inventario y préstamos.
- Revisar estadísticas.
- Gestionar eventos desde la parte admin.
- Cerrar sesión como admin.

---

## 3) Casos de uso (resumen)

### CU-01: Consultar información pública
**Actor:** Visitante  
**Descripción:** El visitante entra en la web y revisa información general de la biblioteca (home, catálogo, actividades, contacto, etc.).  
**Resultado esperado:** Puede navegar y consultar contenidos sin autenticarse.

### CU-02: Registrarse en el sistema
**Actor:** Visitante  
**Descripción:** El visitante completa el formulario de registro para crear una cuenta.  
**Resultado esperado:** Se crea un nuevo usuario y ya puede iniciar sesión.

### CU-03: Iniciar sesión como usuario
**Actor:** Usuario registrado  
**Descripción:** El usuario introduce sus credenciales en el login de usuario.  
**Resultado esperado:** Accede a su zona privada con servicios adicionales.

### CU-04: Consultar eventos en la home
**Actor:** Visitante / Usuario registrado  
**Descripción:** El actor visualiza el carrusel/listado de eventos en la página principal.  
**Resultado esperado:** Ve título, descripción, fecha y organizador de cada evento.

### CU-05: Organizar un evento
**Actor:** Usuario registrado  
**Descripción:** El usuario accede a la opción de organizar evento y completa la información del evento.  
**Resultado esperado:** El evento queda guardado y asociado al usuario que lo crea.

### CU-06: Gestionar libros (admin)
**Actor:** Administrador  
**Descripción:** El administrador accede al panel y gestiona información de libros.  
**Resultado esperado:** Puede crear, actualizar o revisar contenido relacionado con libros.

### CU-07: Gestionar usuarios (admin)
**Actor:** Administrador  
**Descripción:** El administrador revisa y administra cuentas de usuarios.  
**Resultado esperado:** Mantiene control de los usuarios del sistema.

### CU-08: Gestionar eventos (admin)
**Actor:** Administrador  
**Descripción:** El administrador entra a la sección de eventos del panel para revisar o gestionar eventos.  
**Resultado esperado:** Mantiene actualizado el contenido de eventos.

### CU-09: Cerrar sesión
**Actor:** Usuario registrado / Administrador  
**Descripción:** El actor pulsa la opción de logout.  
**Resultado esperado:** Se cierra la sesión y vuelve a una zona pública.

---

## Nota

Este documento está redactado en base al estado actual del proyecto (rutas, controladores, vistas y modelos visibles en el repositorio). Si quieres, en una siguiente versión te lo transformo al formato típico de clase (tabla de casos de uso con: precondiciones, flujo principal, flujo alternativo y postcondiciones).