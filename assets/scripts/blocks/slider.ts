import Swiper from 'swiper';
import { Autoplay, Navigation } from 'swiper/modules';

function initSliderLogo() {
    const sliders = document.querySelectorAll('.mino-slider-logo .swiper');

    for (const slider of sliders) {
        const slideCount = slider.querySelectorAll('.swiper-slide').length;
        if (slideCount < 1) {
            continue;
        }

        new Swiper(slider as HTMLElement, {
            modules: [Navigation, Autoplay],
            slidesPerView: 2,
            spaceBetween: 16,
            loop: slideCount > 1,
            autoplay: true,
            navigation: {
                nextEl: slider.querySelector(
                    '.js-swiper-button-next',
                ) as HTMLElement,
                prevEl: slider.querySelector(
                    '.js-swiper-button-prev',
                ) as HTMLElement,
            },
            breakpoints: {
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 6,
                },
            },
        });
    }
}

function initSliderFeatured() {
    const sliders = document.querySelectorAll('.mino-slider-featured .swiper');

    for (const slider of sliders) {
        const slideCount = slider.querySelectorAll('.swiper-slide').length;
        if (slideCount < 1) {
            continue;
        }

        new Swiper(slider as HTMLElement, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: slideCount > 1,
            autoplay: true,
            navigation: {
                nextEl: slider.querySelector(
                    '.js-swiper-button-next',
                ) as HTMLElement,
                prevEl: slider.querySelector(
                    '.js-swiper-button-prev',
                ) as HTMLElement,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
            },
        });
    }
}

function initSliderQuote() {
    const sliders = document.querySelectorAll('.mino-slider-quote .swiper');

    for (const slider of sliders) {
        const slideCount = slider.querySelectorAll('.swiper-slide').length;
        if (slideCount < 1) {
            continue;
        }

        new Swiper(slider as HTMLElement, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: slideCount > 1,
            autoplay: true,
            navigation: {
                nextEl: slider.querySelector(
                    '.js-swiper-button-next',
                ) as HTMLElement,
                prevEl: slider.querySelector(
                    '.js-swiper-button-prev',
                ) as HTMLElement,
            },
            breakpoints: {
                1440: {
                    slidesPerView: 1.4,
                },
            },
        });
    }
}

function initSliderTestimonial() {
    const sliders = document.querySelectorAll(
        '.mino-testimonial__content .swiper',
    );

    for (const slider of sliders) {
        const slideCount = slider.querySelectorAll('.swiper-slide').length;
        if (slideCount < 1) {
            continue;
        }

        new Swiper(slider as HTMLElement, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: slideCount > 1,
            autoplay: true,
            navigation: {
                nextEl: slider.querySelector(
                    '.js-swiper-button-next',
                ) as HTMLElement,
                prevEl: slider.querySelector(
                    '.js-swiper-button-prev',
                ) as HTMLElement,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 32,
                },
                992: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
            },
        });
    }
}

function initSliderMedia() {
    const sliders = document.querySelectorAll('.mino-slider-media .swiper');

    for (const slider of sliders) {
        const slideCount = slider.querySelectorAll('.swiper-slide').length;
        if (slideCount < 1) {
            continue;
        }

        new Swiper(slider as HTMLElement, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: slideCount > 1,
            autoplay: true,
            navigation: {
                nextEl: slider.querySelector(
                    '.js-swiper-button-next',
                ) as HTMLElement,
                prevEl: slider.querySelector(
                    '.js-swiper-button-prev',
                ) as HTMLElement,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2.75,
                    spaceBetween: 24,
                },
                992: {
                    slidesPerView: 3.75,
                    spaceBetween: 32,
                },
            },
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initSliderLogo();
    initSliderFeatured();
    initSliderQuote();
    initSliderTestimonial();
    initSliderMedia();
});
