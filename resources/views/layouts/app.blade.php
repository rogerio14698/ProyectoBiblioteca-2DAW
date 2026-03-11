<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Esto es el Watch de npm para que se actualice el css cada vez que se haga un cambio -->

    <title>@yield('title', 'Biblioteca DAW')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logoDAW-conTransparencia.png') }}" type="image/png">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--Swiper Layout -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />


    <!-- Css para sobrescribir el boostrap -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Dar estilos personalizados-->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('head')
</head>

<body>
    @include('layouts.header')
    <!-- Aqui voy a poner el layout de usuario, pero hay que verificar. si el usuario ha ingresado mediante login -->
    @auth('web')
        <!--auth hace exactamente esto, valida si el usuario ha iniciado sesión
                                            y luego renderiza el contenido dentro del bloque auth -->
        @include('layouts.navUsuario')
    @endauth
    <!-- con esto especificando el guard, me aseguro que solo se renderice el navUsuario para los usuarios autenticados con el guard web, que es el guard por defecto para los usuarios normales en Laravel -->
    @auth('admin')
        @include('layouts.navAdmin')
    @endauth



    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <!-- Inicializar Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const swiperElement = document.querySelector('.novedadesSwiper');

            if (!swiperElement) {
                return;
            }

            const totalSlides = swiperElement.querySelectorAll('.swiper-slide').length;

            if (totalSlides === 0) {
                return;
            }

            new Swiper('.novedadesSwiper', {
                direction: 'horizontal',
                loop: totalSlides > 5,
                watchOverflow: true,
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    640: { slidesPerView: Math.min(2, totalSlides) },
                    768: { slidesPerView: Math.min(3, totalSlides) },
                    1024: { slidesPerView: Math.min(5, totalSlides) },
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>