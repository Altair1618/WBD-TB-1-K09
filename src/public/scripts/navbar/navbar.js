const hamburgerMenu = document.getElementById('navbar-hamburger-menu');

hamburgerMenu.addEventListener('click', () => {
    const navbar = document.getElementById('navbar-menu');

    if (navbar.className.includes('-active')) {
        hamburgerMenu.className = hamburgerMenu.className.replace('-active', '');
        navbar.className = navbar.className.replace('-active', '');
        return;
    } else {
        hamburgerMenu.className = hamburgerMenu.className + '-active';
        navbar.className = navbar.className + '-active';
    }
});

window.addEventListener('resize', () => {
    const navbar = document.getElementById('navbar-menu');
    
    const min_width = 600;

    if (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth >= min_width && navbar.className.includes('-active')) {
        hamburgerMenu.className = hamburgerMenu.className.replace('-active', '');
        navbar.className = navbar.className.replace('-active', '');
        return;
    }
});