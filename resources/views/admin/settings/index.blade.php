@extends('admin.layouts.master')
@section('title') @lang('General Settings') @endsection

@section('content')

<div class="card mb-3">
    <div class="card-header h4">@lang('Website Information') </div>
    <div class="card-body">
        <form action="{{route('admin.setting.update')}}" method="post" class="row form-validate">
            @csrf
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">@lang('Website Name')</label>
                    <div class="">
                        <input type="text" name="title" required class="form-control" value="{{ get_setting('title') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Contest Amount') ({{get_setting('currency')}})</label>
                    <div class="">
                        <input type="text" name="price" required class="form-control" value="{{ get_setting('price') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Contest Amount') ({{get_setting('currency2')}})</label>
                    <div class="">
                        <input type="text" name="price2" required class="form-control" value="{{ get_setting('price2') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Website Email')</label>
                    <div class="">
                        <input type="text" name="email" class="form-control" value="{{ get_setting('email') }}">
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class=" form-label">@lang('Contest Type')</label>
                    <div class="">
                        <select name="contest_type" class="form-select" required>
                            <option value="free" @if (get_setting('contest_type') == 'free') selected @endif> Free Contest</option>
                            <option value="paid" @if (get_setting('contest_type') == 'paid') selected @endif> Paid Contest</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" form-label">@lang('Website Phone')</label>
                    <div class="">
                        <input type="tel" name="phone" required class="form-control" value="{{ get_setting('phone') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Address')</label>
                    <div class="">
                        <input type="text" name="address" required class="form-control" value="{{ get_setting('address') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Website About')</label>
                    <div class="">
                        <textarea name="description" rows="3" class="form-control">{{ get_setting('description') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 ">
                <button class="btn-success btn btn-block" type="submit">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header h4">@lang('Logo and Image Settings')</div>
    <div class="card-body">
        <form class="row" action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-lg-12">
                <label class="form-label">@lang('Site Logo')</label>
                <div class="col-sm-12 row">
                    <input type="file" class="form-control" name="logo" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('logo'))}}" alt="Site Logo" >
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label class="form-label">@lang('Favicon')</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control" name="favicon" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('favicon'))}}" alt="Favicon" >
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label class="form-label">@lang('Banner Image')</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control" name="banner" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('banner'))}}" alt="Banner Image" >
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label class="form-label">@lang('Sponsor Image')</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control" name="sponsor" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('sponsor'))}}" alt="Sponsor" >
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-success btn-block" type="submit">@lang('Update Setting')</button>
            </div>
        </form>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header h4">@lang('Currency Settings')</div>
    <div class="card-body">
        <form class="row" action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-sm-4 ">
                <label class="form-label">@lang('Currency Symbol')</label>
                <input type="text" class="form-control" name="currency" value="{{get_setting('currency')}}" required placeholder="Currency Symbol"/>
            </div>
            <div class="form-group col-sm-4">
                <label class="form-label">@lang('Currency Code')</label>
                <input type="text" class="form-control" name="currency_code" value="{{get_setting('currency_code')}}" required placeholder="Currency Code"/>
            </div>
            <div class="form-group col-sm-4 ">
                <label class="form-label">@lang('Currency2 Symbol')</label>
                <input type="text" class="form-control" name="currency2" value="{{get_setting('currency2')}}" required placeholder="Currency Symbol"/>
            </div>
            <div class="form-group col-sm-4">
                <label class="form-label">@lang('Currency2 Code')</label>
                <input type="text" class="form-control" name="currency_code2" value="{{get_setting('currency_code2')}}" required placeholder="Currency2 Code"/>
            </div>
            <div class="form-group col-sm-4">
                <label class="form-label">@lang('Conversion Rate') ( 1{{get_setting('currency_code2')}} to {{get_setting('currency_code')}} )</label>
                <input type="text" class="form-control" name="currency_rate" value="{{get_setting('currency_rate')}}" required placeholder="Conversion Rate"/>
            </div>
            <div class="text-end">
                <button class="btn btn-success btn-block" type="submit">@lang('Update Setting')</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<style>
    .btn-block{
        width: 100%
    }
    .primage {
        max-height: 100px !important;
        width: auto !important;
        margin: 10px;
    }
</style>
@endsection
