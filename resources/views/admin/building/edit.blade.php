@extends('backpack::layout')

@section('after_styles')
<style>
  .required-field {
    color: red;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Buildings<small>Edit building.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('building.index') }}">Buildings</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('building.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all buildings</a><br><br>
    
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

      <form method="post" action="{{ route('building.update', $building->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <label>Name <span class="required-field">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $building->name }}">
          </div> 

          <div class="form-group col-xs-12">
            <label>Short Name <span class="required-field">*</span></label>
            <input type="text" name="short_name" class="form-control" value="{{ $building->short_name }}">
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
