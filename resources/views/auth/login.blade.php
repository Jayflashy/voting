@extends('admin.layouts.blank')
@section('title', 'Admin Login')

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="text-center mt-0 mb-3">
            <a href="{{route('index')}}" class="logo"><img src="{{my_asset(get_setting('logo'))}}" height="24" alt="logo-img"></a>
        </h3>
        <h5 class="text-center mt-0 text-color"><b>Admin Sign In</b></h5>

        <form class="form-horizontal mt-3 mx-3" method="POST" action="{{route('login')}}">
            @csrf
            <div class="form-group mb-3">
                <div class="col-12">
                    <input class="form-control" name="username" type="text" required="" placeholder="Email or Username">
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="col-12">
                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-12">
                    <div class="checkbox checkbox-primary">
                        <input id="checkbox-signup" name="remember" type="checkbox" checked="">
                        <label for="checkbox-signup" class="text-color">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group text-center mt-3">
                <div class="col-12">
                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light w-100" type="submit">
                        Log In</button>
                </div>
            </div>

            <div class="form-group row mt-4 mb-0">
                <div class="col-sm-7">
                    <a href="{{route('password.request')}}" class="text-color">
                        <i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('breadcrumb')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">@yield('title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@endsection
