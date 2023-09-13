<div class="modal-header">
    <div class="text-center mx-auto">
        <h5 class="modal-title" id="myModalLabel">@lang('I vote For') : </h5>
        <h5 class="greenColor fw-bold"> {{$contestant->name}}</h5>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <div class="mb-2 mb-sm-2 mb-lg-3 contestant-image mx-auto">
                <img src="{{my_asset($contestant->image)}}" />
            </div>
        </div>
        {{-- zVoting Form --}}
        <form action="{{route('vote')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="form-group col-12">
                    <label for="country" class="form-label">Select Country</label>
                    <select class="form-control form-select" id="countrySelect" required name="country">
                        @include('country')
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label" for="Email">{{__('Your Email')}}</label>
                    <div class="">
                        <input type="email" class="form-control" required name="email" id="Email" placeholder="{{__('Your Email')}}">
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label" for="phone">{{__('Your Phone Number')}}</label>
                    <div class="">
                        <input type="tel" class="form-control" required name="phone" id="phone" placeholder="{{__('Your Phone Number')}}">
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">{{__('Select Votes')}}</label>
                    <div class="">
                        <input class="form-control" name="quantity" type="number" id="quantity" value="1" data-price="{{get_setting('price')}}" onkeyup="CalculateItemsValue()" />
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label ">{{__('Total Price')}}</label>
                    <div class="7">
                        <span class="form-control"> {{get_setting('currency')}}<span id="ItemsTotal">{{get_setting('price')}}</span> </span>
                    </div>
                </div>
            </div>

            <input type="hidden" name="contestant_id" value="{{$contestant->id}}">
            <div class="form-group my-2">
                <label for="gateway" class="form-label">{{__('Select Payment Option')}}</label>
                <div class="row mx-auto">
                    @if (sys_setting('flutterwave_payment') == 1)
                    <div class="col-6 col-sm-3">
                        <label class="mb-2 pay-option" data-toggle="tooltip" data-title="FLutterwave" title="Card and Mobile Money">
                            <input type="radio" id="" name="payment_type" value="flutterwave">
                            <span>
                                <img class="pay-method" src="{{static_asset('img/flutter.png')}}" >
                                <span class="small">{{__('Card and Mobile Money')}}</span>
                            </span>
                        </label>
                    </div>
                    @endif
                    @if (sys_setting('stripe_payment') == 1)
                    <div class="col-6 col-sm-3">
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Stripe">
                            <input type="radio" id="" name="payment_type" value="stripe">
                            <span>
                                <img class="pay-method" src="{{static_asset('img/stripe.png')}}" >
                                <span class="small">{{__('Card Payment')}}</span>
                            </span>
                        </label>
                    </div>
                    @endif
                    @if (sys_setting('paypal_payment') == 1)
                    <div class="col-6 col-sm-3">
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Paypal Payment">
                            <input type="radio" id="" name="payment_type" value="paypal">
                            <span>
                                <img class="pay-method" src="{{static_asset('img/paypal.png')}}" >
                                <span class="small">{{__('Paypal Payment')}}</span>
                            </span>
                        </label>
                    </div>
                    @endif
                    @if (sys_setting('momo_payment') == 1)
                    <div class="col-6 col-sm-3">
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Momo Payment">
                            <input type="radio" id="" name="payment_type" value="momo">
                            <span>
                                <img class="pay-method" src="{{static_asset('img/momo.png')}}" >
                                <span class="small">{{__('Mobile Money')}}</span>
                            </span>
                        </label>
                    </div>
                    @endif
                </div>
            </div>

            <button class=" mt-2 w-100 btn joinButton text-white">Continue</button>
        </form>
    </div>
</div>

{{-- @push('css') --}}
<style>
    .form-label{
        font-weight: bold;
    }
    .pay-option {
        position: relative;
        cursor: pointer;
    }

    label.pay-option input {
        opacity: 0;
        /*position: fixed;*/
    }

    label.pay-option {
        position: relative;
        cursor: pointer;
    }

    label.pay-option span {
        display: inline-block;
        border-radius: 9px;
        background: #f6f6f6;
        position: relative;
    }

    .pay-method {
        display: block;
        width: 100%;
    }

    label.pay-option input:checked+span:before {
        position: absolute;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, 0.8);
        content: "";
        top: 0;
        left: 0;
    }

    label.pay-option input:checked+span:after {
        position: absolute;
        content: "";
        left: calc(50% - 6px);
        top: calc(50% - 12px);
        width: 12px;
        height: 24px;
        border: solid #28a745;
        border-width: 0 4px 4px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        box-shadow: 2px 3px 5px rgb(94, 146, 106);
    }
</style>
{{-- @endpush --}}
<script language="javascript">
    var total_items = 1;

    function CalculateItemsValue() {
        var total = 0;
        for (i = 1; i <= total_items; i++) {
            itemID = document.getElementById("quantity" );
            if (typeof itemID === 'undefined' || itemID === null) {
                alert("No such item - " + "qnt_" + i);
            } else {
                var price = parseFloat(itemID.getAttribute("data-price"));
                total += parseInt(itemID.value) * price;
            }
        }

        var totalFormatted = total.toFixed(2); // Round to 2 decimal places
        document.getElementById("ItemsTotal").innerHTML = totalFormatted;
        document.getElementById("PayTotal").innerHTML = totalFormatted;
    }

</script>
