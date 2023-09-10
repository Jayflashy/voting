@extends('admin.layouts.master')
@section('title') @lang('Account Settings') @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 form-label" for="name">{{__('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" value="{{Auth::user()->name}}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 form-label" for="email">{{__('Email Address')}}</label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{__('Email Address')}}" id="email" name="email" class="form-control" value="{{Auth::user()->email}}" required>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 form-label" for="password">{{__('Password')}}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{__('Password')}}" id="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-3 text-end">
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
