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
            /* Force RTL - Very Strong */
            html, body, * {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* Force RTL on all elements */
            *, *::before, *::after {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* Fix sidebar */
            .filament-sidebar,
            [class*="filament-sidebar"] {
                right: 0 !important;
                left: auto !important;
            }
            
            /* Fix main content */
            .filament-main,
            [class*="filament-main"] {
                margin-right: 16rem !important;
                margin-left: 0 !important;
            }
            
            /* Fix tables */
            .filament-tables-table th,
            .filament-tables-table td,
            [class*="filament-tables"] th,
            [class*="filament-tables"] td {
                text-align: right !important;
            }
            
            /* Fix forms */
            .filament-forms-field-wrapper label,
            [class*="filament-forms"] label {
                text-align: right !important;
            }
            
            /* Fix navigation */
            .filament-sidebar-nav,
            [class*="filament-sidebar-nav"] {
                direction: rtl !important;
            }
            
            /* Fix dropdowns */
            .filament-dropdown,
            [class*="filament-dropdown"] {
                right: 0 !important;
                left: auto !important;
            }
            
            /* Arabic font */
            * {
                font-family: 'Amiri', 'Noto Naskh Arabic', serif !important;
            }
            
            /* Fix all Filament components */
            [class*="filament-"] {
                direction: rtl !important;
            }
            
            /* Fix specific elements */
            .filament-header,
            .filament-main-content,
            .filament-page,
            .filament-widget,
            .filament-card,
            .filament-button-group,
            .filament-tabs,
            .filament-notifications,
            .filament-global-search,
            .filament-user-menu,
            .filament-breadcrumbs,
            .filament-actions,
            .filament-pagination {
                direction: rtl !important;
            }
            
            /* Additional RTL fixes */
            .filament-sidebar-nav-item {
                text-align: right !important;
            }
            
            .filament-sidebar-nav-group {
                direction: rtl !important;
            }
            
            .filament-sidebar-nav-group-label {
                text-align: right !important;
            }
            
            /* Fix buttons */
            .filament-button {
                direction: rtl !important;
            }
            
            /* Fix modals */
            .filament-modal {
                direction: rtl !important;
            }
            
            /* Fix tooltips */
            .filament-tooltip {
                direction: rtl !important;
            }
            
            /* Force RTL on all elements */
            div, span, p, h1, h2, h3, h4, h5, h6, a, button, input, textarea, select, table, tr, td, th {
                direction: rtl !important;
            }
            
            /* Ultra Strong RTL */
            body {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* Force RTL on all Filament elements */
            [class*="filament"] {
                direction: rtl !important;
                text-align: right !important;
            }
            
            /* Fix all possible elements */
            .filament-sidebar,
            .filament-main,
            .filament-header,
            .filament-content,
            .filament-page,
            .filament-widget,
            .filament-card,
            .filament-form,
            .filament-table,
            .filament-button,
            .filament-dropdown,
            .filament-modal,
            .filament-notification {
                direction: rtl !important;
                text-align: right !important;
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