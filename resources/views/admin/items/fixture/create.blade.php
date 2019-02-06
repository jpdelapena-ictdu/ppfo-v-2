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
        Fixtures, Furnitures and Equipments<small>All fixtures, furnitures and equipments in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('fixture.index') }}">Fixtures, Furnitures and Equipments</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <!-- Default box -->  
    <a href="{{ route('fixture.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all fixtures, furnitures and equipments</a><br><br>
    
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

      <form method="post" action="{{ route('fixture.store') }}">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new item</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <label>Room <span class="required-field">*</span></label>
            <select class="form-control js-single" name="room_id">
              <option value="none">Select a room</option>
              @foreach($rooms as $row)
                <option value="{{ $row->id }}">{{ '(' .$row->short_name. ') ' .$row->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-xs-12">
            <label>Item <span class="required-field">*</span></label>
            <input type="text" name="description" class="form-control">
          </div>

          <div class="form-group col-xs-12">
            <label>Type <span class="required-field">*</span></label>
            <input type="text" name="type" class="form-control">
          </div>

          <div class="form-group col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <label>Quantity <span class="required-field">*</span></label>
                <input type="text" name="quantity" class="form-control">
              </div>

              <div class="col-xs-3">
                <label>Working</label>
                <input type="text" name="working" class="form-control">
              </div>

              <div class="col-xs-3">
                <label>Not Working</label>
                <input type="text" name="not_working" class="form-control">
              </div>

              <div class="col-xs-3">
                <label>For Repair</label>
                <input type="text" name="for_repair" class="form-control">
              </div>
            </div>
          </div><!-- 
          
          <div class="form-group col-xs-12">
            <label>Date Purchased</label>
            <input type="date" name="date_purchased" class="form-control">
          </div>
          
          <div class="form-group col-xs-12">
            <label>Price</label>
            <input type="text" name="price" class="form-control">
          </div>
          
          <div class="form-group col-xs-12">
            <label>Date Installed</label>
            <input type="date" name="date_installed" class="form-control">
          </div> -->

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