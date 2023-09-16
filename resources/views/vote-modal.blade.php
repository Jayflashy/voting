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
        <form action="{{route('vote')}}" enctype="multipart/form-data" id="paymentForm" method="post">
            @csrf
            <div class="row">
                <div class="form-group col-sm-6">
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
                        <input class="form-control" name="quantity" type="number" id="quantity" value="1" data-price="{{get_setting('price')}}" data-price2="{{get_setting('price2')}}" onkeyup="CalculateItemsValue()" />
                    </div>
                </div>
                <div class="form-group col-6">
                    <label class="form-label ">{{__('Total Price')}}  {{get_setting('currency')}}</label>
                    <div class="7">
                        <span class="form-control"> {{get_setting('currency')}} <span id="ItemsTotal">{{get_setting('price')}}</span> </span>
                    </div>
                </div>
                <div class="form-group col-6">
                    <label class="form-label ">{{__('Total Price')}}  {{get_setting('currency2')}}</label>
                    <div class="7">
                        <span class="form-control"> {{get_setting('currency2')}} <span id="ItemsTotal2">{{get_setting('price2')}}</span> </span>
                    </div>
                </div>
            </div>

            <input type="hidden" name="reference" id="trx_ref" value="{{getTrx(14)}}">
            <input type="text" hidden name="amount" id="amount" value="{{get_setting('price')}}">
            <input type="hidden" name="contestant_id" value="{{$contestant->id}}">
            <input type="hidden" name="desc" value="Payment for {{$contestant->name}}">
            <div class="form-group my-2">
                <label for="gateway" class="form-label">{{__('Select Payment Option')}}</label>
                <div class="row mx-auto">
                    @if (sys_setting('flutterwave_payment') == 1)
                    <div class="col-6 col-sm-3">
                        <label class="mb-2 pay-option" data-toggle="tooltip" data-title="FLutterwave" title="Card and Mobile Money" id="start-payment-button" onclick="makePayment()">
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
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Stripe" onclick="stripePayment()">
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
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Paypal Payment" onclick="paypalPayment()">
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
                        <label class="mb-2 pay-option" data-toggle="tooltip" title="Momo Payment" onclick="momoPayment()">
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

            {{-- <button class=" mt-2 w-100 btn joinButton text-white">Continue</button> --}}
        </form>
        {{-- Stripe Payment form --}}
        <div class="card-body" id="stripeForm">
            @if (session('success'))
            <div
                style="color: green;
                    border: 2px green solid;
                    text-align: center;
                    padding: 5px;margin-bottom: 10px;">
                Payment Successful!
            </div>
            @endif
            <form id='checkout-form' method='post' action="{{route('stripe.payment')}}">
                @csrf
                <input type='hidden' name='stripeToken' id='stripe-token-id'>
                <input type="hidden" name="details" id="stripeDetails" value="">
                <label for="card-element" class="fw-bold mb-2">Pay with Stripe</label>
                <br>
                <div id="card-element" class="form-control" ></div>
                <button
                    id='pay-btn'
                    class="btn btn-success mt-3"
                    type="button"
                    style="margin-top: 20px; width: 100%;padding: 7px;"
                    onclick="createToken()">PAY {{get_setting('currency2')}} <span id="stripeTotal">{{get_setting('price2')}}</span>
                </button>
            <form>
        </div>
        <div class="card-body" id="paypalForm">
            <div id="btn-paypal-checkout"></div>
        </div>
    </div>
</div>
<div class="hidden">
    <input type="text" hidden id="flutter_url" value="{{route('flutter.success')}}">
    <input type="text" hidden id="public_key" value="{{env('FLW_PUBLIC_KEY')}}">
    <input type="text" hidden id="currency" value="{{get_setting('currency_code')}}">
</div>

