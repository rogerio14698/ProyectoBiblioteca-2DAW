# 📜 Instrucciones de Desarrollo - Proyecto Horae (Laravel 12)

Este documento establece las normas obligatorias de arquitectura, estilo y desarrollo para asegurar la escalabilidad del proyecto y facilitar el aprendizaje de desarrolladores Junior.

---

## 🎨 1. Guía de Estilo y Reglas de Desarrollo UI
El sistema visual se basa en un diseño modular estricto mediante variables CSS personalizadas.

### 🏗️ Arquitectura CSS
1. **Origen:** `resources/css/variables.css` (Contiene todos los tokens `:root`).
2. **Capa Intermedia:** `main.css` importa las variables mediante: `@import './variables.css';`.
3. **Capa Final:** El HTML/Blade solo carga el archivo procesado (vía Vite o link directo).

### 🛠️ Reglas de Oro UI para Agentes/Copilot
- **PROHIBIDO** usar valores "hardcoded" (ej. `color: #4A90E2`). Usa siempre variables (ej. `color: var(--color-primario)`).
- **PROHIBIDO** añadir clases de Bootstrap para estilos estéticos (colores, sombras, radios). Bootstrap solo se permite para rejilla estructural (`row`, `col`).
- **JERARQUÍA:** Respeto absoluto a la jerarquía de títulos (`h1`, `h2`, `h3`) por accesibilidad.
- **ESTÁNDAR MÓVIL:** Uso obligatorio de `--relleno-movil` y `--altura-boton-movil` en media queries.

### 📌 Diccionario de Variables Críticas
- **Acción Principal:** `var(--color-primario)`
- **Acentos/Tags:** `var(--color-secundario)`
- **Fondo:** `var(--color-fondo-global)`
- **Sombras:** `var(--sombra-suave)`, `var(--sombra-media)`, `var(--sombra-fuerte)`
- **Espaciado:** Utiliza siempre múltiplos de `var(--unidad-espaciado)` (8px).

---

## 💻 2. Perfil y Stack Técnico
- **Rol:** Desarrollador de aplicaciones web Junior.
- **Stack:** Laravel 12, PHP 8.3, MySQL, JavaScript (Vanilla), HTML5, CSS3.
- **Idioma:** Código en **Inglés** (variables, métodos, clases). Explicaciones y comentarios en **Español**.

---

## 🐘 3. Estilo de Código PHP (Laravel 12 & PHP 8.3)
- **Tipado Estricto:** Obligatorio `declare(strict_types=1);` al inicio de cada archivo.
- **Modern PHP:**
    - Uso de `arrow functions` (`fn() => ...`) para lógica anónima corta.
    - "Constructor Property Promotion" para inyectar dependencias.
    - Declaración obligatoria de tipos de retorno en cada método/función.
- **Eloquent ORM:** Prohibido el uso de Raw SQL. Toda interacción con DB debe realizarse vía modelos.

---

## 🖼️ 4. Arquitectura y Vistas (Blade)
- **Estructura:** - Layout principal: Uso de `@yield` y `@section`.
    - Componentes: Fragmentos reutilizables mediante `@include`.
- **Lógica en Vistas:** Prohibido realizar cálculos o consultas complejas en Blade. Mover la lógica a un `Helper`, `Controller` o `ViewModel`.
- **Rutas:** Usar siempre la sintaxis de array: `Route::get('/', [Controller::class, 'index']);`.

---

## 🎨 5. Frontend: CSS y JavaScript
- **Nomenclatura CSS:** **CamelCase** obligatorio para nombres de clases (ej: `.tablaPrincipal`, `.botonGuardar`).
- **Organización:** Centralizar en `main.css`. Importar directorios por sección (ej: `/css/layouts/`, `/css/pages/`).
- **JavaScript:**
    - **Vanilla JS (Puro):** Prohibido jQuery o frameworks externos innecesarios.
    - **Funciones Flecha:** Uso de `const miFuncion = () => { ... }`.
    - **Prohibición:** JAMÁS usar estilos en línea (`style="..."`).

---

## ♿ 6. HTML, Accesibilidad y Seguridad
- **Semántica:** Uso de etiquetas correctas (`<main>`, `<section>`, `<article>`, `<header>`, `<footer>`).
- **Skip Links:** Incluir `<a href="#main-content" class="skip-link">Saltar al contenido principal</a>` al inicio del body.
- **Seguridad:**
    - Validación obligatoria: `$request->validate([...])` antes de procesar datos.
    - Modelos protegidos: Definir siempre `protected $fillable`.
    - Manejo de errores: Bloques `try-catch` con feedback amigable.

---

## 📝 7. Política de Comentarios (REGLA CRÍTICA)
**Nivel requerido:** Comentarios extremadamente explicativos, línea por línea, para nivel Junior.

## 8. Regla de oro, nunca hagas esto.
- DRY, dont repeat yourself, no dupliques codigo. centraliza componentes o helpers.
- Lógica en vistas, No dejes logica compleja en blade. 
- Tablas protegidas, No generes tablas sin clases contenedora de desbordamiento.
- Dependencias, no instales librerias de JS si se resuelve en unas pocas líneas de Vainilla JS

### Estándar para Funciones/Métodos:
Incluir bloque PHPDoc con:
- **Descripción:** Objetivo de la función.
- **Parámetros:** Nombre, tipo y explicación.
- **Retorno:** Tipo y significado.
- **Efectos secundarios:** Si modifica DB, sesiones o archivos.

### Ejemplo de Estándar Requerido:
```php
/**
 * Obtener contenidos recientes publicados.
 * @param int $limit Cantidad máxima de registros.
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function getRecentContent(int $limit = 5): Collection
{
    // Seleccionamos solo contenidos 'published' para evitar mostrar borradores.
    // Ordenamos por fecha de creación para priorizar la novedad.
    return Content::where('status', 'published')
                  ->orderBy('created_at', 'desc')
                  ->limit($limit)
                  ->get();
}