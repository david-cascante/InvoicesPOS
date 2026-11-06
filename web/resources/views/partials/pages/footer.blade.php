<!-- Footer -->
<footer class="bg-primaryDark text-white py-12 border border-white/20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo y descripción -->
            <div class="flex flex-col items-center md:items-start">
                <a href="{{ route('home') }}" class="flex items-center mb-4" aria-label="Go to homepage">
                    <span class="text-2xl font-bold text-white">InvoicesPOS</span>
                </a>
                <p class="text-gray-300 text-center md:text-left">El sistema POS más completo para tu negocio</p>
                
                <!-- Redes sociales -->
                <div class="mt-4 flex space-x-4">
                    <a href="https://www.instagram.com/invoicesposcr/" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-gradient-to-r from-pink-500 to-purple-500 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61581353138658" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-blue-600 hover:text-white transition">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
            
            <!-- Enlaces rápidos -->
            <div class="flex flex-col items-center md:items-start">
                <h3 class="text-lg font-semibold mb-4 text-white">Enlaces</h3>
                <ul class="space-y-2 text-center md:text-left">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-yellow-400 transition">Inicio</a></li>
                    <li><a href="{{ route('home') }}#features" class="text-gray-300 hover:text-yellow-400 transition">Características</a></li>
                    <li><a href="{{ route('home') }}#modules" class="text-gray-300 hover:text-yellow-400 transition">Modulos</a></li>
                    <li><a href="{{ route('home') }}#ai" class="text-gray-300 hover:text-yellow-400 transition">Inteligencia Artificial</a></li>
                    <li><a href="{{ route('home') }}#about" class="text-gray-300 hover:text-yellow-400 transition">Sobre nosotros</a></li>
                    <li><a href="{{ route('home') }}#waitlist" class="text-gray-300 hover:text-yellow-400 transition">Lista de espera</a></li>
                </ul>
            </div>
            
            <!-- Legal -->
            <div class="flex flex-col items-center md:items-start">
                <h3 class="text-lg font-semibold mb-4 text-white">Legal</h3>
                <ul class="space-y-2 text-center md:text-left">
                    <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-yellow-400 transition {{ Route::is('terms') ? 'text-yellow-400 font-medium' : '' }}">Términos y Condiciones</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-yellow-400 transition {{ Route::is('privacy') ? 'text-yellow-400 font-medium' : '' }}">Política de Privacidad</a></li>
                    <li><a href="{{ route('home') }}#contact" class="text-gray-300 hover:text-yellow-400 transition">Contacto</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Divider y copyright -->
        <div class="border-t border-white/20 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-300 text-center md:text-left mb-4 md:mb-0">© {{ date('Y') }} InvoicesPOS. Todos los derechos reservados.</p>
            <div class="flex items-center">
                <i class="fas fa-map-marker-alt mr-2 text-yellow-400"></i>
                <span class="text-gray-300">Costa Rica</span>
            </div>
        </div>
    </div>
</footer>