{{-- @push('css') --}}
<style>
    #stripeForm{
        display: none;
    }
    #paypalForm{
        display: none;
    }
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
        var total2 = 0;
        for (i = 1; i <= total_items; i++) {
            itemID = document.getElementById("quantity" );
            if (typeof itemID === 'undefined' || itemID === null) {
                alert("No such item - " + "qnt_" + i);
            } else {
                var price = parseFloat(itemID.getAttribute("data-price"));
                var price2 = parseFloat(itemID.getAttribute("data-price2"));
                total += parseInt(itemID.value) * price;
                total2 += parseInt(itemID.value) * price2;
            }
        }

        var totalFormatted = total.toFixed(2); // Round to 2 decimal places
        var totalFormatted2 = total2.toFixed(2); // Round to 2 decimal places
        document.getElementById("ItemsTotal").innerHTML = totalFormatted;
        document.getElementById("amount").innerHTML = totalFormatted;
        document.getElementById("ItemsTotal2").innerHTML = totalFormatted2;
        document.getElementById("stripeTotal").innerHTML = totalFormatted2;
    }

    // get form fields
    function getFormFields() {
        // Get the form element by its ID
        var form = document.getElementById("paymentForm");
        // Create an object to store form fields and their values
        var formData = {};
        // Iterate through the form elements
        for (var i = 0; i < form.elements.length; i++) {
            var element = form.elements[i];
            if (element.name) {
                // Check if the element has a name attribute
                formData[element.name] = element.value;
            }
        }
        return formData;
    }

    function makePayment() {
        //Hide stripe form and other forms
        document.getElementById('stripeForm').style.display = 'none';
        document.getElementById('paypalForm').style.display = 'none';

        const country = document.getElementById('countrySelect').value;
        const email = document.getElementById('Email').value;
        const phone = document.getElementById('phone').value;
        const quantity = document.getElementById('quantity').value;

        const price = parseFloat(document.getElementById('quantity').getAttribute('data-price'));
        const totalAmount = price * parseFloat(quantity);
        const formFields = getFormFields();
        // show alert if name and email empty
        if(email == "" || phone == ""){
            Snackbar.show({
                text: 'Please fill all details',
                backgroundColor: '#e3342f'
            });
            return;
        }

        const checkoutData = {
            public_key: document.getElementById('public_key').value, // Replace with your actual public key
            tx_ref: document.getElementById('trx_ref').value, // Assuming get_trx(18) returns a valid transaction reference
            payment_options: "card, banktransfer, ussd,mobilemoneyghana,mobilemoneyfranco,mobilemoneyuganda,mobilemoneyrwanda,mobilemoneyzambia,barter,credit",
            amount: totalAmount, // Assuming totalAmount is defined somewhere in your code
            currency: document.getElementById('currency').value, // Assuming get_setting('currency_code') returns the currency code
            redirect_url: document.getElementById('flutter_url').value, // Replace with the actual redirect URL
            meta: formFields,
            customer: {
                email: email, // Include the email from the form
                phone_number: phone, // Include the phone number from the form
                name: "Customer Name", // Replace with the actual customer name if available
            },
        };

        FlutterwaveCheckout(checkoutData);
    }

    function paypalPayment(){
        document.getElementById('stripeForm').style.display = 'none';

        const email = document.getElementById('Email').value;
        const phone = document.getElementById('phone').value;
        const quantity = document.getElementById('quantity').value;
        const price = parseFloat(document.getElementById('quantity').getAttribute('data-price2'));
        const totalAmount = price * parseFloat(quantity);
        const formFields = getFormFields();
        // show alert if name and email empty
        if(email == "" || phone == ""){
            Snackbar.show({
                text: 'Please fill all details',
                pos: 'top-right',
                backgroundColor: '#e3342f'
            });
            return;
        }

        var form = document.getElementById("paymentForm");

        form.submit();

    }
    function momoPayment(){
        document.getElementById('stripeForm').style.display = 'none';
        const email = document.getElementById('Email').value;
        const phone = document.getElementById('phone').value;
        // show alert if name and email empty
        if(email == "" || phone == ""){
            Snackbar.show({
                text: 'Please fill all details',
                pos: 'top-right',
                backgroundColor: '#e3342f'
            });
            return;
        }
        var form = document.getElementById("paymentForm");

        form.submit();
    }
    function stripePayment(){

        document.getElementById('paypalForm').style.display = 'none';
        // show stripe form
        const country = document.getElementById('countrySelect').value;
        const email = document.getElementById('Email').value;
        const phone = document.getElementById('phone').value;
        const quantity = document.getElementById('quantity').value;
        const price = parseFloat(document.getElementById('quantity').getAttribute('data-price'));
        const totalAmount = price * parseFloat(quantity);
        const formFields = getFormFields();
        // show alert if name and email empty
        if(email == "" || phone == ""){
            Snackbar.show({
                text: 'Please fill all details',
                backgroundColor: '#e3342f'
            });
            return;
        }

        document.getElementById('stripeForm').style.display = 'block';
        //add formfields to form
        document.getElementById('stripeDetails').value = JSON.stringify(formFields);

    }

    var stripe = Stripe('{{ env('STRIPE_KEY') }}')
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {


            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }

            // creating token success
            if(typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }

</script>
