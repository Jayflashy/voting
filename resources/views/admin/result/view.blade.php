@extends('admin.layouts.master')
@section('title')Voting Results @endsection

@section('content')
<div class="card">
    <h4 class="card-header fw-bold">Voting Results for {{$contest->name}} Category</h4>
    <div class="card-body">
        <div class="contest-content">
            <h5>All Contestants</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CONTESTANT NAME</th>
                            <th>TOTAL VOTES</th>
                            <th>STATUS</th>
                            <th>RESULT</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($contestants as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->votes}}</td>
                            <td>{!!get_status($item->status)!!}</td>
                            <td>{{result_percentage($item->id)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- pdfmake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<!-- pdfmake VFS (Virtual File System) Fonts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- DataTables Buttons HTML5 Export -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
    } );
</script>

@endsection

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables Buttons Extension CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection
