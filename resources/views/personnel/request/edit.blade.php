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
        Request<small>Edit Request.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Personnel</a></li>
        <li><a href="{{ route('order.index') }}">Request</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('order.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all Requests</a><br><br>
    
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

      <form method="post" action="{{ route('order.update', $order->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">
      

        <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-4">
            <label>Room <span class="required-field">*</span></label>
            <select class="form-control js-single" name="room">
              @foreach($rooms as $row)
                <option value="{{ $row->id }}" @if($order->room_id == $row->id) selected @endif>{{ '(' .$row->short_name. ') ' .$row->name }}</option>
              @endforeach
            </select>
            </div>

            <div class="col-xs-4">
            <label>Nature <span class="required-field">*</span></label>
            <select class="form-control js-single" name="nature" id="nature">
              <option value="none">--Select a Nature--</option>
              <option value="Mechanical" @if($order->nature == "Mechanical") selected @endif>Mechanical</option>
              <option value="Electrical" @if($order->nature == "Electrical") selected @endif>Electrical</option>
              <option value="Carpentry" @if($order->nature == "Carpentry") selected @endif>Carpentry</option>
              <option value="Janitorial" @if($order->nature == "Janitorial") selected @endif>Janitorial</option>
              <option value="0" @if($order->nature != "Mechanical" && $order->nature != "Electrical" && $order->nature != "Carpentry" && $order->nature != "Janitorial") selected @endif>Others</option>
            </select>
            </div>

              @if($order->nature != "Mechanical" && $order->nature != "Electrical" && $order->nature != "Carpentry" && $order->nature != "Janitorial")

              <div class="col-xs-4">
                <label id="lblothers">Please Specify <span class="required-field">*</span></label>
                <input type="text" name="others" class="form-control" id="others" value="{{ $order->nature }}">
              </div>

              @else

              <div class="col-xs-4">
                <label id="lblothers" hidden>Please Specify <span class="required-field">*</span></label>
                <input type="hidden" name="others" class="form-control" id="others">
              </div>

            @endif  
          </div>
        </div>
        


          <div class="form-group col-xs-12">
            <div class="row">

              <div class="col-xs-6">
                <label>Request <span class="required-field">*</span></label>
                <input type="text" name="order" class="form-control" id="order" value="{{ $order->request }}">
              </div>

              <div class="col-xs-6">
                <label>Action Taken</label>
                <input type="text" name="action" class="form-control" id="action" value="{{ $order->action_taken }}">
              </div>                   
            </div>
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

$( "#nature" ).change(function() 
  {
    // alert( this.value );
    if(this.value == 0){
      $('#others').attr('type', 'text');
      $('#lblothers').show();
    }else{
      $('#others').attr('type', 'hidden');
      $('#lblothers').hide();
    }
  });

</script>
@endsection
