@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Add Product</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary card-outline">
                            <form action={{route('product.store')}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="category_id">Category <span class="text-danger">*</span></label>

                                                <select id="category_id" name="category_id[]" class="js-example-basic-multiple form-control select2" required="" multiple="multiple">
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sub_category_id">Sub Category</label>

                                                <select id="sub_category_id" name="sub_category_id[]" class="js-example-basic-multiple form-control select2" multiple="multiple">
                                                    <option value="">Select Sub Category</option>
                                                    @foreach($subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('sub_category_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="col-md-6 mt-3">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}" placeholder="Enter Name">

                                                @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="password-vertical">Description <span class="text-danger">*</span></label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                                @error('description')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="tags">Tags<span class="text-danger">*</span></label>
                                                <textarea name="tags" id="tags" class="form-control"></textarea>
                                                @error('tags')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="weight">Weight <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="weight" name="weight" required value="{{old('weight')}}" placeholder="Enter Weight">

                                                @error('weight')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="unit_id">Unit <span class="text-danger">*</span></label>

                                                <select id="unit_id" name="unit_id" class="js-example-basic-multiple form-control select2" required="">
                                                    <option value="">Select Unit Name</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('unit_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="col-md-6 mt-3">
                                                <label for="purchase_price">Purchase Price (INR)<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="purchase_price" name="purchase_price" required value="{{old('purchase_price')}}" placeholder="Enter Purchase Price in INR">

                                                @error('purchase_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="sale_price">Sale Price (INR)<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="sale_price" name="sale_price" required value="{{old('sale_price')}}" placeholder="Enter Sale Price in INR">

                                                @error('sale_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="discount_price">Maximum Retail Price(INR)</label>
                                                <input type="text" class="form-control" id="discount_price" name="discount_price" value="{{ old('discount_price') }}" placeholder="Enter MRP Price in INR">
                                                @error('discount_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required value="{{old('quantity')}}" placeholder="Enter Quantity">

                                                @error('quantity')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3 main">
                                                <label for="image">Image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control image"
                                                            id="image" name="image" accept="image/*" required>
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                @error('image')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="product-img-tag" width="192px" height="192px" style="display:none;" /> <br>
                                            </div>

                                            <div class="col-md-6 mt-3 main">
                                                <label for="image1">Image 1 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control image" id="image1" name="image1" accept="image/*" >
                                                        <label class="custom-file-label" for="image1">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                @error('image1')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="image1-img-tag1" width="192px" height="192px" class="mt-2" style="display:none;" />
                                            </div>

                                            <div class="col-md-6 mt-3 main">
                                                <label for="image2">Image 2 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control image" id="image2" name="image2" accept="image/*" >
                                                        <label class="custom-file-label" for="image2">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                @error('image2')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="image2-img-tag" width="192px" height="192px" class="mt-2" style="display:none;" />
                                            </div>

                                            <div class="col-md-6 mt-3 main">
                                                <label for="image3">Image 3 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control image" id="image3" name="image3" accept="image/*" >
                                                        <label class="custom-file-label" for="image3">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                @error('image3')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="image3-img-tag" width="192px" height="192px" class="mt-2" style="display:none;" />
                                            </div>

                                            <div class="col-md-6 mt-3 main">
                                                <label for="image4">Image 4 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control image" id="image4" name="image4" accept="image/*" >
                                                        <label class="custom-file-label" for="image4">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                @error('image4')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="image4-img-tag" width="192px" height="192px" class="mt-2" style="display:none;" />
                                            </div> 

                                            <div class="col-md-6 mt-3">
                                                 <label for="expiry_date">Expiry Date</label>
                                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" placeholder="Enter Expiry Date">

                                                    @error('expiry_date')
                                                        <span class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>

                                            <div class="col-md-4 mt-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="trending" name="trending">
                                                    <label for="trending">
                                                        Trending
                                                    </label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('product.index')}}" class="btn btn-primary">Return</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
        console.error( error );
    } );

    $(document).ready( function () {
        $('.select2').select2();
    });

    $("#purchase_price, #sale_price").keypress(function(event) {
        var character = String.fromCharCode(event.keyCode);
        return isValids(character);
    });

    function isValids(str) {
        return !/[~`!@#$%\^&*()s=\-\[\]\\abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';,/{}|\\":<>\?]/g.test(str);
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).closest(".main").find("img").show().attr('src', e.target.result);
                // $('#product-img-tag').show();
                // $('#product-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".image").change(function() {
        readURL(this);
    });
</script>

@stop
