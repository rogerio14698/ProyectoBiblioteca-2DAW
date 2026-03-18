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
                spaceBetween: 16,
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    360: {
                        slidesPerView: 1,
                        spaceBetween: 16,
                    },
                    480: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    800: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1000: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 5,
                        spaceBetween: 20,
                    },
                }
            });
        });