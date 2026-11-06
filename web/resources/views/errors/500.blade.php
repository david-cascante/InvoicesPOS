@extends('layouts.pages')

@section('title', 'Error del Servidor - InvoicesPOS')

@section('navbar')
    @include('partials.pages.navbar')
@endsection

@section('content')
    <div class="min-h-screen bg-white">
        <!-- Hero Section - Inspirado en el index -->
        <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-white to-primary/10 px-6 py-20 relative overflow-hidden">
            <!-- Elementos decorativos de fondo -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-red-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-red-600/15 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-red-500/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <!-- Badge de error -->
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-red-500/20 shadow-lg mb-12">
                    <div class="w-3 h-3 bg-gradient-to-r from-red-500 to-red-600 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-gray-700">ERROR 500 • ERROR DEL SERVIDOR</span>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    ¡Ups!
                    <span class="block bg-gradient-to-r from-gray-900 via-red-500 to-red-600 bg-clip-text text-transparent">
                        Error del Servidor
                    </span>
                </h1>

                <!-- Descripción -->
                <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
                    Algo salió mal en nuestro servidor. Nuestro equipo técnico ya ha sido notificado y está trabajando para solucionarlo.
                </p>

                <!-- CTA Principal -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    <a href="{{ route('home') }}" class="group relative bg-gradient-to-r from-primary to-primaryDark text-white px-10 py-5 rounded-2xl font-bold hover:from-primaryDark hover:to-primary transition-all duration-300 transform hover:-translate-y-2 shadow-2xl hover:shadow-3xl">
                        <span class="relative z-10 flex items-center gap-3">
                            <i class="fas fa-home"></i>
                            Volver al Inicio
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primaryDark to-primary rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity blur-sm -z-10"></div>
                    </a>
                    <a href="{{ route('home') }}#contact" class="group border-2 border-primary/20 text-gray-700 px-10 py-5 rounded-2xl font-semibold hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-headset text-primary"></i>
                            Contactar Soporte
                        </span>
                    </a>
                </div>

                <!-- ¿Qué puedes hacer? -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        ¿Qué puedes hacer ahora?
                    </h2>
                    <p class="text-lg text-gray-700 max-w-2xl mx-auto font-medium">
                        Mientras solucionamos este problema, aquí tienes algunas opciones
                    </p>
                </div>

                <!-- Opciones de solución -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-sync-alt text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center">Actualizar la página</h3>
                        <p class="text-sm text-gray-600 text-center">Intenta recargar la página en unos minutos. El problema podría ser temporal.</p>
                    </div>
                    
                    <div class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-history text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center">Reintentar más tarde</h3>
                        <p class="text-sm text-gray-600 text-center">Vuelve a intentarlo en 15-30 minutos mientras solucionamos el problema.</p>
                    </div>
                    
                    <a href="{{ route('home') }}#contact" class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2 text-center">Reportar el problema</h3>
                        <p class="text-sm text-gray-600 text-center">Si el problema persiste, contáctanos para que podamos ayudarte.</p>
                    </a>
                </div>

                <!-- Información adicional -->
                <div class="mt-12 bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-primary/20 max-w-2xl mx-auto">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tools text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Nuestro equipo está trabajando</h4>
                            <p class="text-sm text-gray-600">Hemos sido notificados del problema y estamos resolviéndolo lo antes posible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @include('partials.pages.footer')
@endsection