function initMobileToggle() {
    const body = document.querySelector('body');
    const navMobile = document.querySelector('.site-navigation-mobile');

    if (!body || !navMobile) {
        return;
    }

    const menuTogglers = document.querySelectorAll(
        '.mobile-navigation__toggler',
    );

    for (const toggler of menuTogglers) {
        toggler.addEventListener('click', () => {
            body.classList.toggle('overflow-hidden');
            toggler.classList.toggle('is--active');
            navMobile.classList.toggle('is--active');
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initMobileToggle();
});
