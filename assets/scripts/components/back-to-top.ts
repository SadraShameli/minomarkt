function initBackToTop() {
    const backToTopButton = document.querySelector('.back-to-top');
    if (!backToTopButton) {
        return;
    }

    document.addEventListener('scroll', function () {
        if (window.scrollY > 1000) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    backToTopButton.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initBackToTop();
});
