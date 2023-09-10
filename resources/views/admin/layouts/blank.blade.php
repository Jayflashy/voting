<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{get_setting('description')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Jadesdev" name="author" />
    <!-- Title -->
    <title>@yield('title') | {{get_setting('title')}}</title>
    <!-- Favicon -->
    <link rel="icon shortcut" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Bootstrap Css -->
    <link href="{{static_asset('admin/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons CSS  -->
    <link rel="stylesheet" href="{{static_asset('admin/css/icons.min.css')}}">
    <!-- Core Stylesheet -->
    <link rel="stylesheet"  id="app-style" href="{{static_asset('admin/css/app.min.css')}}">
    <link rel="stylesheet" href="{{static_asset('admin/css/vendors.css')}}">
    @yield('styles')

  </head>
  <body class="auth-body-bg">
    <div class="accountbg"></div>
    <div class="wrapper-page">
      @yield('content')
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

    <script src="{{static_asset('js/snackbar.min.js')}}"></script>
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
