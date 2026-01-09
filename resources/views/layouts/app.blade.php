<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <meta name="supported-color-schemes" content="light dark" />
    @include('layouts.style')

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg fixed-header fixed-footer  sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <x-navbar />
        <x-sidebar />
        <main class="app-main">
            <!-- Inside your main layout where content goes -->
            <div class="app-content-header py-2">
                <div class="container-fluid">
                    <div class="row align-items-center ">
                        <div class="col-sm-6">
                            <h5 class="mb-0 text-uppercase fw-bold">
                                @yield('page-title', 'Dashboard') <!-- default title -->
                            </h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary">Home</a></li>
                                @yield('breadcrumb') <!-- dynamic breadcrumb items -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">{{ auth()->user()->organization->name }}</div>
            <strong>
                Copyright &copy; {{ now()->format('Y') }}&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">Nepbyte</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>

    @include('layouts.js')

    @stack('scripts')
</body>

</html>
