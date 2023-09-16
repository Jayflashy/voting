<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{get_setting('title')}} </title>
    {{-- Meta tags --}}
    <meta name="title" content="@yield('title') - {{get_setting('title')}}">
    <meta name="description" content="{{get_setting('description')}}" />
    @yield('meta')
    <!-- Styles -->
    <link href="{{ static_asset('css/vendors.css') }}" rel="stylesheet">
    <link href="{{ static_asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{my_asset(get_setting('favicon'))}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <!--Chart.js JS CDN-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    @yield('styles')
    @stack('css')

</head>
<body>
    {{-- Header --}}
    @include('layouts.header')
    <div class="page-wrap">
        @yield('banner')
        <div class="page-content">
            <div class="container">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="bt-footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-center text-sm-left d-block d-sm-inline-block"> @lang('Copyright') &copy; {{ date('Y') }} - {{get_setting('title')}}.</span>
                </div>
            </div>

        </footer>
    </div>
    <div class="modal fade" id="vote_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <script src="{{ static_asset('js/vendors.js') }}"></script>
    <script src="{{ static_asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ static_asset('js/core.js') }}"></script>
    <script src="{{static_asset('js/sweetalert.min.js')}}"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
    <!-- Load the required Braintree components. -->
    <script src="https://js.braintreegateway.com/web/3.39.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.39.0/js/paypal-checkout.min.js"></script>

    @yield('scripts')
    @stack('scripts2')
    <script type="text/javascript">
        @if(Session::get('success'))
        Snackbar.show({
            text: '{{Session::get('success')}}',
            pos: 'top-right',
            backgroundColor: '#38c172'
        });
        swal("Successful!", '{{Session::get('success')}}', "success")
        .then((willDelete) => {
            if (willDelete) {
            }
        });
        @endif
        @if(Session::get('vsuccess'))
        swal("Voting Successful!", '{{Session::get('vsuccess')}}', "success")
        .then((willDelete) => {
            if (willDelete) {
            }
        });
        @endif
        @if(Session::get('error'))
        swal("Error!", '{{Session::get('error')}}', "warning")
        .then((willDelete) => {
            if (willDelete) {
            }
        });
        Snackbar.show({
            text: '{{Session::get('error')}}',
            pos: 'top-right',
            backgroundColor: '#e3342f'
        });
        @endif
    </script>
    <script>
        function show_vote_modal(id){

            $.post('{{ route('vote.modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#vote_modal #modal-content').html(data);
                $('#vote_modal').modal('show', {backdrop: 'static'});
            });

        }
        function copyLink(elementId) {
            // Create a "hidden" input
            var aux = document.createElement("input");
            // Assign it the value of the specified element
            aux.setAttribute("value", document.getElementById(elementId).innerHTML);
            // Append it to the body
            document.body.appendChild(aux);
            // Highlight its content
            aux.select();
            // Copy the highlighted text
            document.execCommand("copy");
            // Remove it from the body
            document.body.removeChild(aux);
            alert('Link Copied Successfully')

        }
    </script>
</body>
</html>
