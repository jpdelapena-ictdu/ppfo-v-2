@extends('backpack::layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/admindashboard.css') }}">
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

@endsection

@section('header')
    <section class="content-header">
      <h1>
        Rooms<small>All rooms in the {{ $building->name }}.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('room.personnel.index') }}">Rooms</a></li>
        <li class="active">List</li>
      </ol>
    </section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border">
        	<h3 style="display: inline;"><i class="fa fa-building"></i> {{ $building->name }}</h3> <a style="display: inline;" href="{{ route('room.personnel.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Room</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive nowrap" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Short Name</th>
                <th>In Charge</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->short_name }}</td>
                <td>{{ $row->in_charge }}</td>
                <td><a href="{{ route('room.personnel.download.item', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-download"></i> Download Report</a> <a href="{{ route('room.personnel.create.item', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Add Item</a> <a href="{{ route('room.personnel.show', $row->id) }}" class="btn btn-default btn-xs" id="viewRoom"><i class="fa fa-eye"></i> View Items</a> <a href="{{ route('room.personnel.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> @if(!in_array($row->id, $roomsCantBeDelete)) <button type="submit" class="btn btn-xs btn-default" form="deleteRoom{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                    <form id="deleteRoom{{$row->id}}" method="POST" action="{{ route('room.personnel.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                            {{ method_field('DELETE') }}
                          </form> @endif </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div>

  </div>

@endsection

@section('after_scripts')

  <!-- DATA TABLES SCRIPT -->
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>

  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

  <script>
    // datatable init
    $(document).ready( function () {
        $('#crudTable').DataTable({
          "order": [[ 0, "desc" ]],
          "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false,
                  "searchable": false
              }
          ]
        });
    } );

    // confirm delete
    function ConfirmDelete()
    {
    var x = confirm("Are you sure you want to delete this item?");
    if (x)
      return true;
    else
      return false;
    }
  </script>

@endsection