@extends('backpack::layout')

@section('after_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
.required-field {
  color: red;
}

.box > .box-body {
  display: flex !important; 
  flex-wrap: wrap !important;
  padding-bottom: 0px !important;
}

.box .row > div.col-xs-1 {
  padding-right: 0px;
}

.box .row > div.col-xs-1 > label,
.box .row > div.col-xs-2 > label,
.box .row > div.col-xs-1 > input.form-control,
.box .row > div.col-xs-2 > input.form-control  {
  font-size: 12px !important;
}

.box .row > div.col-xs-1 > input.form-control,
.box .row > div.col-xs-2 > input.form-control  {
  padding-right: 2px !important;
  padding-left: 2px !important;
}

</style>
@endsection

@section('header')
<section class="content-header">
  <h1>
    Components<small>Add Parts.</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ backpack_url() }}">Admin</a></li>
    <li><a href="{{ route('computer.index') }}">Computers</a></li>
    <li class="active">Add</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 ">
    <!-- Default box -->  
    <a href="{{ route('personnel.computer.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all computers</a><br><br>
    
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

    <form method="post" enctype="multipart/form-data" id="create_form">
      {!! csrf_field() !!}
      <div class="box-header with-border">
          <h3 class="box-title">{{ $computer->pc_number }} Peripherals</h3>
        </div>
      <div class="box">
        {{-- Monitor --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;padding-bottom: 0px;">

          <div class="form-group col-xs-12" >
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">MONITOR<small> </small></label>
              </div>
            </div>
            <div class="row">


              <input type="hidden" value="0" name="monitorcategory">

              <input type="hidden" value="Monitor" name="monitortype">
              <div class="col-xs-1" style="padding-right: 0px;">
                <label style="font-size: 12px;">Brand<small> </small></label >
                <input type="text" name="monitorbrand" class="form-control" style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>

              <div class="col-xs-2" style="padding-right: 0px;">
                <label style="font-size: 12px;">Description</label>
                <input type="text" name="monitordescription" class="form-control" style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>


              <div class=" col-xs-2" style="padding-right: 0px;">
                <label style="font-size: 12px;">Serial Number </label>
                <input type="text" name="monitorserial" class="form-control"style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>

              <div class=" col-xs-2" style="padding-right: 0px;">
                <label style="font-size: 12px;">Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="monitordate_purchased" class="form-control" style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>

              <div class=" col-xs-1" style="padding-right: 0px;">
                <label style="font-size: 12px;">Amount <span class="required-field">*</span></label>
                <input type="text" name="monitoramount" class="form-control" style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>

              <div class=" col-xs-2" style="padding-right: 0px;">
                <label style="font-size: 12px;">Date Issued <span class="required-field">*</span></label>
                <input type="date" name="monitordate_issued" class="form-control" style="font-size: 11px;padding-left: 2px; padding-right: 2px;">
              </div>

              <div class=" col-xs-2" style="padding-right: 0px;">
                <label style="font-size: 12px;">Remarks </label>
                <input type="text" name="monitorremarks" class="form-control"style="font-size: 11px;padding-left: 2px; padding-right: 2px;    width: 87%;">
              </div>
    
            </div>
          </div>
        </div>
        {{-- Keyboard --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Keyboard<small> </small></label>
              </div>
            </div>

            <div class="row">

              <input type="hidden" value="0" name="keyboardcategory">

              <input type="hidden" value="Keyboard" name="keyboardtype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="keyboardbrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="keyboarddescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="keyboardserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="keyboarddate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="keyboardamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="keyboarddate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="keyboardremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- Mouse --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">


          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Mouse<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="0" name="mousecategory">

              <input type="hidden" value="Mouse" name="mousetype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="mousebrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="mousedescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="mouseserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="mousedate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="mouseamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="mousedate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="mouseremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- AVR --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">AVR<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="0" name="avrcategory">

              <input type="hidden" value="AVR" name="avrtype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="avrbrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="avrdescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="avrserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="avrdate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="avramount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="avrdate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="avrremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- Headset --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Headset<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="0" name="headsetcategory">

              <input type="hidden" value="Headset" name="headsettype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="avrbrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="avrdescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="avrserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="avrdate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="avramount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="avrdate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="avrremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

      </div><!-- /.box -->

{{-- Components --}}
 <div class="box-header with-border">
          <h3 class="box-title">{{ $computer->pc_number }} Components</h3>
        </div>

    <div class="box">
        {{-- Processor --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Processor<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="1" name="cpucategory">

              <input type="hidden" value="Processor" name="cputype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="cpubrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="cpudescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="cpuserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="cpudate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="cpuamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="cpudate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="cpuremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- Motherboard --}}

        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Motherboard<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="1" name="mobocategory">

              <input type="hidden" value="Motherboard" name="mobotype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="mobobrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="mobodescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="moboserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="mobodate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="moboamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="mobodate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="moboremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- GPU --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Graphics Card<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="1" name="gpucategory">

              <input type="hidden" value="GPU" name="gputype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="gpubrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="gpudescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="gpuserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="gpudate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="gpuamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="gpudate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="gpuremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- RAM --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">RAM<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="1" name="ramcategory">

              <input type="hidden" value="RAM" name="ramtype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="rambrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="ramdescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="ramserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="ramdate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="ramamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="ramdate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="ramremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

        {{-- HDD --}}
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-1">
               <label style="font-size: 15px;">Hard Disk<small> </small></label>
              </div>
            </div>
            <div class="row">

              <input type="hidden" value="1" name="hddcategory">

              <input type="hidden" value="HDD" name="hddtype">

              <div class="col-xs-1">
                <label>Brand</label>
                <input type="text" name="hddbrand" class="form-control">
              </div>

              <div class="col-xs-2">
                <label>Description</label>
                <input type="text" name="hdddescription" class="form-control">
              </div>


              <div class=" col-xs-2">
                <label>Serial Number </label>
                <input type="text" name="hddserial" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Purchased <span class="required-field">*</span></label>
                <input type="date" name="hdddate_purchased" class="form-control">
              </div>

              <div class=" col-xs-1">
                <label>Amount <span class="required-field">*</span></label>
                <input type="text" name="hddamount" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Date Issued <span class="required-field">*</span></label>
                <input type="date" name="hdddate_issued" class="form-control">
              </div>

              <div class=" col-xs-2">
                <label>Remarks </label>
                <input type="text" name="hddremarks" class="form-control">
              </div>
    
            </div>
          </div>
        </div>

      </div><!-- /.box -->

        </form>

      <div class="box-footer">
        <div class="border-top">
          <div class="card-body">
            <button type="submit" class="btn btn-success btn-sm" form="create_form" formaction="{{ route('component.store' , $computer->id) }}"><i class="glyphicon glyphicon-floppy-disk"></i> Submit</button>
            <button type="submit" class="btn btn-success btn-sm" form="create_form" formaction="{{ route('component.store.new', $computer->id) }}"><i class="glyphicon glyphicon-floppy-saved"></i> Submit And New</button>
          </div>
        </div>
      </div><!-- /.box-footer-->

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

  /* Load positions into postion <selec> */
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
  </script>
  @endsection