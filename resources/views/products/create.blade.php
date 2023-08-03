@extends('master')

@section('content')
    <h3>Product</h3> 
    <form method="POST" id="form" action="{{route('products.store')}}" class="col s12" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            <input type="hidden" name="id" id="id" value="{{ $product->id }}">
        @endif
        <input type="hidden" name="mainOptionsArrayData" id="mainOptionsArrayData">
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label for="name" class="col-md-3 col-form-label">
                    {{__('Name')}}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" id="name" placeholder="" required="required" name="name" type="text" value="{{ (isset($product)) ? $product->name:'' }}">
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label for="description" class="col-md-3 col-form-label">
                    {{__('Description')}}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <textarea name="description" id="description" class="form-control" cols="30" rows="10" palceholder="description">{{ (isset($product)) ? $product->description:'' }}</textarea>
                </div>
            </div>
            <hr>
            <h3>Sizes</h3>
            <div class="form-group">
                <a href="javascript:void(0)" class="btn" title="{{__('Add')}}" onClick="addNewSize()" style="background:black;color:#fff;float:right;margin-bottom:5px"><span class="fa fa-plus"></span></a>
            </div>
            <br>
            <br>
            <div style="overflow-x: auto">
                <div id="sizes-container-div">
                    @if(isset($product))
                        @forelse($product->sizes as $size)
                            <div id="size-div-{{ $size->id }}">
                                <div style="width:100%">
                                    <div class="form-group d-inline-block" style="width:30%">
                                        <label for="name">{{__("Name")}}</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" required name="names[]" class="form-control" value="{{ $size->name }}">
                                        <input type="hidden" name="sized_ids[]" value="{{ $size->id }}">
                                    </div>
                                    <div class="form-group d-inline-block" style="width:30%">
                                        <label for="price">{{__("Price")}}</label>
                                        <span class="text-danger">*</span>
                                        <input type="number" required step="0.001" name="prices[]" class="form-control" value="{{ $size->price }}">
                                    </div>
                                    <div class="form-group d-inline-block" style="width:30%">
                                        <label for="price">{{__("Options")}}</label>
                                        <span class="text-danger">*</span>
                                        <select name="options[]" required id="options-{{$size->id}}" class="form-control" multiple onchange="optionsChanged()">
                                            @forelse($options as $option)
                                                <option value="{{ $option->id }}">{{ $option->name }} <small>({{ $option->price }} {{ config('app.currency') }})</small></option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($loop->iteration > 1)
                                        <div class="form-group d-inline-block" style="width:7%">
                                            <span onClick="removeSize({{ $size->id }})"><i class="fa fa-trash" aria-hidden="true" style="font-size: 25px;cursor:pointer"></i></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @else
                        <div style="width:100%">
                            <div class="form-group d-inline-block" style="width:30%">
                                <label for="name">{{__("Name")}}</label>
                                <span class="text-danger">*</span>
                                <input type="text" required name="names[]" class="form-control">
                                <input type="hidden" name="sized_ids[]" value="0">
                            </div>
                            <div class="form-group d-inline-block" style="width:30%">
                                <label for="price">{{__("Price")}}</label>
                                <span class="text-danger">*</span>
                                <input type="number" required step="0.001" name="prices[]" class="form-control">
                            </div>
                            <div class="form-group d-inline-block" style="width:30%">
                                <label for="price">{{__("Options")}}</label>
                                @if(!count($options))
                                    <a href="{{ route('options.create') }}">No option found, want to create option?</a>
                                @endif
                                <span class="text-danger">*</span>
                                <select name="options[]" required id="options" class="form-control" multiple onchange="optionsChanged()">
                                    @forelse($options as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }} <small>({{ $option->price }} {{ config('app.currency') }})</small></option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    {{-- <div class="col-md-1"></div> --}}
                    <div class="col-12 mb-5 mt-3 ml-5">
                        <button type="submit" class="btn btn-primary">
                                                    {{(isset($product)) ? __('Update'):__('Add')}} 
                        </button>
                        <a href="{!! route('products.index') !!}" class="btn btn-warning">{{__('Cancel')}}</a>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        
        @if(isset($product))
            let product = @json($product);
            product.sizes.forEach(size => {
                const selectedOptionIds = $.map(size.options, option => option.id);
                $(`#options-${size.id}`).select2();
                $(`#options-${size.id}`).val(selectedOptionIds).trigger('change');
            });
        @else
            $(`#options`).select2();
        @endif

        function addNewSize() {
            const number = Math.floor(Math.random() * 1000000);
            let html = `
                        <div id="size-div-${number}">
                            <div style="width:100%">
                                <div class="form-group d-inline-block" style="width:30%">
                                    <label for="name">{{__("Name")}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" required name="names[]" class="form-control">
                                    <input type="hidden" name="sized_ids[]" value="0">
                                </div>
                                <div class="form-group d-inline-block" style="width:30%">
                                    <label for="price">{{__("Price")}}</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" required step="0.001" name="prices[]" class="form-control">
                                </div>
                                <div class="form-group d-inline-block" style="width:30%">
                                    <label for="price">{{__("Options")}}</label>
                                    <span class="text-danger">*</span>
                                    <select name="options[]" required id="options-${number}" class="form-control" multiple onchange="optionsChanged()">
                                        @forelse($options as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}<small>({{ $option->price }} {{ config('app.currency') }})</small></option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group d-inline-block" style="width:7%">
                                    <span onClick="removeSize(${number})"><i class="fa fa-trash" aria-hidden="true" style="font-size: 25px;cursor:pointer"></i></span>
                                </div>
                            </div>
                        </div>
            `

            $(`#sizes-container-div`).append(html);
            $(`#options-${number}`).select2();
        }    

        function removeSize(number) {
            $('#size-div-'+number).remove();
        }

        function optionsChanged() {
            var mainOptionsArray = [];

            $('select[name="options[]"]').each(function() {
                var selectedOptions = $(this).val();
                mainOptionsArray.push(selectedOptions);
            });

            console.log(mainOptionsArray);
            $('#mainOptionsArrayData').val(JSON.stringify(mainOptionsArray));
        };
    </script>    
@endpush
