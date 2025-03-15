import { CountUp } from 'countup.js';

const initCounter = () => {
    const counterElements = document.querySelectorAll('.js-counter__number');
    const options = {
        useGrouping: true,
        duration: 2,
        useEasing: true,
    };

    const observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                const target = entry.target as HTMLElement;

                if (
                    !entry.isIntersecting ||
                    !target.dataset.number ||
                    !target.dataset.decimals ||
                    !target.dataset.separator
                ) {
                    return;
                }

                const element = target;
                const number = parseFloat(target.dataset.number);
                const decimals = parseInt(target.dataset.decimals);
                const separator = target.dataset.separator || ',';

                const countUp = new CountUp(element, number, {
                    ...options,
                    decimalPlaces: decimals,
                    decimal: '.',
                    separator,
                });

                if (!countUp.error) {
                    countUp.start();
                }

                observer.unobserve(element);
            }
        },
        {
            threshold: 0.1,
        },
    );

    counterElements.forEach((element) => {
        observer.observe(element);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initCounter();
});
