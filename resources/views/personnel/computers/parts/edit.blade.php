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
    Component<small>Edit Component.</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ backpack_url() }}">Admin</a></li>
    <li><a href="{{ route('component.index') }}">Component</a></li>
    <li class="active">Add</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('component.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all Components</a><br><br>
    
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

    <form method="post" action="{{ route('personnel.component.update', $component->id) }}" enctype="multipart/form-data">

      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit {{ $component->type }} Details</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

         <div class="form-group col-xs-12">
          <div class="row">



              <div class="col-xs-6">
                <label>Room <span class="required-field">*</span></label>
                <select class="form-control js-single" name="room" id="room">
                  <option value="none">---Select a Room---</option>
                  @foreach($rooms as $row)
                    <option value="{{ $row->id }}" @if($component->room_id == $row->id) selected @endif>{{ $row->name }}</option>
                  @endforeach

                </select>
              </div>

            <div class="col-xs-6">
              <label>Computer <span class="required-field">*</span></label>
              <select class="form-control js-single" name="computer" id="computer">
                
                    @if($component->pc_id == '')
                      <option value="none"  selected>---EXCESS---</option>
                      @foreach($computers as $pc)
                          @if($pc->room_id == $component->room_id)
                          <option value="{{ $pc->id }}" >{{ $pc->pc_number }}</option>
                          @endif
                        @endforeach
                    @else
                        @foreach($computers as $pc)
                          @if($pc->room_id == $component->room_id)
                          <option value="{{ $pc->id }}" @if($component->pc_id == $pc->id) selected @endif>{{ $pc->pc_number }}</option>
                          @endif
                        @endforeach
                    @endif
                
              </select>
            </div>

          </div>
        </div>

        <div class="form-group col-xs-12">
          <div class="row">
            <div class="col-xs-3">
              <label>Category <span class="required-field">*</span></label>
              <select class="form-control js-single" name="category" id="category" disabled>
                <option value="none">Select Category</option>
                <option value="0" @if($component->category == 0) selected @endif>Peripherals</option>
                <option value="1" @if($component->category == 1) selected @endif>Components</option>
              </select>
            </div>

            <div class="col-xs-3">
              <label>Type <span class="required-field">*</span></label>
              <select class="form-control js-single" name="type" id="type" disabled>
                <option value="none">Select Type</option>
                <option value="{{ $component->type }}" selected>{{ $component->type }}</option>
              </select>
            </div>

            <div class="col-xs-3">
              <label>Brand <span class="required-field">*</span></label>
              <input type="text" name="brand" class="form-control" value="{{ $component->brand }}">
            </div>

            <div class="col-xs-3">
              <label>Description <span class="required-field">*</span></label>
              <input type="text" name="description" class="form-control" value="{{ $component->description }}">
            </div>

          </div>
        </div>

        <div class="form-group col-xs-12">
          <div class="row">

            <div class=" col-xs-3">
              <label>Serial Number <span class="required-field">*</span></label>
              <input type="text" name="serial" class="form-control" value="{{ $component->serial }}">
            </div>

            <div class=" col-xs-3">
              <label>Date Purchased <span class="required-field">*</span></label>
              <input type="date" name="date_purchased" class="form-control" value="{{ $component->date_purchased }}">
            </div>

            <div class=" col-xs-3">
              <label>Amount <span class="required-field">*</span></label>
              <input type="text" name="amount" class="form-control" value="{{ $component->amount }}">
            </div>

            <div class=" col-xs-3">
              <label>Date Issued <span class="required-field">*</span></label>
              <input type="date" name="date_issued" class="form-control" value="{{ $component->date_issued }}">
            </div>

          </div>
        </div>

        <div class="form-group col-xs-12">
          <label>Remarks <span class="required-field">*</span></label>
          <input type="text" name="remarks" class="form-control" value="{{ $component->remarks }}">
        </div>

      </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
    </div><!-- /.box-footer-->

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
      $('#type').append('<option value="Monitor" selected="selected">Monitor</option>');
      $('#type').append('<option value="Keyboard" selected="selected">Keyboard</option>');
      $('#type').append('<option value="Mouse" selected="selected">Mouse</option>');
      $('#type').append('<option value="Headset" selected="selected">Headset</option>');
    }

    if(this.value == 1) {
      $('#type').append('<option value="RAM" selected="selected">RAM</option>');
      $('#type').append('<option value="HDD" selected="selected">HDD</option>');
      $('#type').append('<option value="CPU" selected="selected">CPU</option>');
      $('#type').append('<option value="Motherboard" selected="selected">Motherboard</option>');
      $('#type').append('<option value="GPU" selected="selected">GPU</option>');
    }
  });

 function resetroom() {
   $('#computer').empty();
   $('#computer').append('<option value="">---EXCESS---</option>');
 }

 
 $( "#room" ).change(function() 
 {
    // alert( this.value );
    <?php foreach($rooms as $row) : ?>
    if(this.value == {{ $row->id }}){
      resetroom();
      <?php
      foreach($computers as $row1){
        if($row1->room_id == $row->id){ ?>
          $('#computer').append('<option value="{{ $row1->id }}"> {{ $row1->pc_number }} </option>');
          <?php
        }
      }

      ?>
    }
    <?php endforeach; ?>

  });
</script>
@endsection
