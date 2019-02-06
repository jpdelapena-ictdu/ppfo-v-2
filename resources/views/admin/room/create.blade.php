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
        Rooms<small>Add room.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('room.index') }}">Rooms</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('room.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all rooms</a><br><br>
    
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

      <form method="post" action="{{ route('room.store') }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new room</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <label>Building <span class="required-field">*</span></label>
            <select class="form-control js-single" name="building_id">
              @foreach($buildings as $row)
                <option value="{{ $row->id }}">{{ '(' .$row->short_name. ') ' .$row->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-xs-12">
            <label>Name <span class="required-field">*</span></label>
            <input type="text" name="name" class="form-control">
          </div>

          <div class="form-group col-xs-12">
            <label>Short Name <span class="required-field">*</span></label>
            <input type="text" name="short_name" class="form-control">
          </div>

          <div class="form-group col-xs-12">
            <label>Person in charge <span class="required-field">*</span></label>
            <input type="text" name="in_charge" class="form-control">
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