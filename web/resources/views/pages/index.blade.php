@extends('layouts.pages')

@section('title', 'InvoicesPOS - Sistema de punto de venta Inteligente para tu negocio')

@section('navbar')
    @include('partials.pages.navbar')
@endsection

@section('content')
    <div class="min-h-screen bg-white">
        @if(session('successEarlyAccessUsersSubmit'))
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 animate-pop-in">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">¡Registro Exitoso!</h3>
                        <p class="text-gray-600 mb-6">Te has unido a nuestra lista de espera. Serás de los primeros en probar InvoicesPOS.</p>
                        <div class="flex justify-center space-x-4">
                            <button onclick="this.closest('div.fixed').remove()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primaryDark transition">
                                Continuar Explorando
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('successContactSubmit'))
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 animate-pop-in">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                            <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">¡Mensaje enviado!</h3>
                        <p class="text-gray-600 mb-6">Hemos recibido tu consulta y nos pondremos en contacto contigo pronto.</p>
                        <div class="flex justify-center space-x-4">
                            <button onclick="this.closest('div.fixed').remove()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primaryDark transition">
                                Entendido
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Hero Section - Con colores primary -->
        <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-white to-primary/10 px-6 py-20 relative overflow-hidden">
            <!-- Elementos decorativos de fondo -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-primaryDark/15 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-6xl mx-auto text-center relative z-10">
                <!-- Badge mejorado -->
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-lg mb-12">
                    <div class="w-3 h-3 bg-gradient-to-r from-primary to-primaryDark rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-gray-700">PRÓXIMA GENERACIÓN POS • CON INTELIGENCIA ARTIFICIAL</span>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    Punto de Venta
                    <span class="block bg-gradient-to-r from-gray-900 via-primary to-primaryDark bg-clip-text text-transparent animate-gradient">
                        Inteligente
                    </span>
                </h1>

                <!-- Descripción -->
                <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
                    Sistema POS diseñado con <span class="text-primary font-semibold">inteligencia artificial</span> para optimizar tu negocio. 
                    <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent font-bold">Simple, potente y accesible.</span>
                </p>

                <!-- CTA Principal -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-20">
                    <a href="#waitlist" class="group relative bg-gradient-to-r from-primary to-primaryDark text-white px-10 py-5 rounded-2xl font-bold hover:from-primaryDark hover:to-primary transition-all duration-300 transform hover:-translate-y-2 shadow-2xl hover:shadow-3xl">
                        <span class="relative z-10 flex items-center gap-3">
                            <i class="fas fa-crown text-yellow-300"></i>
                            Unirme a Lista de Espera
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryDark to-primary rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity blur-sm -z-10"></div>
                    </a>
                    <a href="#features" class="group border-2 border-primary/20 text-gray-700 px-10 py-5 rounded-2xl font-semibold hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-star text-primary"></i>
                            Ver Características
                        </span>
                    </a>
                </div>

                <!-- Estadísticas destacadas -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-2xl mx-auto">
                    <div class="text-center p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm">
                        <div class="text-2xl font-bold text-primary mb-2">+99%</div>
                        <div class="text-sm text-gray-600">Precisión IA</div>
                    </div>
                    <div class="text-center p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm">
                        <div class="text-2xl font-bold text-primaryDark mb-2">5min</div>
                        <div class="text-sm text-gray-600">Configuración</div>
                    </div>
                    <div class="text-center p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm">
                        <div class="text-2xl font-bold text-primary mb-2">24/7</div>
                        <div class="text-sm text-gray-600">Soporte</div>
                    </div>
                    <div class="text-center p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm">
                        <div class="text-2xl font-bold text-primaryDark mb-2">100%</div>
                        <div class="text-sm text-gray-600">Seguro</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Valor -->
        <section class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Por Qué Elegir
                        <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">InvoicesPOS</span>
                    </h2>
                    <p class="text-xl text-gray-700 max-w-2xl mx-auto font-medium">
                        Combinamos la potencia de la IA con una experiencia de usuario excepcional
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Valor 1 -->
                    <div class="group text-center p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-brain text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">IA que Aprende</h3>
                        <p class="text-gray-700 leading-relaxed">Algoritmos que se adaptan a tu negocio y mejoran con el tiempo, ofreciendo insights cada vez más precisos.</p>
                    </div>

                    <!-- Valor 2 -->
                    <div class="group text-center p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-bolt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Implementación Rápida</h3>
                        <p class="text-gray-700 leading-relaxed">Comienza en minutos con una interfaz intuitiva que tu equipo dominará desde el primer día.</p>
                    </div>

                    <!-- Valor 3 -->
                    <div class="group text-center p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-shield-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Seguro por Diseño</h3>
                        <p class="text-gray-700 leading-relaxed">Tus datos protegidos con encriptación de última generación y backups automáticos en la nube.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lista de Espera -->
        <section id="waitlist" class="py-20 bg-gradient-to-br from-primary via-primary to-primaryDark relative overflow-hidden">
            <!-- Elementos decorativos -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-primaryDark/30 rounded-full blur-3xl"></div>
            
            <div class="max-w-6xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        Acceso Anticipado Exclusivo
                    </h2>
                    <p class="text-xl text-white max-w-2xl mx-auto font-medium">
                        Sé de los primeros en transformar tu negocio con nuestra plataforma inteligente
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl border border-white/20 p-8 md:p-12 shadow-2xl">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Beneficios -->
                        <div>
                            <h3 class="text-3xl font-bold text-white mb-8">Ventajas para Miembros Fundadores</h3>
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-yellow-400/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 border border-yellow-400/30">
                                        <i class="fas fa-crown text-yellow-300 text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-lg">Descuento Permanente</h4>
                                        <p class="text-white">40% de descuento vitalicio en tu suscripción premium</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-green-400/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 border border-green-400/30">
                                        <i class="fas fa-headset text-green-300 text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-lg">Soporte Prioritario</h4>
                                        <p class="text-white">Atención directa con nuestro equipo de desarrollo fundador</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-primary-400/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 border border-primary-400/30">
                                        <i class="fas fa-cog text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-lg">Influencia en Features</h4>
                                        <p class="text-white">Vota y sugiere nuevas funcionalidades antes que nadie</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <div class="bg-white rounded-2xl p-8 shadow-2xl">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Únete a la Lista</h3>
                            <form action="{{ route('storeEarlyUser') }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="waitlist_name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre completo</label>
                                    <input type="text" id="waitlist_name" name="name" required 
                                           class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50">
                                </div>
                                
                                <div>
                                    <label for="waitlist_email" class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                                    <input type="email" id="waitlist_email" name="email" required 
                                           class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50">
                                </div>
                                
                                <div>
                                    <label for="waitlist_phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                                    <input type="tel" id="waitlist_phone_number" name="phone" required 
                                           class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50">
                                </div>
                                
                                <div>
                                    <label for="waitlist_business" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de negocio</label>
                                    <select id="waitlist_business" name="shop_type" 
                                            class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-50">
                                        <option value="tienda_ropa">Tienda de ropa</option>
                                        <option value="restaurante">Restaurante</option>
                                        <option value="electronica">Electrónica</option>
                                        <option value="supermercado">Supermercado</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-4 rounded-xl font-bold hover:from-primaryDark hover:to-primary transition-all transform hover:-translate-y-1 shadow-lg">
                                    Unirse a Lista de Espera
                                </button>
                                
                                <p class="text-xs text-gray-500 text-center">
                                    Solo enviaremos actualizaciones importantes sobre el lanzamiento
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Características -->
        <section id="features" class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Características
                        <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">Destacadas</span>
                    </h2>
                    <p class="text-xl text-gray-700 max-w-2xl mx-auto font-medium">
                        Diseñadas para simplificar y optimizar cada aspecto de tus operaciones
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Característica 1 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-cash-register text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Ventas Inteligentes</h3>
                        <p class="text-gray-700 leading-relaxed">Interfaz que acelera el proceso de venta con sugerencias de productos en tiempo real usando IA.</p>
                    </div>

                    <!-- Característica 2 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-boxes text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Inventario Predictivo</h3>
                        <p class="text-gray-700 leading-relaxed">La IA analiza tendencias y sugiere reposiciones antes de que se agoten los productos clave.</p>
                    </div>

                    <!-- Característica 3 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Analíticas en Tiempo Real</h3>
                        <p class="text-gray-700 leading-relaxed">Métricas clave y insights accionables para tomar decisiones informadas al instante.</p>
                    </div>

                    <!-- Característica 4 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-mobile-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Multi-dispositivo</h3>
                        <p class="text-gray-700 leading-relaxed">Accede desde tablet, celular o computadora con una experiencia consistente en todos los dispositivos.</p>
                    </div>

                    <!-- Característica 5 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-file-invoice text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Facturación Electrónica</h3>
                        <p class="text-gray-700 leading-relaxed">Genera facturas electrónicas compliant con la legislación de forma automática y segura.</p>
                    </div>

                    <!-- Característica 6 -->
                    <div class="group p-8 bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-primary/20 hover:border-primary/30">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-robot text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Asistente IA Integrado</h3>
                        <p class="text-gray-700 leading-relaxed">Responde preguntas de clientes y sugiere productos basado en comportamiento histórico de compra.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección IA -->
        <section id="ai" class="py-20 bg-gradient-to-br from-primary/5 to-primary/10">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Inteligencia Artificial
                            <span class="block bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">que Transforma</span>
                        </h2>
                        <p class="text-lg text-gray-700 mb-8 leading-relaxed font-medium">
                            Nuestros algoritmos de machine learning se adaptan a las particularidades de tu negocio, ofreciendo insights cada vez más precisos y relevantes para tu crecimiento.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-white/60 rounded-2xl border border-primary/20">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-brain text-primary text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-900">Predicción de demanda inteligente</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-white/60 rounded-2xl border border-primary/20">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-primary text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-900">Optimización automática de precios</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-white/60 rounded-2xl border border-primary/20">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-primary text-lg"></i>
                                </div>
                                <span class="font-bold text-gray-900">Análisis de comportamiento de clientes</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-primary to-primaryDark rounded-3xl p-8 shadow-2xl">
                        <div class="aspect-video bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                            <div class="text-center text-white">
                                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-robot text-white text-3xl"></i>
                                </div>
                                <p class="text-xl font-bold mb-2">Dashboard Inteligente</p>
                                <p class="text-white">Visualización de datos en tiempo real con IA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Desarrollo WordPress -->
        <section id="web" class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Presencia Web
                    <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">Profesional</span>
                </h2>
                <p class="text-xl text-gray-700 mb-12 max-w-2xl mx-auto font-medium">
                    Complementa tu sistema POS con un sitio web WordPress diseñado específicamente para retailers
                </p>

                <div class="bg-gradient-to-br from-white to-primary/5 rounded-3xl p-8 md:p-12 shadow-2xl border border-primary/20">
                    <div class="grid md:grid-cols-2 gap-8 text-left">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-wordpress text-primary"></i>
                                </div>
                                Desarrollo WordPress
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Diseño responsive y moderno</span>
                                </li>
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Optimizado para SEO</span>
                                </li>
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Integración con redes sociales</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-store text-primary"></i>
                                </div>
                                Especializado en Retail
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Galerías de productos atractivas</span>
                                </li>
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Diseño orientado a conversión</span>
                                </li>
                                <li class="flex items-center gap-3 p-3 bg-white rounded-xl border border-primary/20">
                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                    <span class="text-gray-700 font-medium">Compatibilidad con InvoicesPOS</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="#contact" class="inline-block bg-gradient-to-r from-primary to-primaryDark text-white px-10 py-4 rounded-2xl font-bold hover:from-primaryDark hover:to-primary transition-all transform hover:-translate-y-1 shadow-lg">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Solicitar Cotización
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Redes Sociales -->
        <section id="social" class="py-20 bg-gradient-to-br from-primary/5 to-primary/10">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Conecta con
                    <span class="bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">Nosotros</span>
                </h2>
                <p class="text-xl text-gray-700 mb-12 font-medium">
                    Síguenos para ver avances del desarrollo y consejos exclusivos para retailers
                </p>

                <div class="flex justify-center gap-8">
                    <a href="https://instagram.com/InvoicesPOS" target="_blank" 
                       class="group w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl shadow-lg flex items-center justify-center hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <i class="fab fa-instagram text-2xl text-white group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://facebook.com/InvoicesPOS" target="_blank" 
                       class="group w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl shadow-lg flex items-center justify-center hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <i class="fab fa-facebook text-2xl text-white group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>

                <div class="mt-12 bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-primary/20 max-w-md mx-auto">
                    <p class="text-gray-700 mb-4 font-medium">¿Quieres recibir actualizaciones exclusivas?</p>
                    <a href="#waitlist" class="inline-block bg-gradient-to-r from-primary to-primaryDark text-white px-8 py-3 rounded-xl font-semibold hover:from-primaryDark hover:to-primary transition-all">
                        Unirme a la Lista de Espera
                    </a>
                </div>
            </div>
        </section>

        <!-- Sobre el Desarrollador -->
        <section class="py-20 bg-gradient-to-br from-white to-primary/5">
            <div class="max-w-4xl mx-auto px-6">
                <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-primary/20">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">David Josué Cascante Alfaro</h2>
                            <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                                Desarrollador costarricense apasionado por crear soluciones tecnológicas que <span class="text-primary font-semibold">simplifiquen la vida de los empresarios</span> y impulsen sus negocios hacia el futuro.
                            </p>
                            
                            <!-- Botón "Ver información de InvoicesPOS" -->
                            <div class="mb-6">
                                <a href="{{ route('more-about') }}" 
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primaryDark text-white px-6 py-3 rounded-xl font-semibold hover:from-primaryDark hover:to-primary transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-info-circle"></i>
                                    Ver información de InvoicesPOS
                                </a>
                            </div>
                            
                            <div class="flex gap-4">
                                <a href="https://www.instagram.com/davidcafro/" target="_blank" 
                                class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center hover:bg-primary/20 transition-colors shadow-sm">
                                    <i class="fab fa-instagram text-primary"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/david-josu%C3%A9-cascante-alfaro-257903363/" target="_blank" 
                                class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center hover:bg-primary/20 transition-colors shadow-sm">
                                    <i class="fab fa-linkedin text-primary"></i>
                                </a>
                                <a href="https://github.com/SRJosu5" target="_blank" 
                                class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center hover:bg-primary/20 transition-colors shadow-sm">
                                    <i class="fab fa-github text-primary"></i>
                                </a>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="w-40 h-40 bg-gradient-to-br from-primary to-primaryDark rounded-full mx-auto flex items-center justify-center shadow-2xl p-1">
                                <div class="w-full h-full bg-white rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/img/david-profile.webp') }}" 
                                        alt="David Josué Cascante Alfaro"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contacto -->
        <section id="contact" class="py-20 bg-gradient-to-br from-primary to-primaryDark relative overflow-hidden">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-primaryDark/30 rounded-full blur-3xl"></div>
            
            <div class="max-w-2xl mx-auto px-6 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        ¿Tienes Preguntas?
                    </h2>
                    <p class="text-xl text-white font-medium">
                        Escríbenos y te responderemos pronto
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 shadow-2xl">
                    <form action="{{ route('storeLead') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-white mb-2">Nombre</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-4 border border-white/30 rounded-xl focus:ring-2 focus:ring-white focus:border-white transition bg-white/10 text-white placeholder-primary-200">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-semibold text-white mb-2">Correo</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-4 border border-white/30 rounded-xl focus:ring-2 focus:ring-white focus:border-white transition bg-white/10 text-white placeholder-primary-200">
                        </div>
                        
                        <div>
                            <label for="reason" class="block text-sm font-semibold text-white mb-2">Motivo</label>
                            <select id="reason" name="reason" required 
                                    class="w-full px-4 py-4 border border-white/30 rounded-xl focus:ring-2 focus:ring-white focus:border-white transition bg-white/10 text-white">
                                <option value="Información General" class="text-gray-900">Información General</option>
                                <option value="Soporte Técnico" class="text-gray-900">Soporte Técnico</option>
                                <option value="WordPress" class="text-gray-900">Desarrollo WordPress</option>
                                <option value="Otro" class="text-gray-900">Otro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-semibold text-white mb-2">Mensaje</label>
                            <textarea id="message" name="message" rows="4" required 
                                      class="w-full px-4 py-4 border border-white/30 rounded-xl focus:ring-2 focus:ring-white focus:border-white transition bg-white/10 text-white placeholder-primary-200"></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-white text-primary py-4 rounded-xl font-bold hover:bg-primary hover:text-white transition-all transform hover:-translate-y-1 shadow-lg">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Enviar Mensaje
                        </button>
                    </form>
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
            // Cerrar modales automáticamente después de 5 segundos
            const successModals = document.querySelectorAll('.fixed.inset-0.z-50');
            
            successModals.forEach(modal => {
                setTimeout(() => {
                    modal.style.opacity = '0';
                    modal.style.transition = 'opacity 0.3s ease-out';
                    setTimeout(() => modal.remove(), 300);
                }, 5000);
            });

            // Cerrar modal al hacer clic fuera
            successModals.forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.style.opacity = '0';
                        setTimeout(() => this.remove(), 300);
                    }
                });
            });

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