@extends('admin.layouts.master')
@section('title') @lang('Payment Settings') @endsection

@section('content')
<div class="row">
    <div class="col-6 col-sm-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Flutterwave</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-9">
                        <label class="form-label">Enable Flutterwave</label>
                    </div>
                    <div class="col-md-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'flutterwave_payment')" @if(sys_setting('flutterwave_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Paypal Payment</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-9">
                        <label class="form-label">Enable Paypal</label>
                    </div>
                    <div class="col-md-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'paypal_payment')" @if(sys_setting('paypal_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Stripe Payment</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-9">
                        <label class="form-label">Enable Stripe</label>
                    </div>
                    <div class="col-md-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'stripe_payment')" @if(sys_setting('stripe_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Momo Payment</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-9">
                        <label class="form-label">Enable Momo</label>
                    </div>
                    <div class="col-md-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'momo_payment')" @if(sys_setting('momo_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title text-center">{{__('Flutterwave Credential')}}</h3>
            </div>
            <form action="{{ route('admin.setting.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="payment_method" value="flutter">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="FLW_PUBLIC_KEY">
                        <label class="form-label">{{__('FLW PUBLIC KEY')}}</label>
                        <input type="text" class="form-control" name="FLW_PUBLIC_KEY" value="{{  env('FLW_PUBLIC_KEY') }}" placeholder="FLUTTERWAVE PUBLIC KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="FLW_SECRET_KEY">
                        <label class="form-label">{{__('FLW SECRET KEY')}}</label>
                        <input type="text" class="form-control" name="FLW_SECRET_KEY" value="{{  env('FLW_SECRET_KEY') }}" placeholder="FLUTTERWAVE PUBLIC KEY" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary w-100" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4 ">
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title text-center">{{__('Paypal Credential')}}</h3>
            </div>
            <form action="{{ route('admin.setting.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="payment_method" value="paypal">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                        <label class="form-label">{{__('Paypal Client Id')}}</label>
                        <input type="text" class="form-control" name="PAYPAL_CLIENT_ID" value="{{  env('PAYPAL_CLIENT_ID') }}" placeholder="Paypal Client ID" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                        <label class="form-label">{{__('Paypal Client Secret')}}</label>
                        <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET" value="{{  env('PAYPAL_CLIENT_SECRET') }}" placeholder="Paypal Client Secret" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary btn-block" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mt-2">
            <div class="card-header">
                <h3 class="card-title text-center">{{__('Stripe Credential')}}</h3>
            </div>
            <form action="{{ route('admin.setting.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="payment_method" value="stripe">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="STRIPE_KEY">
                        <label class="form-label">{{__('STRIPE KEY')}}</label>
                        <input type="text" class="form-control" name="STRIPE_KEY" value="{{  env('STRIPE_KEY') }}" placeholder="STRIPE KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="STRIPE_SECRET">
                        <label class="form-label">{{__('STRIPE SECRET')}}</label>
                        <input type="text" class="form-control" name="STRIPE_SECRET" value="{{  env('STRIPE_SECRET') }}" placeholder="STRIPE SECRET" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary btn-block" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12 ">
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title text-center">{{__('Momo Credential')}}</h3>
            </div>
            <form action="{{ route('admin.setting.store') }}" method="POST">
                @csrf
                <div class="card-body row">
                    <input type="hidden" name="payment_method" value="momo">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_API_KEY">
                            <label class="form-label">{{__('Momo API Key')}}</label>
                            <input type="text" class="form-control" name="MOMO_API_KEY" value="{{ env('MOMO_API_KEY') }}" placeholder="Momo API Key" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_USER_ID">
                            <label class="form-label">{{__('Momo User ID')}}</label>
                            <input type="text" class="form-control" name="MOMO_USER_ID" value="{{ env('MOMO_USER_ID') }}" placeholder="Momo User ID" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_ENVIRONMENT">
                            <label class="form-label">{{__('Momo Environment')}}</label>
                            <input type="text" class="form-control" name="MOMO_ENVIRONMENT" value="{{ env('MOMO_ENVIRONMENT') }}" placeholder="Momo Environment" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_API_BASE_URI">
                            <label class="form-label">{{__('Momo Base URL')}}</label>
                            <input type="text" class="form-control" name="MOMO_API_BASE_URI" value="{{ env('MOMO_API_BASE_URI') }}" placeholder="Momo  Base URL" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_CURRENCY">
                            <label class="form-label">{{__('Momo Currency')}}</label>
                            <input type="text" class="form-control" name="MOMO_CURRENCY" value="{{ env('MOMO_CURRENCY') }}" placeholder="Momo Currency" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_PARTY_ID">
                            <label class="form-label">{{__('Momo Party Type')}}</label>
                            <input type="text" class="form-control" name="MOMO_PARTY_ID" value="{{ env('MOMO_PARTY_ID') }}" placeholder="Momo Party Type" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_COLLECTION_SUBSCRIPTION_KEY">
                            <label class="form-label">{{__('Momo Collection Subscription Key')}}</label>
                            <input type="text" class="form-control" name="MOMO_COLLECTION_SUBSCRIPTION_KEY" value="{{ env('MOMO_COLLECTION_SUBSCRIPTION_KEY') }}" placeholder="Momo Collection Subscription Key" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{__('Momo Webhook Url')}}</label>
                            <input type="text" class="form-control" value="{{route('momo.success')}}" readonly>
                        </div>
                        {{-- <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_COLLECTION_ID">
                            <label class="form-label">{{__('Momo Collection ID')}}</label>
                            <input type="text" class="form-control" name="MOMO_COLLECTION_ID" value="{{ env('MOMO_COLLECTION_ID') }}" placeholder="Momo Collection ID" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_PRODUCT">
                            <label class="form-label">{{__('Momo Product')}}</label>
                            <input type="text" class="form-control" name="MOMO_PRODUCT" value="{{ env('MOMO_PRODUCT') }}" placeholder="Momo Product" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_COLLECTION_CALLBACK_URI">
                            <label class="form-label">{{__('Momo Collection Callback URI')}}</label>
                            <input type="text" class="form-control" name="MOMO_COLLECTION_CALLBACK_URI" value="{{ env('MOMO_COLLECTION_CALLBACK_URI') }}" placeholder="Momo Collection Callback URI" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="MOMO_COLLECTION_SECRET">
                            <label class="form-label">{{__('Momo Collection Secret')}}</label>
                            <input type="text" class="form-control" name="MOMO_COLLECTION_SECRET" value="{{ env('MOMO_COLLECTION_SECRET') }}" placeholder="Momo Collection Secret" required>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary btn-block" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    .btn-block{
        width: 100%
    }
    .card-header{
        border-top: 3px solid #111111;
    }
    .primage {
        max-height: 100px !important;
        width: auto !important;
        margin: 10px;
    }
</style>
@endsection
@section('scripts')

<script>
    function updateSystem(el, name){
        if($(el).is(':checked')){
            var value = 1;
        }
        else{
            var value = 0;
        }
        $.post('{{ route('admin.setting.sys_settings') }}', {_token:'{{ csrf_token() }}', name:name, value:value}, function(data){
            if(data == '1'){
                Snackbar.show({
                    text: '{{__('Settings Updated Successfully')}}',
                    pos: 'top-right',
                    backgroundColor: '#38c172'
                });
            }
            else{
                Snackbar.show({
                    text: '{{__('Something went wrong')}}',
                    pos: 'top-right',
                    backgroundColor: '#e3342f'
                });
            }
        });
    }
</script>
@endsection
