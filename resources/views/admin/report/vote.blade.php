@extends('admin.layouts.master')
@section('title') @lang('Free Vote History') @endsection

@section('content')
<div class="card">
    <h4 class="card-header fw-bold">@lang('Voting History')</h4>
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered" id="datatables" width="100%">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Contestant Name</th>
                <th>Payment Code</th>
                <th>Country</th>
                <th>Email</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($payments  as $key => $item)
                <tr>
                    <td>{{$key +1 }}</td>
                    <td> {{$item->contestant->name }} </td>
                    <td> {{$item->reference}}</td>
                    <td> {{$item->country}}</td>
                    <td> {{$item->email}}</td>
                    <td> {{$item->name}}</td>
                    <td> {{$item->phone}}</td>
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
