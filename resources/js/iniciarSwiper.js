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
                slidesPerView: 3,
                spaceBetween: 8,
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    800: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    1000: {
                        slidesPerView: 5,
                        spaceBetween: 8,
                    },
                    1200: {
                        slidesPerView: 9,
                        spaceBetween: 8,
                    },
                }
            });
        });