<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InvoicesPOS')</title>

    <link rel="icon" href="{{ asset('assets/img/invoicespos-icon.webp') }}" type="image/webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/pages.css') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#003f44',
                        primaryDark: '#003f44',
                        primaryLight: '#003f44',
                        primaryBg: '#f2feff'
                    }
                }
            }
        }
    </script>
</head>
<body>
    <header>
        @yield('navbar')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @yield('footer')
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 w-12 h-12 bg-primary text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-primaryDark">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('partials.pages.accesibility')

    <script src="{{ asset('assets/js/pages/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('animate-pop-in');
            }, 10);
        }

        function closeCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('animate-pop-in');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });

        // Cerrar modal con la tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
            }
        });
    </script>
    @yield('scripts')
    @yield('styles')
</body>
</html>