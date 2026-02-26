@extends('layouts.app')

@section('title', 'Vender')

@section('content')
    <h1>Vender</h1>
    <p>Bienvenido @user a la sección de vender de la Biblioteca DAW.</p>

    <p>-El usuario podrá vender libros de segunda mano a un precio determinado por la biblioteca en funcion del libro, su
        estado y su formato si fisico o digiytal
        Tambien da la posibilidad que el usuario pueda vender sus propios libros, dando un espacio para autores freelance.
        Dependiendo de la cantidad de ventas que tenga el libro el autor recibirá un % de dinero mensualmente.
        Es decir si en 1 semana se vende 10 libros a fin de mes recibe el dinero establecido por la biblioteca.</p>
    <h2>Formulario para vender libros</h2>
    <form action="">
        <input type="text" placeholder="Título del Libro">
        <input type="text" placeholder="Autor del Libro">
        <input type="number" placeholder="Precio del Libro">
        <select name="formato" id="formato">
            <option value="fisico">Físico</option>
            <option value="digital">Digital</option>
        </select>
        <input type="file" placeholder="Portada del Libro">
        <textarea placeholder="Descripción del Libro"></textarea>
        <button type="submit">Vender</button>
    </form>
@endsection