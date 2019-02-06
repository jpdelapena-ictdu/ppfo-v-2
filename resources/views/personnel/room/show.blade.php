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
        {{$room->name}}<small>All items in the room.</small>
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
          <a href="{{ route('room.personnel.create.item', $room->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item in {{ $room->name }}</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive nowrap" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Type</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Working</th>
                <th>Not Working</th>
                <th>For Repair</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->category }}</td>
                <td>{{ $row->quantity }}</td>
                <td>{{ $row->working }}</td>
                <td>{{ $row->not_working }}</td>
                <td>{{ $row->for_repair }}</td>
                <td><a href="{{ route('item.personnel.edit', $row->id) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a> <button type="submit" class="btn btn-xs btn-default" form="deleteItem{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                    <form id="deleteItem{{$row->id}}" method="POST" action="{{ route('item.personnel.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                            {{ method_field('DELETE') }}
                          </form></td>
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

