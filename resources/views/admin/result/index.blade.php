@extends('admin.layouts.master')
@section('title')Voting Results @endsection

@section('content')
<div class="page-title">
    <h5 class="mb-0">Voting Results</h5>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover table-bordered" id="datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CONTEST NAME</th>
                    <th>PRICE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contests as $item)
                <tr>
                    <th>{{$item->id}}</th>
                    <td>
                        <a href="{{ url('category/'.$item->slug ) }}" style="color:blue" data-bs-toggle="tooltip" data-placement="bottom" title="View">
                            {{ Str::limit($item->name, 100) }}
                        </a>
                    </td>
                    <td> {{format_price(get_setting('price'))}}</td>
                    <td>{!!get_status($item->status)!!}</td>
                    <td>
                        <a href="{{route('admin.viewresult', $item->id)}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Result">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
