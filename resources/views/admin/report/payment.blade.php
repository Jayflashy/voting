@extends('admin.layouts.master')
@section('title') @lang('Payment History') @endsection

@section('content')
<div class="card">
    <h4 class="fw-bold card-header">@lang('Payment History')</h4>
    <div class="card-body">
        <table class="table table-hover table-bordered" id="datatables" width="100%">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Contestant Name</th>
                <th>Payment Code</th>
                <th>Country</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Amount</th>
                <th>Votes</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($payments  as $key => $item)
                <tr>
                    <td>{{$key +1 }}</td>
                    <td> {{$item->contestant->name }} </td>
                    <td> {{$item->code}}</td>
                    <td> {{$item->country}}</td>
                    <td> {{$item->email}}</td>
                    <td> {{$item->phone}}</td>
                    <td> {{format_price($item->amount)}}</td>
                    <td> {{$item->votes}}</td>
                    <td> {{$item->payment_method}}</td>
                    <td>{{show_datetime($item->created_at)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{$payments->links()}}
        </div>
    </div>
</div>

@endsection
