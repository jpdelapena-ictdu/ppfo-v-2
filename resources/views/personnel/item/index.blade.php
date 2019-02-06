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
        Items<small>All items in the {{ $building->name }}.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('item.personnel.index') }}">Items</a></li>
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
            <a href="{{ route('item.personnel.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive nowrap" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Description</th>
                <th>Type</th>
                <th>Category</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->room }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->category }}</td>
                <td><a href="#" class="btn btn-default btn-xs" id="viewItem" data-toggle="modal" data-target="#messageModal{{$row->id}}"><i class="fa fa-eye"></i> View</a> <a href="{{ route('item.personnel.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> <button type="submit" class="btn btn-xs btn-default" form="deleteItem{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
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
  
  @foreach($items as $row)
  <!-- Modal -->
  <div class="modal fade" id="messageModal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">View Item</h4>
        </div>
        <div class="modal-body">
          {{-- modal content --}}
          <label>Room</label>
          <p id="vroom">{{ $row->room }}</p>

          <label>Description</label>
          <p id="vdescription">{{ $row->description }}</p>

          <label>Type</label>
          <p id="vtype">{{ $row->type }}</p>

          <label>Category</label>
          <p id="vcategory">{{ $row->category }}</p>

          <label>Quantity</label>
          <p id="vquantity">{{ $row->quantity }}</p>
          
          <hr style="border: 1px solid #3c8dbc;">
          <div class="row" >
            <div class="col-xs-4">
              <label>Working</label>
              <p id="vworking">{{ $row->working }}</p>
            </div>

            <div class="col-xs-4">
              <label>Not Working</label>
              <p id="vnot_working">{{ $row->not_working }}</p>
            </div>
            
            <div class="col-xs-4">
              <label>For Repair</label>
              <p id="vfor_repair">{{ $row->for_repair }}</p>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach

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

