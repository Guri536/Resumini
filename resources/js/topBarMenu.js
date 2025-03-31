const menuButton = document.getElementById('menu-button');
const menuItems = document.getElementById('menu-items');

menuButton.addEventListener('click', () => {
    menuItems.classList.toggle('hidden');
    menuItems.classList.toggle('dropdown-enter-active');
    if (menuItems.classList.contains('hidden')) {
        menuItems.classList.remove('dropdown-enter-active');
    }
});

document.addEventListener('click', (event) => {
    if (!menuButton.contains(event.target) && !menuItems.contains(event.target)) {
        menuItems.classList.add('hidden');
        menuItems.classList.remove('dropdown-enter-active');
    }
});