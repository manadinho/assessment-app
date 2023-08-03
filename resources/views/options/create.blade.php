@extends('master')

@section('content')
    <h3>Option</h3> 
    <form method="POST" action="{{route('options.store')}}" class="col s12" enctype="multipart/form-data">
        @csrf
        @if(isset($option))
            <input type="hidden" name="id" value="{{ $option->id }}">
        @endif
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label for="name" class="col-md-3 col-form-label">
                    {{__('Name')}}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" id="name" placeholder="" required="required" name="name" type="text" value="{{ isset($option) ? $option->name: old('name') }}">
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label for="price" class="col-md-3 col-form-label">
                    {{__('Price')}}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" id="price" placeholder="" required="required" name="price" type="number" step="0.001" value="{{ isset($option) ? $option->price: old('price') }}">
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-7 mb-5 mt-3">
                        <button type="submit" class="btn btn-primary">
                                                    {{ isset($option) ? __('Update'):__('Add')}} 
                        </button>
                        <a href="{!! route('options.index') !!}" class="btn btn-warning">{{__('Cancel')}}</a>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
