<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos de Font Awesome -->
    <script src="https://kit.fontawesome.com/708e2917d6.js" crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">

    <!-- Sweet Alert 2 (tema por defecto compatible con Bootstrap claro) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar position-fixed col-md-3 col-lg-2 bg-body-secondary rounded min-vh-100 p-3">
                <div class="d-flex flex-column h-100">
                    <div class="d-grid gap-2 col-12 mx-auto ">
                        <a class="navbar-brand d-flex flex-column align-items-center" href="{{ url('/home') }}" style="height: 70px;">
                            <div class="d-flex align-items-end h-100">
                                <img src="{{ asset('imagenes/logo_telpri.png') }}" alt="Logo TelPri" class="img-fluid logo-sidebar" style="height: 50px;">
                            </div>
                        </a>
                        @can('Menu Lineas')
                        <div class="border-top my-2 nav-item"></div>
                        <a class="btn btn-primary" href="{{ url('/lineas') }}">
                            <i class="fa-solid fa-phone me-2"></i>Líneas
                        </a>
                        @endcan
                        @can('Menu Plataformas')
                        <div class="border-top my-2 nav-item"></div>  
                        <a class="btn btn-primary text-center" href="{{ url('/plataformas') }}">
                            <i class="fa-solid fa-tower-cell me-2"></i>Adm. de Plataformas
                        </a>
                        @endcan
                        @can('Menu Ubicaciones')
                        <a class="btn btn-primary text-center" href="{{ url('/ubicaciones') }}">
                            <i class="fa-solid fa-ethernet me-2"></i>Adm. de Ubicaciones
                        </a>
                        @endcan
                        @can('Menu Localidades')
                        <a class="btn btn-primary text-center" href="{{ url('/localidades') }}">
                            <i class="fa-regular fa-building me-2"></i>Adm. de Localidades
                        </a>
                        @endcan
                        <!--
                        <a class="btn btn-primary text-center" href="{{ url('/pisos') }}">
                            <i class="fa-solid fa-elevator me-2"></i>Adm. de Pisos
                        </a>
                        -->
                        @can('Menu Usuarios')
                        <a class="btn btn-primary text-center" href="{{ url('/usuarios') }}">
                            <i class="fa-solid fa-person me-2"></i>Adm. de Usuarios
                        </a>
                        @endcan
                        @can('Menu Sistema')
                        <div class="border-top my-2 nav-item"></div>                    
                        <a class="btn btn-primary text-center" href="{{ url('/roles') }}">
                            <i class="fa-solid fa-address-card me-2"></i>Adm. de Roles
                        </a>
                        <!--
                        <a class="btn btn-primary text-center" href="{{ url('/permisos') }}">
                            <i class="fa-solid fa-list-check me-2"></i>Adm. de Permisos
                        </a>
                        -->
                        <div class="border-top my-2 nav-item"></div>
                        @endcan
                        @guest
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-right-to-bracket"></i> Ingresar
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-user-plus"></i> Registrar
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="dropdown dropdown w-100">
                                <a class="btn btn-outline-secondary w-100 dropdown-toggle" href="#" role="button" id="sidebarUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user me-2"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sidebarUserMenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('usuarios/'.Auth::user()->id.'/edit') }}">
                                            <i class="fa-solid fa-gear me-2"></i> Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                            <i class="fa-solid fa-right-to-bracket me-2"></i> Cerrar Sesión
                                        </a>
                                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                    <div class="mt-3 d-flex justify-content-evenly align-items-center">
                        <img src="{{ asset('imagenes/logo_cantv.png') }}" alt="Logo CANTV" class="img-fluid logo-footer m-3" style="width: 40%;">
                        <img src="{{ asset('imagenes/logo_uneti.png') }}" alt="Logo Uneti" class="img-fluid logo-footer m-3" style="width: 40%;">
                    </div>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="contenido col-md-9 col-lg-10 ms-sm-auto">
                @yield('contenido')
            </main>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <!-- iMask -->
    <script src="https://unpkg.com/imask"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- Custom DataTables Initialization -->
    <script>
        function initializeDataTable(tableId, options = {}) {
            const defaultOptions = {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                dom: '<"row"<"col-sm-12 col-md-6 mb-2"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    'excel', 'pdf', 'print'
                ],
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
                pageLength: 20,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel"></i>',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-outline-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa-solid fa-file-pdf"></i>',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-outline-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa-solid fa-print"></i>',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-outline-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            };
            const mergedOptions = {...defaultOptions, ...options};
            $(tableId).DataTable(mergedOptions);
        }
    </script>

    @stack('scripts')
</body>
</html>