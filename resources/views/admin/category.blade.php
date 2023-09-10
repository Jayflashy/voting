@extends('admin.layouts.master')

@section('title')
    @lang('Contest Categories')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="my-auto"> @lang('Contest Categories')</h4>
        <a href="#" data-bs-toggle="modal" data-bs-target="#CreateCategory" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('Create Category')</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Contestants')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{!! get_status($item->status) !!}</td>
                    <td>
                        <span class="me-3"> {{$item->contestants->count()}} </span> <a href="{{route('admin.categories.contestant', $item->slug)}}" class="btn btn-secondary btn-sm text-end">@lang('View')</a>
                    </td>
                    <td>
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#TrackEdit{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="{{route('admin.categories.delete', $item->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="TrackEdit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="myModalLabel"> @lang('Edit') {{$item->name}}</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                            </div>
                            <div class="modal-body">
                            <form action="{{route('admin.categories.edit', $item->id)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">@lang('Name')</label>
                                    <input type="text" class="form-control" value="{{$item->name}}" required placeholder="Category Name" name="name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" @if($item->status == 1) selected @endif>@lang('Enabled')</option>
                                        <option value="2" @if($item->status == 2) selected @endif>@lang('Disabled')</option>
                                    </select>
                                </div>
                                <button class="btn btn-success mt-2 w-100" type="submit">@lang('Edit')</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <span class="mt-2">
            {{$data->links()}}
        </span>
    </div>
</div>

<div class="modal fade" id="CreateCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="myModalLabel"> @lang('Create Category')</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
          </div>
          <div class="modal-body">
            <form action="{{route('admin.categories.create')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Name')</label>
                    <input type="text" class="form-control" required placeholder="@lang('Category') @lang('Name')" name="name">
                </div>
                <button class="btn btn-success mt-2 w-100" type="submit">@lang('Create Category')</button>
            </form>
          </div>
      </div>
    </div>
</div>
@endsection
