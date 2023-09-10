@extends('admin.layouts.master')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card text-center">
            <div class="card-body p-t-10">
                <h4 class="card-title text-muted mb-0">Total Contestants</h4>
                <h4 class="mt-3 mb-2"><b>{{App\Models\Contestant::where('status', 1)->count()}} </b></h4>
                <p class="text-muted mb-0 mt-3"></p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-center">
            <div class="card-body p-t-10">
                <h4 class="card-title text-muted mb-0">Total Category</h4>
                <h4 class="mt-3 mb-2"><b>{{App\Models\Category::where('status', 1)->count()}}</b></h4>
                <p class="text-muted mb-0 mt-3"></p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card text-center">
            <div class="card-body p-t-10">
                <h4 class="card-title text-muted mb-0">Total Payments</h4>
                <h4 class="mt-3 mb-2"><b>{{format_price(App\Models\Payment::where('status', 1)->sum('amount'))}}</b></h4>
                <p class="text-muted mb-0 mt-3"></p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="my-auto">@lang('Top Contestants')</h4>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Votes</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <img src="{{my_asset($item->image)}}" class="table-image" alt="">
                    </td>
                    <td><a href="{{route('category', $item->category->slug)}}"> {{$item->category->name ?? "None"}} </a> </td>
                    <td>{{$item->votes}}</td>
                    <td>{!! get_status($item->status) !!}</td>
                    <td>
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#UpdateService{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="{{route('admin.contestant.delete', $item->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                {{-- Update Modal --}}
                <div class="modal fade" id="UpdateService{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myModalLabel"> @lang('Update') @lang('Contestant')</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <form class="" action="{{route('admin.contestant.update', $item->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form-label">@lang('Name')</label>
                                        <input type="text" class="form-control" value="{{$item->name}}" required placeholder="Name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Image')</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">@lang('Select') @lang('Category')</label>
                                        <select required name="category_id" class="form-select">
                                            @foreach ($category as $items)
                                                <option value="{{$items->id}}" @if($items->id == $item->category_id) selected @endif>{{$items->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">@lang('Votes') </label>
                                        <input type="text" class="form-control" value="{{$item->votes}}" required placeholder="Votes" name="votes">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label">@lang('Status')</label>
                                        <select name="status" class="form-select">
                                            <option value="1" @if($item->status == 1) selected @endif>@lang('Enabled')</option>
                                            <option value="2" @if($item->status == 2) selected @endif>@lang('Disabled')</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-success mt-2 w-100" type="submit">@lang('Edit Contestant')</button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{$data->links()}}
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .table-image{width:50px;}
</style>

@endsection
