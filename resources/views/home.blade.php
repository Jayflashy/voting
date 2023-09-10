@extends('layouts.master')
@section('title') @lang('All Contests') @endsection
@section('content')
@forelse ($categories as $category)
    @include('sub-category')
@empty
<div class="row">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="fw-bold py-4">No Contestants Found</h5>
        </div>
    </div>
</div>

@endforelse
@endsection
@section('scripts')
@endsection
{{-- @section('scripts2')

@endsection --}}
