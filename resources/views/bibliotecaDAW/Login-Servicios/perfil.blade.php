@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <h1>Perfil</h1>
    <p>Bienvenido tu perfil de usuario de la Biblioteca DAW.</p>
    <section>
        <h2>Información Personal</h2>
        <p>Nombre de usuario: {{ $user->username }}</p>
        <p>Correo electrónico: {{ $user->email }}</p>
    </section>
    <section>
        <h2>Añadir metodo pago</h2>
        <div class="tarjeta-credito">
            <h3>Tarjeta de Crédito</h3>
        <input type="text" id="card_number">
        <label for="card_number">Número de tarjeta:</label>
        <button type="button">Añadir Tarjeta</button>
        </div>
        <div class="paypal">
            <h3>PayPal</h3>
        <input type="email" id="paypal_email">
        <label for="paypal_email">Correo electrónico de PayPal:</label>
        <button type="button">Añadir PayPal</button>
        </div>
    </section>
    <hr>
    <section>
        <h2>Historial de Préstamos</h2>
        @if($loans->isEmpty())
            <p>No tienes préstamos activos.</p>
        @else
            <ul>
                @foreach($loans as $loan)
                    <li>{{ $loan->book_title }} - {{ $loan->status }}</li>
                @endforeach
            </ul>
        @endif
        <hr>

        <h2>Historial de Reservas</h2>
        @if($reservations->isEmpty())
            <p>No tienes reservas activas.</p>
        @else
            <ul>    
                @foreach($reservations as $reservation)
                    <li>{{ $reservation->book_title }} - {{ $reservation->status }}</li>
                @endforeach
            </ul>
        @endif  

        <hr>
        <h2>Historial de Compras</h2>
        @if($purchases->isEmpty())
            <p>No tienes compras activas.</p>
        @else
            <ul>    
                @foreach($purchases as $purchase)
                    <li>{{ $purchase->item_name }} - {{ $purchase->status }}</li>
                @endforeach
            </ul> 
        @endif
        <hr>
    </section>

    <div class="cuenta">
        <button type="button">Cambiar Contraseña</button>
        <button type="button">Cerrar Sesión</button>
    </div> 

@endsection