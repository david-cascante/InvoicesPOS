
// Mobile menu toggle
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}

// Account dropdown toggle
function toggleDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('account-dropdown');
    const arrow = document.getElementById('dropdown-arrow');
    
    dropdown.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}

// Cerrar el dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('account-dropdown');
    const button = document.getElementById('dropdown-button');
    
    if (!button.contains(event.target)) {
        dropdown.classList.add('hidden');
        document.getElementById('dropdown-arrow').classList.remove('rotate-180');
    }
});

// Cerrar el dropdown al hacer clic en un enlace dentro del mismo
document.querySelectorAll('#account-dropdown a, #account-dropdown button').forEach(item => {
    item.addEventListener('click', () => {
        document.getElementById('account-dropdown').classList.add('hidden');
        document.getElementById('dropdown-arrow').classList.remove('rotate-180');
    });
});

// Back to top button
const backToTopButton = document.getElementById('backToTop');
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.remove('opacity-0', 'invisible');
        backToTopButton.classList.add('opacity-100', 'visible');
    } else {
        backToTopButton.classList.remove('opacity-100', 'visible');
        backToTopButton.classList.add('opacity-0', 'invisible');
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
            
            // Close mobile menu if open
            const mobileMenu = document.getElementById('mobileMenu');
            if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
        }
    });
});

