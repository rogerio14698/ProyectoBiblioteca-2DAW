<footer class="footer">

    <!--Columna 1: Información general y redes sociales -->
    <div class="footerDireccion">
        <div class="footerInfo">
            {{-- h2 y no h1: el h1 de la página ya se usa en el contenido principal, el footer no debe duplicarlo --}}
            <h2>{{ $footerConfig->titulo }} &copy; {{ date('Y') }}</h2>
            <p>tel: {{ $footerConfig->telefono }}</p>
            <p>{{ $footerConfig->direccion }}</p>
        </div>
        <div class="footerRedesSociales">
            @if ($footerConfig->instagram_url)
                <a href="{{ $footerConfig->instagram_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
            @endif
            @if ($footerConfig->linkedin_url)
                <a href="{{ $footerConfig->linkedin_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
            @endif
            @if ($footerConfig->twitter_url)
                <a href="{{ $footerConfig->twitter_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter-x"></i></a>
            @endif
            @if ($footerConfig->youtube_url)
                <a href="{{ $footerConfig->youtube_url }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-youtube"></i></a>
            @endif
        </div>
    </div>

    <!--Columna 2: Horarios -->
    <div class="footerHorarios">
        <h2>Horarios</h2>
        <p>Lunes a Viernes: {{ $footerConfig->horario_semana }}</p>
        <p>Sábado: {{ $footerConfig->horario_sabado }}</p>
        <p>Domingo: {{ $footerConfig->horario_domingo }}</p>
    </div>

    <!--Columna 3: Contacto y legal -->
    <div class="footerContacto">
        <h2>Contacto</h2>
        <p>Contacto: {{ $footerConfig->email_contacto }}</p>
        @if ($footerConfig->aviso_legal_url)
            <p>aviso legal: <a href="{{ url($footerConfig->aviso_legal_url) }}" class="text-decoration-none">Ver aviso legal</a></p>
        @endif
        @if ($footerConfig->politica_cookies_url)
            <p>Políticas de cookies: <a href="{{ url($footerConfig->politica_cookies_url) }}" class="text-decoration-none">Ver políticas de cookies</a></p>
        @endif
    </div>

</footer>