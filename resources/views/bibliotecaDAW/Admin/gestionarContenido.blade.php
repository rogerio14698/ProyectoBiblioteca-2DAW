@extends('layouts.app')

@section('title', 'Gestionar Contenido')

@section('content')
    <h1>Gestionar Contenido</h1>
    <p>Desde aquí puedes gestionar el contenido de la Biblioteca DAW.</p>
    <!-- Aquí va a ir los títulos de los diferentes contenidos de la web
                                            Contenido Principal, Contenido Catálogo, Contenido Actividades, 
                                            Contenido Servicios Digitales, Contenido Contacto -->
    <!-- -->
    <h3>Noticas</h3>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre del Contenido</th>
                <th>Titulo</th>
                <th>Texto</th>
                <th>Autores</th>
                <th>Fecha de Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Contenido Principal</td>
                <td>Bienvenidos a la Biblioteca DAW</td>
                <td>En la Biblioteca DAW encontrarás una amplia selección de libros, recursos digitales y actividades para
                    todos los amantes de la lectura. ¡Explora nuestro catálogo y descubre tu próxima lectura favorita!</td>
                <td>Admin</td>
                <td>2024-06-01</td>
                <form action="#">
                    <td><button type="submit">Editar</button></td>
                    <td><button type="submit">Eliminar</button></td>
                </form>
            </tr>
        </tbody>
    </table>
    <h3>Destacados</h3>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre del Contenido</th>
                <th>Titulo</th>
                <th>Texto</th>
                <th>Autores</th>
                <th>Fecha de Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Aviso Importante</td>
                <td>Nuevos Horarios de Atención</td>
                <td>A partir del 1 de Julio, la Biblioteca DAW tendrá nuevos horarios de atención al público.
                    Estaremos abiertos de lunes a viernes de 9:00 a 18:00, y los sábados de 10:00 a 14:00.
                    ¡Te esperamos para disfrutar de nuestros servicios y recursos!</td>
                <td>Admin</td>
                <td>2024-06-15</td>
                <form action="#">
                    <td><button type="submit">Editar</button></td>
                    <td><button type="submit">Eliminar</button></td>
                </form>
            </tr>
        </tbody>
    </table>
    <hr>
    <h3>Avisos Importantes</h3>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre del Contenido</th>
                <th>Titulo</th>
                <th>Texto</th>
                <th>Autores</th>
                <th>Fecha de Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Aviso Importante</td>
                <td>Nuevas Instalaciones en la Biblioteca</td>
                <td>¡Estamos emocionados de anunciar que la Biblioteca DAW ha inaugurado nuevas instalaciones! Ahora
                    contamos con un espacio más amplio y moderno para ofrecerte una experiencia de lectura aún mejor. Ven a
                    visitarnos y descubre nuestras nuevas áreas de lectura, salas de estudio y zonas de descanso. ¡Te
                    esperamos para disfrutar de un ambiente acogedor y lleno de conocimiento!</td>
                <td>Admin</td>
                <td>2024-06-20</td>
                <form action="#">
                    <td><button type="submit">Editar</button></td>
                    <td><button type="submit">Eliminar</button></td>
                </form>
            </tr>
        </tbody>
    </table>
    <hr>


@endsection