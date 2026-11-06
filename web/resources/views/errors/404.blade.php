@extends('layouts.pages')

@section('title', 'Página no encontrada - InvoicesPOS')

@section('navbar')
    @include('partials.pages.navbar')
@endsection

@section('content')
    <div class="min-h-screen bg-white">
        <!-- Hero Section - Inspirado en el index -->
        <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-white to-primary/10 px-6 py-20 relative overflow-hidden">
            <!-- Elementos decorativos de fondo -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-primaryDark/15 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <!-- Badge de error -->
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-lg mb-12">
                    <div class="w-3 h-3 bg-gradient-to-r from-red-500 to-red-600 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-gray-700">ERROR 404 • PÁGINA NO ENCONTRADA</span>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    ¡Ups!
                    <span class="block bg-gradient-to-r from-gray-900 via-primary to-primaryDark bg-clip-text text-transparent">
                        Página no encontrada
                    </span>
                </h1>

                <!-- Descripción -->
                <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
                    Lo sentimos, la página que estás buscando no existe o ha sido movida.
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

                <!-- Enlaces sugeridos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                    <a href="{{ route('home') }}" class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-home text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Página de Inicio</h3>
                        <p class="text-sm text-gray-600">Descubre todo lo que ofrece InvoicesPOS</p>
                    </a>
                    
                    <a href="{{ route('home') }}#features" class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-star text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Características</h3>
                        <p class="text-sm text-gray-600">Conoce las funcionalidades de nuestro sistema</p>
                    </a>
                    
                    <a href="{{ route('home') }}#waitlist" class="group p-6 bg-white/60 backdrop-blur-sm rounded-2xl border border-primary/20 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-clipboard-list text-white text-lg"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Lista de Espera</h3>
                        <p class="text-sm text-gray-600">Únete para acceso anticipado y beneficios</p>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @include('partials.pages.footer')
@endsection