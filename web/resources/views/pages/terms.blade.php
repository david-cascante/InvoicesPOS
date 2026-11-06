@extends('layouts.pages')

@section('title', 'Términos y condiciones - InvoicesPOS')

@section('navbar')
    @include('partials.pages.navbar')
@endsection

@section('content')
    <div class="min-h-screen bg-white">
        <!-- Hero Section - Coherente con index2.blade.php -->
        <section class="min-h-[60vh] flex items-center justify-center bg-gradient-to-br from-primary/5 via-white to-primary/10 px-6 py-20 relative overflow-hidden">
            <!-- Elementos decorativos de fondo -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-primaryDark/15 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-6xl mx-auto text-center relative z-10">
                <!-- Badge mejorado -->
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-lg mb-8">
                    <div class="w-3 h-3 bg-gradient-to-r from-primary to-primaryDark rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-gray-700">CONTRATO LEGAL • USO DEL SISTEMA</span>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    Términos y
                    <span class="block bg-gradient-to-r from-gray-900 via-primary to-primaryDark bg-clip-text text-transparent animate-gradient">
                        Condiciones
                    </span>
                </h1>

                <!-- Descripción -->
                <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
                    Conoce los términos que rigen el uso de nuestro 
                    <span class="text-primary font-semibold">sistema de punto de venta</span> con 
                    <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent font-bold">transparencia y claridad</span>.
                </p>

                <!-- CTA Principal -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="#terms-content" class="group relative bg-gradient-to-r from-primary to-primaryDark text-white px-10 py-5 rounded-2xl font-bold hover:from-primaryDark hover:to-primary transition-all duration-300 transform hover:-translate-y-2 shadow-2xl hover:shadow-3xl">
                        <span class="relative z-10 flex items-center gap-3">
                            <i class="fas fa-file-contract"></i>
                            Ver Términos Completos
                            <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryDark to-primary rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity blur-sm -z-10"></div>
                    </a>
                    <a href="{{ route('privacy') }}" class="group border-2 border-primary/20 text-gray-700 px-10 py-5 rounded-2xl font-semibold hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-shield-alt text-primary"></i>
                            Ver Política de Privacidad
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Terms Content -->
        <section id="terms-content" class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-6xl mx-auto px-6">
                <!-- Header de los términos -->
                <div class="bg-gradient-to-br from-white to-primary/5 rounded-3xl p-8 md:p-12 shadow-2xl border border-primary/20 mb-12">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                        <div class="text-center md:text-left">
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-primary bg-primary/10 rounded-full mb-4">
                                ÚLTIMA ACTUALIZACIÓN
                            </span>
                            <p class="text-gray-600">4 de mayo del 2025</p>
                        </div>
                        <div class="mt-6 md:mt-0">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-file-contract text-2xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary/5 rounded-2xl p-6 border-l-4 border-primary">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-primary text-xl mr-4 mt-1"></i>
                            <p class="text-lg text-gray-700">
                                Al utilizar InvoicesPOS, aceptás los siguientes términos. Si no estás de acuerdo con alguno, por favor no utilices el sistema.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido de los términos -->
                <div class="space-y-8">
                    <!-- Grupo 1: Uso del Software -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-laptop-code text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Uso del Software</h3>
                                <p class="text-gray-700 text-lg">InvoicesPOS es un sistema diseñado para ayudar a negocios a gestionar sus ventas, inventario y operaciones. Al registrarte y usarlo, aceptás usarlo de manera legal, responsable y sin afectar a terceros.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 2: Licencia de uso -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-key text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Licencia de uso</h3>
                                <p class="text-gray-700 text-lg">Te damos acceso al sistema bajo una licencia no exclusiva, personal e intransferible. No podés revender, copiar o modificar el software sin autorización previa.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 3: Propiedad intelectual -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-copyright text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Propiedad intelectual</h3>
                                <p class="text-gray-700 text-lg">Todo el contenido, diseño, funciones y código del sistema es propiedad de David Josué Cascante Alfaro. Está prohibido su uso sin permiso.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 4: Responsabilidad del usuario -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-user-shield text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Responsabilidad del usuario</h3>
                                <p class="text-gray-700 text-lg">Vos sos responsable de toda la información que ingreses en el sistema, incluyendo datos de clientes, inventario y facturación.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 5: Soporte técnico -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-headset text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Soporte técnico</h3>
                                <p class="text-gray-700 text-lg">Ofrecemos soporte técnico vía correo electrónico u otros canales oficiales. Hacemos lo posible por responder rápido y de forma clara.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 6: Actualizaciones -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-sync-alt text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Actualizaciones</h3>
                                <p class="text-gray-700 text-lg">El sistema se actualiza de forma periódica para mejorar funciones, corregir errores y añadir mejoras. Podemos cambiar estos términos en cualquier momento, avisando por nuestros canales oficiales.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 7: Seguridad y privacidad -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-lock text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Seguridad y privacidad</h3>
                                <p class="text-gray-700 text-lg">Tomamos medidas para proteger tus datos. No vendemos ni compartimos tu información con terceros. Para más detalles, consultá nuestra 
                                    <a href="{{ route('privacy') }}" class="text-primary hover:text-primaryDark font-semibold hover:underline transition-colors">
                                        Política de Privacidad
                                    </a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 8: Limitación de responsabilidad -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Limitación de responsabilidad</h3>
                                <p class="text-gray-700 text-lg">Hacemos todo lo posible para que el sistema funcione correctamente, pero no nos hacemos responsables por pérdidas de datos, fallos técnicos o mal uso por parte del usuario.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 9: Ley aplicable -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-balance-scale text-2xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Ley aplicable</h3>
                                <p class="text-gray-700 text-lg">Este acuerdo se rige por las leyes de Costa Rica. En caso de disputa, se resolverá en los tribunales competentes del país.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="mt-16 text-center bg-gradient-to-br from-primary to-primaryDark rounded-3xl p-12 shadow-2xl relative overflow-hidden">
                    <!-- Elementos decorativos -->
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primaryDark/30 rounded-full blur-3xl"></div>
                    
                    <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-white bg-white/20 rounded-full relative z-10">
                        ¿TIENES DUDAS?
                    </span>
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 relative z-10">Estamos aquí para ayudarte</h3>
                    <p class="text-white/90 mb-8 max-w-2xl mx-auto text-lg relative z-10">Si tienes preguntas sobre nuestros términos y condiciones, no dudes en contactar a nuestro equipo de soporte.</p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center relative z-10">
                        <a href="{{ route('home') }}#contact" class="group bg-white text-primary px-10 py-4 rounded-2xl font-bold hover:bg-primary hover:border hover:border-white/20 hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-2xl">
                            <span class="flex items-center gap-3">
                                <i class="fas fa-headset"></i>
                                Contactar Soporte
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        <a href="{{ route('privacy') }}" class="group border-2 border-white text-white px-10 py-4 rounded-2xl font-semibold hover:bg-white/10 transition-all duration-300">
                            <span class="flex items-center gap-3">
                                <i class="fas fa-shield-alt"></i>
                                Ver Política de Privacidad
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @include('partials.pages.footer')
@endsection

@push('styles')
    <style>
        .animate-pop-in {
            animation: popIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .animate-gradient {
            animation: gradientShift 3s ease-in-out infinite;
            background-size: 200% 200%;
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* Mejoras de accesibilidad */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Enfoque visible para todos los elementos interactivos */
        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 3px solid #ffffff;
            outline-offset: 2px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll para enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endpush