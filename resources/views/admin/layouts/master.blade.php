<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="{{get_setting('description')}}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="Jadesdev" name="author" />
        <!-- Title -->
        <title>@yield('title') | {{get_setting('title')}}</title>
        <!-- Favicon -->
        <link rel="icon shortcut" href="{{my_asset(get_setting('favicon'))}}" />

        <!-- Bootstrap Css -->
        <link href="{{static_asset('admin/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons CSS  -->
        <link rel="stylesheet" href="{{static_asset('admin/css/icons.min.css')}}" />
        <!-- Core Stylesheet -->
        <link rel="stylesheet" id="app-style" href="{{static_asset('admin/css/app.min.css')}}" />
        <link rel="stylesheet" href="{{static_asset('admin/css/vendors.css')}}" />
        @yield('styles')
    </head>
    <body>
        <div id="layout-wrapper">
            {{-- HEader --}}
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{route('admin.index')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{my_asset(get_setting('favicon'))}}" alt="" height="26" />
                                </span>
                                <span class="logo-lg">
                                    <img src="{{my_asset(get_setting('logo'))}}" alt="" height="24" />
                                </span>
                            </a>

                            <a href="{{route('admin.index')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{my_asset(get_setting('favicon'))}}" alt="" height="26" />
                                </span>
                                <span class="logo-lg">
                                    <img src="{{my_asset(get_setting('logo'))}}" alt="" height="24" />
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
                    </div>

                    <div class="d-flex">


                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img class="rounded-circle header-profile-user" src="{{(Auth::user()->image != null) ?my_asset(Auth::user()->image) : static_asset('img/profile.jpg')}}" alt="" /> --}}
                                <span class="d-none d-xl-inline-block ms-1">Admin  </span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="ri-user-line align-middle me-1"></i> @lang('Profile')</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{route('logout')}}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> @lang('Logout')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- left sidebar --}}
            @include('admin.layouts.sidebar')
            {{-- Page Content --}}
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('breadcrumb')
                        {{-- Content --}}
                         @yield('content')
                    </div>
                </div>
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            © {{get_setting('title')}}.
                        </div>
                        <div class="col-sm-6">
                            {{-- {!! main_scripts() !!} --}}
                            <div class="text-sm-end d-none d-sm-block">
                                <span class="float-end ms-3">V 1.0</span>
                                Developed by <a target="blank" href="https://jadesdev.com.ng">Jadesdev </a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Footer Nav -->
        <!-- All JavaScript Files -->
        <script src="{{static_asset('admin/js/jquery.min.js')}}"></script>
        <script src="{{static_asset('admin/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{static_asset('admin/js/metisMenu.min.js')}}"></script>
        <script src="{{static_asset('admin/js/simplebar.min.js')}}"></script>
        <script src="{{static_asset('admin/js/waves.min.js')}}"></script>
        <script src="{{static_asset('admin/js/vendors.js')}}"></script>
        <script src="{{static_asset('admin/js/core.js')}}"></script>
        <script src="{{static_asset('admin/js/app.js')}}"></script>

        <script src="{{static_asset('admin/js/snackbar.min.js')}}"></script>
        @yield('scripts')
        <script>
            @if(Session::get('success'))
            Snackbar.show({
              text: '{{Session::get('success')}}',
              pos: 'top-right',
              backgroundColor: '#38c172'
            });
            @endif
            @if(Session::get('error'))
            Snackbar.show({
              text: '{{Session::get('error')}}',
              pos: 'top-right',
              backgroundColor: '#e3342f'
            });
            @endif
            @if(count($errors) > 0)
            Snackbar.show({
              @foreach($errors->all() as $error)
              text: '{{$error}}',
              @endforeach
              pos: 'top-right',
              backgroundColor: '#e3342f'
            });
            @endif
        </script>
    </body>
</html>
