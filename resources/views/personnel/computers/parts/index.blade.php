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
    Parts<small>All parts in the database.</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ backpack_url() }}">Personnel</a></li>
    <li><a href="{{ route('personnel.component.index') }}">Parts</a></li>
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
        <a href="{{ route('excess.personnel.component.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Excess Parts</a> <a href="{{ route('download.item') }}" class="btn btn-primary"><i class="fa fa-download"></i> Download Report</a>
      </div>

      <div class="box-body overflow-hidden">

        <table id="crudTable" class="table table-striped table-bordered table-hover display responsive nowrap" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Room</th>
              <th>PC #</th>
              <th>Category</th>
              <th>Type</th>
              <th>Brand</th>
              <th>Description</th>
              <th>Serial</th>
              <th>Date Purchased</th>
              <th>Amount</th>
              <th>Date Issued</th>
              <th>Remarks</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($parts as $row)
            <tr>
              <td>{{ $row->id }}</td>
              @if($row->room == '')
              <td>Excess</td>
              @else
              <td>{{ $row->room }}</td>
              @endif
              @if($row->pc_number == '')
              <td>Excess</td>
              @else
              <td>{{ $row->pc_number }}</td>
              @endif

              @if($row->category == 0)
              <td>Peripherals</td>
              @elseif($row->category == 1)
              <td>Components</td>
              @endif

              <td>{{ $row->type }}</td>
              <td>{{ $row->brand }}</td>
              <td>{{ $row->description }}</td>
              <td>{{ $row->serial }}</td>
              <td>{{ date('M d, Y', (strtotime($row->date_purchased))) }}</td>
              <td>{{ $row->amount }}</td>
              <td>{{ date('M d, Y', (strtotime($row->date_issued))) }}</td>
              <td>{{ $row->remarks }}</td>
              <td>
                @if($row->pc_number == '')
                <a href="#" class="btn btn-default btn-xs" id="AddPart" data-toggle="modal" data-target="#AddModal{{ $row->id }}"><i class="fa fa-plus-square"></i> Add to a Computer</a>
                @endif
                <a href="#" class="btn btn-default btn-xs" id="viewItem" data-toggle="modal" data-target="#messageModal{{$row->id}}"><i class="fa fa-eye"></i> View</a> 
                <a href="{{ route('personnel.component.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                <button type="submit" class="btn btn-xs btn-default" form="deleteItem{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                <form id="deleteItem{{$row->id}}" method="POST" action="{{ route('personnel.component.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
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
  
  @foreach($parts as $row)
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
          @if($row->pc_number == '')
          <label>PC #</label>
          <p id="vroom">EXCESS</p>
          @else
          <label>PC #</label>
          <p id="vroom">{{ $row->pc_number }}</p>
          @endif
          <label>Brand</label>
          <p id="vroom">{{ $row->brand }}</p>
          <label>Description</label>
          <p id="vroom">{{ $row->description }}</p>
          <label>Serial Number</label>
          <p id="vroom">{{ $row->serial }}</p>
          <label>Date Purchased</label>
          <p id="vroom">{{ date('M d, Y', (strtotime($row->date_purchased))) }}</p>
          <label>Amount</label>
          <p id="vroom">{{ $row->amount }}</p>
          <label>Date Issued</label>
          <p id="vroom">{{ date('M d, Y', (strtotime($row->date_issued))) }}</p>
          <hr>
          <label>Remarks</label>
          <p id="vroom">{{ $row->remarks }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Add to Computer Modal --}}
  <div class="modal fade" id="AddModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-title w-100 font-weight-bold">Select a Computer to add {{ $row->description }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{ route('personnel.add.component.update', $row->id) }}" enctype="multipart/form-data">
          <div class="modal-body mx-3">

            <div class="md-form mb-5">
              <i class="fa fa-building"></i>
              <label data-error="wrong" data-success="right">Room</label>
              <select class="form-control js-single" name="room" id="modalroom{{ $row->id }}">
                <option value="" selected>--Select a Room--</option>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
              </select>

            </div>

            <div class="md-form mb-5">
              <i class="fa fa-desktop"></i>
              <label data-error="wrong" data-success="right">Computer</label>
              <select class="form-control js-single" name="computer" id="modalpc{{ $row->id }}">
                <option value="">--Select a Computer--</option>
              </select>
            </div>

          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Save <i class="glyphicon glyphicon-floppy-disk"></i></button>
          </div>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          {{ method_field('PUT') }}
        </form>
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

        @foreach($parts as $row3)

   function resetpc{{ $row3->id }}() {
     $('#modalpc{{ $row3->id }}').empty();
     $('#modalpc{{ $row3->id }}').append('<option value="">--Select a Computer--</option>');
   }
   /* Load positions into postion <selec> */


   $( "#modalroom{{ $row3->id }}" ).change(function() 
   {
    resetpc{{ $row3->id }}();
    // alert( this.value );
    <?php foreach($rooms as $room) : ?>
    if(this.value == {{ $room->id }}){
      <?php
      foreach($computers as $row){
        if($row->room_id == $room->id){ ?>
          $('#modalpc{{ $row3->id }}').append('<option value="{{ $row->id }}" selected="selected"> {{ $row->pc_number }} </option>');
          <?php
        }
      }

      ?>
    }
    <?php endforeach; ?>

  });
   @endforeach
    
 </script>

 @endsection

