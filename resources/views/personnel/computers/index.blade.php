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
        Computers<small>All Computers in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('item.index') }}">Computers</a></li>
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
            <a href="{{ route('personnel.computer.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Computer</a> <a href="{{ route('download.item') }}" class="btn btn-primary"><i class="fa fa-download"></i> Download Report</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-bordered table-hover display responsive nowrap" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Room</th>
                <th>PC Number</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($computers as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->room }}</td>
                <td>{{ $row->pc_number }}</td>
                @if($row->status == 0)
                <td>Working</td>
                @elseif($row->status == 1)
                <td>Not Working</td>
                @elseif($row->status == 2)
                <td>For Repair</td>
                @elseif($row->status == 3)
                <td>For Calibrate</td>
                @endif
                <td>

                  <a href="#" class="btn btn-default btn-xs" id="viewItem" data-toggle="modal" data-target="#messageModal{{$row->id}}"><i class="fa fa-eye"></i> View</a> 
                  <a href="{{ route('personnel.computer.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                  <a href="{{ route('component.create', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Add Computer Parts</a> 
                  <button type="submit" class="btn btn-xs btn-default" form="deleteItem{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                    <form id="deleteItem{{$row->id}}" method="POST" action="{{ route('personnel.computer.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
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
  
  @foreach($computers as $row)
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
          <p id="vbuilding">{{ $row->room }}</p>

          <label>PC Number</label>
          <p id="vroom">{{ $row->pc_number }}</p>

          <label>Description</label>
          @if($row->status == 0)
          <p id="vstatus">Working</p>
          @elseif($row->status == 1)
          <p id="vstatus">Not Working</p>
          @elseif($row->status == 2)
          <p id="vstatus">For Repair</p>
          @elseif($row->status == 3)
          <p id="vstatus">For Calibrate</p>
          @endif
          <hr>
          <label>Components</label>
          <br>
          @foreach($parts as $row1)
            @if($row1->pc_id == $row->id)
              @if($row1->category == 1)
                <label>{{ $row1->type }}</label>
                <p id="vpartstype">Brand: {{ $row1->brand }}</p>
                <p id="vpartstype">Description: {{ $row1->description }}</p>
              @endif
            @endif
          @endforeach
          <hr>
          <label>Parts</label>
          <br>
          @foreach($parts as $row1)
            @if($row1->pc_id == $row->id)
              @if($row1->category == 0)
                <label>{{ $row1->type }}</label>
                <p id="vpartstype">Brand: {{ $row1->brand }}</p>
                <p id="vpartstype">Description: {{ $row1->description }}</p>
              @endif
            @endif
          @endforeach
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

