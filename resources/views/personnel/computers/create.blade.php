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
        Computers<small>Add Computer.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Personnel</a></li>
        <li><a href="{{ route('computer.personnel.index') }}">Computers</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('computer.personnel.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all computers</a><br><br>
    
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

      <form method="post" action="{{ route('computer.personnel.store') }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new Computer</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-4">
                <label>Room <span class="required-field">*</span></label>
                <select class="form-control js-single" name="room">
                  @foreach($rooms as $row)
                  <option value="{{ $row->id }}">{{ '(' .$row->short_name. ') ' .$row->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-xs-4">
                <label>PC Number <span class="required-field">*</span></label>
                <input type="text" name="pc_number" class="form-control">
              </div>

              <div class="col-xs-4">
                <label>Status <span class="required-field">*</span></label>
                <select class="form-control js-single" name="status">
                  <option value="0">Working</option>
                  <option value="1">Not Working</option>
                  <option value="2">For Repair</option>
                  <option value="3">For Calibrate</option>
                </select>
              </div>

            </div>
          </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
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
</script>
@endsection