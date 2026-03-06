<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; }
            body {
                font-family: 'Outfit', sans-serif;
                min-height: 100vh;
                background: radial-gradient(ellipse at 0% 100%, #2a0e5a 0%, #0c1340 35%, #06082a 70%);
                color: #e2e8f0;
            }
            .glass-card {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px;
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            }
            .glass-card-solid {
                background: rgba(13,17,58,0.75);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 20px;
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                box-shadow: 0 8px 32px rgba(0,0,0,0.35);
            }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1, #4f46e5);
                color: #fff;
                font-weight: 600;
                border-radius: 10px;
                padding: 10px 24px;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
            }
            .btn-primary:hover { filter: brightness(1.15); transform: translateY(-1px); }
            .btn-danger {
                background: linear-gradient(135deg, #ef4444, #dc2626);
                color: #fff;
                font-weight: 600;
                border-radius: 10px;
                padding: 10px 24px;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
            }
            .btn-danger:hover { filter: brightness(1.15); transform: translateY(-1px); }
            .input-dark {
                background: rgba(255,255,255,0.06) !important;
                border: 1px solid rgba(255,255,255,0.15) !important;
                color: #e2e8f0 !important;
                border-radius: 10px !important;
            }
            .input-dark:focus { border-color: rgba(99,102,241,0.7) !important; outline: none !important; box-shadow: 0 0 0 3px rgba(99,102,241,0.2) !important; }
            .input-dark::placeholder { color: rgba(255,255,255,0.35) !important; }
            label { color: #94a3b8 !important; font-size: 13px !important; font-weight: 500 !important; }
            .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.35); color: #6ee7b7; border-radius: 12px; padding: 14px 18px; }
            .alert-error   { background: rgba(239,68,68,0.15);  border: 1px solid rgba(239,68,68,0.35);  color: #fca5a5; border-radius: 12px; padding: 14px 18px; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-transparent text-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
