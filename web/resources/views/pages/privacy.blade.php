@extends('layouts.pages')

@section('title', 'Política de Privacidad - InvoicesPOS')

@section('navbar')
    @include('partials.pages.navbar')
@endsection

@section('content')
    <div class="min-h-screen bg-white">
        

        
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