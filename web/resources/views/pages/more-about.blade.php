@extends('layouts.pages')

@section('title', 'Más sobre nosotros - InvoicesPOS')

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
                    <span class="text-sm font-semibold text-gray-700">NUESTRA HISTORIA • NUESTROS VALORES</span>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    Más sobre
                    <span class="block bg-gradient-to-r from-gray-900 via-primary to-primaryDark bg-clip-text text-transparent animate-gradient">
                        InvoicesPOS
                    </span>
                </h1>

                <!-- Descripción -->
                <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
                    Conoce nuestra <span class="text-primary font-semibold">misión, visión y valores</span> que nos impulsan a crear 
                    <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent font-bold">soluciones excepcionales</span> para tu negocio.
                </p>

                <!-- CTA Principal -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="#about-content" class="group relative bg-gradient-to-r from-primary to-primaryDark text-white px-10 py-5 rounded-2xl font-bold hover:from-primaryDark hover:to-primary transition-all duration-300 transform hover:-translate-y-2 shadow-2xl hover:shadow-3xl">
                        <span class="relative z-10 flex items-center gap-3">
                            <i class="fas fa-info-circle"></i>
                            Conocer Más
                            <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryDark to-primary rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity blur-sm -z-10"></div>
                    </a>
                    <a href="{{ route('home') }}#waitlist" class="group border-2 border-primary/20 text-gray-700 px-10 py-5 rounded-2xl font-semibold hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-crown text-primary"></i>
                            Acceso Anticipado
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- About Content -->
        <section id="about-content" class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-6xl mx-auto px-6">
                <!-- Mission & Vision -->
                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <!-- Mission -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-bullseye text-2xl text-white"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Misión</h2>
                        <div class="space-y-4 text-gray-700 leading-relaxed">
                            <p>Ayudamos a pequeños, medianos y grandes negocios a gestionar mejor su comercio.</p>
                            <p>Creamos un sistema POS fácil de usar, confiable y pensado para quienes necesitan ordenar, vender y crecer sin complicarse.</p>
                        </div>
                    </div>

                    <!-- Vision -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-eye text-2xl text-white"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Visión</h2>
                        <div class="space-y-4 text-gray-700 leading-relaxed">
                            <p>Ser la herramienta POS favorita de los emprendedores en Latinoamérica.</p>
                            <p>Queremos crecer con cada negocio, adaptarnos a sus retos y ofrecer siempre una solución moderna, cercana y simple.</p>
                        </div>
                    </div>
                </div>

                <!-- Values -->
                <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30 mb-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="fas fa-heart text-2xl text-white"></i>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-8 text-center">Nuestros Valores</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Value 1 -->
                        <div class="flex items-start p-6 bg-gradient-to-br from-white to-primary/5 rounded-2xl border border-primary/20 hover:border-primary/30 transition-all duration-300">
                            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mr-4 text-xl flex-shrink-0">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Innovación constante</h3>
                                <p class="text-gray-700">Siempre mejorando, siempre avanzando con las últimas tecnologías.</p>
                            </div>
                        </div>
                        
                        <!-- Value 2 -->
                        <div class="flex items-start p-6 bg-gradient-to-br from-white to-primary/5 rounded-2xl border border-primary/20 hover:border-primary/30 transition-all duration-300">
                            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mr-4 text-xl flex-shrink-0">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Soporte humano</h3>
                                <p class="text-gray-700">Te escuchamos, te respondemos, te ayudamos con atención personalizada.</p>
                            </div>
                        </div>
                        
                        <!-- Value 3 -->
                        <div class="flex items-start p-6 bg-gradient-to-br from-white to-primary/5 rounded-2xl border border-primary/20 hover:border-primary/30 transition-all duration-300">
                            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mr-4 text-xl flex-shrink-0">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Accesible para todos</h3>
                                <p class="text-gray-700">Sin barreras. Sin enredos. Diseñado para todos los niveles de experiencia.</p>
                            </div>
                        </div>
                        
                        <!-- Value 4 -->
                        <div class="flex items-start p-6 bg-gradient-to-br from-white to-primary/5 rounded-2xl border border-primary/20 hover:border-primary/30 transition-all duration-300">
                            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mr-4 text-xl flex-shrink-0">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Confianza y seguridad</h3>
                                <p class="text-gray-700">Tus datos protegidos, tu negocio tranquilo con encriptación de última generación.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        ¿Por Qué Elegir
                        <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">InvoicesPOS</span>
                    </h2>
                    <p class="text-xl text-gray-700 max-w-2xl mx-auto font-medium">
                        Descubre las ventajas que nos diferencian de otras soluciones POS
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <!-- Reason 1 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-dollar-sign text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Precio Justo</h3>
                        <p class="text-gray-700 leading-relaxed">Todo lo que necesitas, sin pagar de más. Transparencia total en nuestros planes y precios.</p>
                    </div>

                    <!-- Reason 2 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Funciones Poderosas</h3>
                        <p class="text-gray-700 leading-relaxed">Reportes en tiempo real, control de inventario, facturación completa y análisis predictivo con IA.</p>
                    </div>

                    <!-- Reason 3 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-cogs text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Mejoras Constantes</h3>
                        <p class="text-gray-700 leading-relaxed">Nos adaptamos a ti, no al revés. Actualizaciones regulares basadas en feedback real de usuarios.</p>
                    </div>

                    <!-- Reason 4 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-headset text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Soporte que Sí Responde</h3>
                        <p class="text-gray-700 leading-relaxed">No bots, no excusas. Personas reales que están contigo cuando más nos necesitas.</p>
                    </div>
                </div>

                <!-- Final CTA -->
                <div class="text-center bg-gradient-to-br from-primary to-primaryDark rounded-3xl p-12 shadow-2xl relative overflow-hidden">
                    <!-- Elementos decorativos -->
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primaryDark/30 rounded-full blur-3xl"></div>
                    
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 relative z-10">
                        ¿Listo para Transformar tu Negocio?
                    </h2>
                    <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto relative z-10">
                        InvoicesPOS es más que un software... es tu aliado para vender, controlar y crecer.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center relative z-10">
                        <a href="{{ route('home') }}#waitlist" class="group bg-white text-primary px-10 py-4 rounded-2xl font-bold hover:bg-primary hover:border hover:border-white/20 hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-2xl">
                            <span class="flex items-center gap-3">
                                <i class="fas fa-crown"></i>
                                Unirme a Lista de Espera
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        <a href="{{ route('home') }}#contact" class="group border-2 border-white text-white px-10 py-4 rounded-2xl font-semibold hover:bg-white/10 transition-all duration-300">
                            <span class="flex items-center gap-3">
                                <i class="fas fa-envelope"></i>
                                Contactar
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