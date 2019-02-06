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
        <li><a href="{{ route('item.index') }}">Items</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('item.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all items</a><br><br>
    
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

      <form method="post" action="{{ route('item.update', $item->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <label>Room <span class="required-field">*</span></label>
            <select class="form-control js-single" name="room_id">
              @foreach($rooms as $row)
                <option value="{{ $row->id }}" @if($row->id == $item->room_id) selected @endif>{{ '(' .$row->short_name. ') ' .$row->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-xs-12">
            <label>Description <span class="required-field">*</span></label>
            <input type="text" name="description" class="form-control" value="{{ $item->description }}">
          </div>

          <div class="form-group col-xs-12">
            <label>Type <span class="required-field">*</span></label>
            <input type="text" name="type" class="form-control" value="{{ $item->type }}">
          </div>

          <div class="form-group col-xs-12">
            <label>Category <span class="required-field">*</span></label>
            <input type="text" name="category" class="form-control" value="{{ $item->category }}">
          </div>

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <label>Quantity <span class="required-field">*</span></label>
                <input type="text" name="quantity" class="form-control" value="{{ $item->quantity }}">
              </div>

              <div class="col-xs-3">
                <label>Working</label>
                <input type="text" name="working" class="form-control" value="{{ $item->working }}">
              </div>

              <div class="col-xs-3">
                <label>Not Working</label>
                <input type="text" name="not_working" class="form-control" value="{{ $item->not_working }}">
              </div>

              <div class="col-xs-3">
                <label>For Repair</label>
                <input type="text" name="for_repair" class="form-control" value="{{ $item->for_repair }}">
              </div>
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
</script>
@endsection
