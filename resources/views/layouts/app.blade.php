<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .laura-swal-popup {
                border-radius: 16px;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35);
                border: 1px solid rgba(148, 163, 184, 0.22);
            }

            .laura-swal-title {
                font-size: 1.25rem;
                font-weight: 700;
            }

            .laura-swal-html {
                font-size: 0.95rem;
                line-height: 1.5;
            }

            .laura-swal-confirm,
            .laura-swal-cancel {
                border-radius: 10px !important;
                font-weight: 600 !important;
                padding: 0.6rem 1.1rem !important;
            }

            .laura-swal-errors {
                text-align: left;
                margin-top: 0.4rem;
            }

            .laura-swal-error-item {
                margin-bottom: 0.25rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swal === 'undefined') {
                    return;
                }

                const isDarkMode = document.documentElement.classList.contains('dark');
                const palette = {
                    success: '#059669',
                    error: '#dc2626',
                    warning: '#d97706',
                    neutral: '#475569'
                };

                const baseModalOptions = {
                    background: isDarkMode ? '#0f172a' : '#ffffff',
                    color: isDarkMode ? '#e2e8f0' : '#0f172a',
                    backdrop: isDarkMode ? 'rgba(2, 6, 23, 0.72)' : 'rgba(15, 23, 42, 0.45)',
                    customClass: {
                        popup: 'laura-swal-popup',
                        title: 'laura-swal-title',
                        htmlContainer: 'laura-swal-html',
                        confirmButton: 'laura-swal-confirm',
                        cancelButton: 'laura-swal-cancel'
                    },
                    buttonsStyling: true
                };

                function showAlert(options) {
                    return Swal.fire(Object.assign({}, baseModalOptions, options));
                }

                const successMessage = @json(session('success'));
                const errorMessage = @json(session('error'));
                const validationErrors = @json($errors->all());

                if (successMessage) {
                    showAlert({
                        icon: 'success',
                        title: 'Operacion completada',
                        text: successMessage,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: palette.success
                    });
                } else if (errorMessage) {
                    showAlert({
                        icon: 'error',
                        title: 'No se pudo completar',
                        text: errorMessage,
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: palette.error
                    });
                } else if (validationErrors.length > 0) {
                    const errorsHtml = [
                        '<div class="laura-swal-errors">',
                        validationErrors.map(function (error) {
                            return '<div class="laura-swal-error-item">- ' + error + '</div>';
                        }).join(''),
                        '</div>'
                    ].join('');

                    showAlert({
                        icon: 'warning',
                        title: 'Revisa el formulario',
                        html: errorsHtml,
                        confirmButtonText: 'Corregir',
                        confirmButtonColor: palette.warning
                    });
                }

                document.querySelectorAll('form[data-confirm-delete="true"]').forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();

                        const title = form.getAttribute('data-confirm-title') || 'Confirmar eliminacion';
                        const text = form.getAttribute('data-confirm-text') || 'Esta accion no se puede deshacer.';

                        showAlert({
                            icon: 'warning',
                            title: title,
                            text: text,
                            showCancelButton: true,
                            confirmButtonText: 'Si, eliminar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true,
                            focusCancel: true,
                            confirmButtonColor: palette.error,
                            cancelButtonColor: palette.neutral
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>
