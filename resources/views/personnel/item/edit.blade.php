@extends('backpack::layout')

@section('after_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  .required-field {
    color: red;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Items<small>Edit item.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('item.personnel.index') }}">Items</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('item.personnel.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all items</a><br><br>
    
    {{-- Show the errors, if any --}}
    @if ($errors->any())
        <div class="callout callout-danger">
            {{-- <h4>dsasdadsa</h4> --}}
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form method="post" action="{{ route('item.personnel.update', $item->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

           <div class="form-group col-xs-12">
            <div class="row">

              <div class="col-xs-6">
                <label>Room <span class="required-field">*</span></label>
                <select class="form-control js-single" name="room" id="room">
                  <option value="none">---Select a Room---</option>
                  @foreach($rooms as $row)
                    
                      <option value="{{ $row->id }}" @if($item->room_id == $row->id) selected @endif>{{ $row->name }}</option>
                    
                  @endforeach
                </select>
              </div>

             <div class="col-xs-6">
                <label>Category <span class="required-field">*</span></label>
                <select class="form-control js-single" name="category" id="category">
                  <option value="none">Select Category</option>
                  <option value="0" @if($item->category == 0) selected @endif>Computer</option>
                  <option value="1" @if($item->category == 1) selected @endif>Fixtures & Furnitures</option>
                  <option value="2" @if($item->category == 2) selected @endif>Aircon</option>
                  <option value="3" @if($item->category == 3) selected @endif>Equipments</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group col-xs-12">
            <div class="row">

              <div class="col-xs-4">
                <label>Brand <span class="required-field">*</span></label>
                <input type="text" name="brand" class="form-control" id="brand" value="{{ $item->brand }}">
              </div>

              <div class="col-xs-4">
                <label>Description <span class="required-field">*</span></label>
                <input type="text" name="description" class="form-control" id="description" value="{{ $item->description }}">
              </div>                   

              <div class="col-xs-4">
                <label>Quantity <span class="required-field">*</span></label>
                <input type="text" name="quantity" class="form-control" id="quantity" value="{{ $item->quantity }}">
              </div>
            </div>
          </div>
      

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <label>Serial <span class="required-field">*</span></label>
                <input type="text" name="serial" class="form-control" id="serial" value="{{ $item->serial }}">
              </div>

              <div class="col-xs-3">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="date_purchased" class="form-control" id="date_purchased" value="{{ $item->date_purchased }}">
              </div>

              <div class="col-xs-3">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="amount" class="form-control" id="amount" value="{{ $item->amount }}">
              </div>

              <div class="col-xs-3">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="date_issued" class="form-control" id="date_issued" value="{{ $item->date_issued }}">
              </div>

            </div>
          </div>           

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <label>Working</label>
                <input type="text" name="working" class="form-control" id="working" value="{{ $item->working }}">
              </div>

              <div class="col-xs-3">
                <label>Not Working</label>
                <input type="text" name="not_working" class="form-control" id="not_working" value="{{ $item->not_working }}">
              </div>

              <div class="col-xs-3">
                <label>For Repair</label>
                <input type="text" name="for_repair" class="form-control" id="for_repair" value="{{ $item->for_repair }}">
              </div>

              <div class="col-xs-3">
                <label>For Calibration</label>
                <input type="text" name="for_calibrate" class="form-control" id="for_calibrate" value="{{ $item->for_calibrate }}">
              </div>
            </div>
          </div>

           <div class="form-group col-xs-12">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" id="remarks" value="{{ $item->remarks }}">
          </div>
           
          
        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer-->
        </div>
        </div>
      </div><!-- /.box -->
      <input type="hidden" name="_token" value="{{ Session::token() }}">
      {{ method_field('PUT') }}
      </form>
  </div>
</div>

@endsection

@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-single').select2();
  });

   $( "#category" ).change(function() 
  {
    // alert( this.value );
    if(this.value == 0){
      $('#description').prop('disabled', true);
      $('#brand').prop('disabled', true);
      $('#date_issued').prop('disabled', true);
      $('#amount').prop('disabled', true);
      $('#date_purchased').prop('disabled', true);
      $('#serial').prop('disabled', true);
      $('#working').prop('disabled', true);
      $('#not_working').prop('disabled', true);
      $('#for_repair').prop('disabled', true);
      $('#for_calibrate').prop('disabled', true);
      $('#remarks').prop('disabled', true);
    }else{
      $('#description').prop('disabled', false);
      $('#brand').prop('disabled', false);
      $('#date_issued').prop('disabled', false);
      $('#amount').prop('disabled', false);
      $('#date_purchased').prop('disabled', false);
      $('#serial').prop('disabled', false);
      $('#working').prop('disabled', false);
      $('#not_working').prop('disabled', false);
      $('#for_repair').prop('disabled', false);
      $('#for_calibrate').prop('disabled', false);
      $('#remarks').prop('disabled', false);
    }
     });
</script>
@endsection
