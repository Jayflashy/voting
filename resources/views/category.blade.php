@extends('layouts.master')
@section('title') {{$category->name}} @endsection

@section('content')

@php $results = array(); $counts = array();@endphp
<div class="row contest">
    <div class="col-md-12">
        <div class="category ">
            <div class="category-header d-flex bg-primary justify-content-between">
                <h2 class="title_cat mt-auto">{{$category->name}}</h2>
            </div>
            <div class="contestant">
                <div class="row col-12 mx-auto">
                    @foreach ($category->contestants as $item)
                    <div class="col-3 ">
                        <div class="contestant">
                            <div onclick="show_vote_modal('{{$item->id}}');"  class="contestant-item modal-action">
                                <div id="number-count" class="number-count number-count-{{$loop->iteration}} text-center">
                                    {{$loop->iteration}}
                                </div>
                                <div class="mb-2 mb-sm-2 mb-lg-3 contestant-image mx-auto">
                                    <img src="{{my_asset($item->image)}}" />
                                </div>
                                <div class="text-center name-div">
                                    <span class="name fw-bold">{{$item->name}} </span>
                                </div>
                            </div>
                            <a id="btn-vote w-100" onclick="show_vote_modal('{{$item->id}}');"  class="vote-btn btn joinButton"><i class="fa fa-thumbs-up"></i> @lang('Vote')
                            </a>
                        </div>
                    </div>

                    @php
                    $counts[] = $loop->iteration . "(".result_percentage($item->id).")";
                    $results[] = $item->votes; @endphp
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="brd-bb">
            <div class="voting-results">
                <div class="col-md-12">
                    <div class="sharing-zone">
                        <h3>Share via</h3>
                        <div class="share">

                            <a type="button" class="btn facebook" href="https://www.facebook.com/sharer.php?u={{url('/c/'.$category->slug)}}&t={{$category->name }}" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a type="button" class="btn twitter" href="https://twitter.com/intent/tweet?text={{$category->name}}&url={{url('/c/'.$category->slug)}}"  target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="whatsapp://send?text= {{$category->name}} - {{url('/c/'.$category->slug)}}" type="button" class="btn whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a type="button" title="Copy to Clipboard" class="btn btn-secondary"  onclick="copyLink('con{{$category->id}}')" >
                                <p class="d-none" id="con{{$category->id}}">{{$category->name}} {{url('/c/'.$category->slug)}}</p>
                                <i class="fa fa-clipboard"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-10" style="margin: 10px 0px;">
                    <input type="text" readonly="readonly" class="form-control" style="width: 100%; font-size: 13px;" value="{{url('/c/'.$category->slug)}}"/>
                </div>
                {{-- Bae zchats --}}
                <div class="p-2 d-flex justify-content-center w-sm-100 w-md-75">
                    <div class="" style="position: relative; width: 100%; height: auto;">
                        <canvas id="barChart{{$category->id}}" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-block p-2 border border-gray-500 mt-4">
        <img src="{{my_asset(get_setting('sponsor'))}}" alt="" class="" style="width: 100%;">
    </div>
</div>
@endsection
@push('scripts2')
<script>
    var chartID = 'barChart{{$category->id}}';
    var votesArray = @json($results);
    var countArray = @json($counts);
    var ctx = document.getElementById(chartID).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels:  countArray ,
        datasets: [
            {
            label: "{{__('Total Votes')}}",
            backgroundColor: ["blue", "green","purple","orange","red","yellow"],
            data: votesArray
            }
        ]
        },
        options: {
            legend: { display: false },

        }
    });
</script>
@endpush

@section('banner')
<section data-v-9c3df010="" class="p-0 text-center rounded-0 custom-top-section">
    <div data-v-9c3df010="" class="w-100 p-md-5 px-0 relative">
        <div data-v-9c3df010="" class="container pt-5 pt-md-3 pb-5 pb-md-0">
            <h1 data-v-9c3df010="" class="text-white pb-2 font-weight-bold text-sm">
               LIST OF CANDIDATE FOR
            </h1>
            <div data-v-9c3df010="" class="breadcrumbs">
                <h3 data-v-9c3df010="" class="text-white font-weight-bold text-white text-xxl">
                   @yield('title')
                </h3>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<style>
    .custom-top-section {
        background-attachment: fixed;
        background-image: url({{my_asset(get_setting('banner'))}});
        background-position-y: -475px;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
    .custom-top-section > div {
        position: relative;
    }
    .custom-top-section:before {
        background: #015191;
        content: "";
        height: 100%;
        left: 0;
        opacity: 0.4;
        position: absolute;
        top: 0;
        width: 100%;
    }
</style>

@endsection
