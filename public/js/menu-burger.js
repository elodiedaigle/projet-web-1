document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-mobile');

    if (!burger || !nav) return;

    burger.addEventListener('click', () => {
        nav.classList.toggle('open');
    });
});
