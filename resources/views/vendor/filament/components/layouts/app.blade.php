<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=amiri:400,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @filamentStyles
        @filamentScripts
        
        <!-- RTL CSS -->
        <link rel="stylesheet" href="{{ asset('css/filament-rtl.css') }}">

        <style>
            /* Force RTL */
            html, body {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* Fix sidebar */
            .filament-sidebar {
                right: 0 !important;
                left: auto !important;
            }
            
            /* Fix main content */
            .filament-main {
                margin-right: 16rem !important;
                margin-left: 0 !important;
            }
            
            /* Fix tables */
            .filament-tables-table th,
            .filament-tables-table td {
                text-align: right !important;
            }
            
            /* Fix forms */
            .filament-forms-field-wrapper label {
                text-align: right !important;
            }
            
            /* Fix navigation */
            .filament-sidebar-nav {
                direction: rtl !important;
            }
            
            /* Fix dropdowns */
            .filament-dropdown {
                right: 0 !important;
                left: auto !important;
            }
            
            /* Arabic font */
            * {
                font-family: 'Amiri', 'Noto Naskh Arabic', serif !important;
            }
        </style>
    </head>

    <body class="font-sans antialiased rtl" dir="rtl">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900" dir="rtl">
            @include('filament.components.sidebar')

            <div class="lg:pl-72" dir="rtl">
                @include('filament.components.header')

                <main class="py-10" dir="rtl">
                    <div class="px-4 sm:px-6 lg:px-8" dir="rtl">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html> 