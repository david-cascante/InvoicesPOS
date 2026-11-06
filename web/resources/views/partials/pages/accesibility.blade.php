<!-- Botón de Accesibilidad Flotante -->
<button id="accessibilityBtn" class="fixed left-6 bottom-6 w-12 h-12 bg-primary text-white rounded-full shadow-xl flex items-center justify-center hover:bg-primaryDark transition-all z-50">
    <i class="fas fa-universal-access text-xl"></i>
</button>

<!-- Modal de Accesibilidad -->
<div id="accessibilityModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Configuraciones de Accesibilidad</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modo Toca y Habla -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-gray-700">Modo Toca y Habla</h4>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="speakModeToggle" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
                <div id="speedControl" class="pl-2 hidden">
                    <label for="speechSpeed" class="block text-sm text-gray-600 mb-1">Velocidad de habla</label>
                    <input type="range" id="speechSpeed" min="0.5" max="2" step="0.1" value="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Lento</span>
                        <span>Normal</span>
                        <span>Rápido</span>
                    </div>
                </div>
            </div>
            
            <!-- Tamaño de letra -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">Tamaño de letra</h4>
                <div class="flex space-x-2">
                    <button id="decreaseFont" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">A-</button>
                    <button id="normalFont" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primaryDark transition">Normal</button>
                    <button id="increaseFont" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">A+</button>
                </div>
            </div>
            
            <!-- Alto contraste -->
            <div>
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold text-gray-700">Modo Alto Contraste</h4>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="highContrastToggle" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200">
                <button id="resetSettings" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">
                    <i class="fas fa-undo-alt mr-2"></i> Restablecer configuraciones
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Bienvenida a Accesibilidad -->
<div id="welcomeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md mx-4">
        <div class="text-center mb-6">
            <i class="fas fa-universal-access text-4xl text-primary mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Bienvenido a InvoicesPOS</h3>
            <p class="text-gray-600">¿Deseas configurar las opciones de accesibilidad ahora?</p>
        </div>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <button id="setupAccessibility" class="px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primaryDark transition flex-1">
                <i class="fas fa-cog mr-2"></i> Sí, configurar
            </button>
            <button id="skipSetup" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition flex-1">
                No, gracias
            </button>
        </div>
    </div>
</div>