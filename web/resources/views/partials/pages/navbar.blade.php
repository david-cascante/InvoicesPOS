<!-- Header Mejorado -->
<header class="bg-white shadow-lg fixed w-full z-50 transition-all duration-300">
    <!-- Barra de navegación principal -->
    <div class="container mx-auto px-4 sm:px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center max-w-[140px] z-10" aria-label="Go to homepage">
                <img src="{{ asset('assets/img/invoicespos.webp') }}" alt="InvoicesPOS Logo" class="w-full h-auto">
            </a>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-1" aria-label="Navegación principal">
                <a href="{{ route('home') }}#features" class="text-gray-800 hover:text-primary transition-colors font-medium px-4 py-2 rounded-lg hover:bg-primary/10 focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Características</a>
                <a href="{{ route('home') }}#ai" class="text-gray-800 hover:text-primary transition-colors font-medium px-4 py-2 rounded-lg hover:bg-primary/10 focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">IA</a>
                <a href="{{ route('home') }}#web" class="text-gray-800 hover:text-primary transition-colors font-medium px-4 py-2 rounded-lg hover:bg-primary/10 focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Web</a>
                <a href="{{ route('home') }}#social" class="text-gray-800 hover:text-primary transition-colors font-medium px-4 py-2 rounded-lg hover:bg-primary/10 focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Redes Sociales</a>
                <a href="{{ route('home') }}#contact" class="text-gray-800 hover:text-primary transition-colors font-medium px-4 py-2 rounded-lg hover:bg-primary/10 focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Contáctanos</a>

                <!-- Botón de Acción -->
                <a href="{{ route('home') }}#waitlist" class="ml-2 px-5 py-2.5 bg-primary text-white rounded-lg hover:bg-primaryDark transition-colors font-medium flex items-center shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <i class="fas fa-clipboard-list mr-2"></i> Acceso Anticipado
                </a> 
            </nav>
            
            <!-- Mobile menu button -->
            <button class="md:hidden focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors z-10" 
                    onclick="toggleMenu()" 
                    aria-label="Toggle menu"
                    aria-expanded="false"
                    aria-controls="mobileMenu">
                <i class="fas fa-bars text-xl text-gray-900"></i>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 py-4 px-4">
            <nav class="flex flex-col space-y-2" aria-label="Navegación móvil">
                <a href="{{ route('home') }}#features" class="py-3 px-4 text-gray-800 hover:bg-primary/10 rounded-lg transition-colors font-medium focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Características</a>
                <a href="{{ route('home') }}#ai" class="py-3 px-4 text-gray-800 hover:bg-primary/10 rounded-lg transition-colors font-medium focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">IA</a>
                <a href="{{ route('home') }}#web" class="py-3 px-4 text-gray-800 hover:bg-primary/10 rounded-lg transition-colors font-medium focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Web</a>
                <a href="{{ route('home') }}#social" class="py-3 px-4 text-gray-800 hover:bg-primary/10 rounded-lg transition-colors font-medium focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Redes Sociales</a>
                <a href="{{ route('home') }}#contact" class="py-3 px-4 text-gray-800 hover:bg-primary/10 rounded-lg transition-colors font-medium focus:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/30">Contáctanos</a>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="#waitlist" class="block py-3 px-4 bg-primary text-white rounded-lg hover:bg-primaryDark transition-colors font-medium text-center shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <i class="fas fa-clipboard-list mr-2"></i> Acceso Anticipado
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        const button = document.querySelector('[aria-controls="mobileMenu"]');
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        menu.classList.toggle('hidden');
        button.setAttribute('aria-expanded', !isExpanded);
        
        // Cambiar icono del botón
        const icon = button.querySelector('i');
        if (isExpanded) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    }
    
    // Cerrar menú móvil al hacer clic fuera de él
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const button = document.querySelector('[aria-controls="mobileMenu"]');
        
        if (!menu.contains(event.target) && !button.contains(event.target) && !menu.classList.contains('hidden')) {
            toggleMenu();
        }
    });
    
    // Cerrar menú móvil al redimensionar la ventana
    window.addEventListener('resize', function() {
        const menu = document.getElementById('mobileMenu');
        const button = document.querySelector('[aria-controls="mobileMenu"]');
        
        if (window.innerWidth >= 768 && !menu.classList.contains('hidden')) {
            toggleMenu();
        }
    });
</script>