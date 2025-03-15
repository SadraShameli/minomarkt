function initNavigationMainScroll() {
    const mastHead = document.querySelector('#masthead');
    if (!mastHead) {
        return;
    }

    window.addEventListener('scroll', () => {
        const scrollHeight = window.scrollY;

        if (scrollHeight > 0) {
            mastHead.classList.add('site-header--sticky');
        } else {
            mastHead.classList.remove('site-header--sticky');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initNavigationMainScroll();
});
