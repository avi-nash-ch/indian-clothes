@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
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
                            <form action={{route('product.update', encrypt($product->id))}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="category_id">Category <span class="text-danger">*</span></label>

                                                <select id="category_id" name="category_id[]" class="js-example-basic-multiple form-control select2" required="" multiple="multiple">
                                                    <option value="">Select Category</option>
                                                    {{-- @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>{{ $category->name }}</option>
                                                    @endforeach --}}

                                                    @foreach ($categories as $category )
                                                        <option value="{{ $category->id }}" @if(in_array($category->id, $product->category_id)) selected @endif> {{ $category->name}}</option>
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

                                                <select id="sub_category_id" name="sub_category_id[]" class="js-example-basic-multiple form-control select2"  multiple="multiple">
                                                    <option value="">Select Category</option>
                                                    {{-- @foreach($subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(old('sub_category_id', $product->sub_category_id) == $subCategory->id) selected @endif>{{ $subCategory->name }}</option>
                                                    @endforeach --}}

                                                    @foreach ($subCategories as $subCategory )
                                                        <option value="{{ $subCategory->id }}" @if(in_array($subCategory->id, $product->sub_category_id)) selected @endif> {{ $subCategory->name}}</option>
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
                                                <input type="text" class="form-control" id="name" name="name" required  value="{{old('name', $product->name)}}" placeholder="Enter Name">

                                                @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="password-vertical">Description <span class="text-danger">*</span></label>
                                                <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                                                @error('description')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="tags">Tags<span class="text-danger">*</span></label>
                                                <textarea name="tags" id="tags" class="form-control">{{ $product->tags }}</textarea>
                                                @error('tags')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="weight">Weight <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="weight" name="weight" required value="{{old('weight', $product->weight)}}" placeholder="Enter Weight">

                                                @error('weight')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="unit_id">Unit <span class="text-danger">*</span></label>

                                                <select id="unit_id" name="unit_id" class="js-example-basic-multiple form-control select2" required="">
                                                    <option value="">Select Unit</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}" @if(old('unit_id', $product->unit_id) == $unit->id) selected @endif>{{ $unit->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('unit_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="purchase_price">Purchase Price (INR) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="purchase_price" name="purchase_price" required  value="{{old('purchase_price', $product->purchase_price)}}" placeholder="Enter Purchase Price">

                                                @error('purchase_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="sale_price">Sale Price (INR)<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="sale_price" name="sale_price" required value="{{old('sale_price', $product->sale_price)}}" placeholder="Enter Sale Price">

                                                @error('sale_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="discount_price">Maximum Retail Price (INR)</label>
                                                <input type="text" class="form-control" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" placeholder="Enter Discount Price">
                                                @error('discount_price')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required  value="{{old('quantity', $product->quantity)}}" placeholder="Enter Quantity">

                                                @error('quantity')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="image">Image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="image" name="image" accept="image/*">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                <img src="{{ getImageUrl($product->image) }}"  style=" @if(!$product->image) display: none; @endif " id="profile-img-tag" width="192px" height="192px" class="mt-2">
                                                @if($product->image)
                                                    <button type="button" class="btn btn-danger mt-2"  style=" @if(!$product->image) display: none; @endif " id="remove-image-btn">Remove</button>
                                                
                                                @endif
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="image1">Image 1</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="image1" name="image1" accept="image/*">
                                                        <label class="custom-file-label" for="image1">Choose file</label>
                                                    </div>
                                                </div>

                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                <img src="{{ getImageUrl($product->image1) }}"  style=" @if(!$product->image1) display: none; @endif " id="image1-img-tag" width="192px" height="192px" class="mt-2">
                                                <button type="button" class="btn btn-danger mt-2"  style=" @if(!$product->image1) display: none; @endif " id="remove-image1">Remove</button>                                               
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="image2">Image 2</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="image2" name="image2" accept="image/*">
                                                        <label class="custom-file-label" for="image2">Choose file</label>
                                                    </div>
                                                </div>

                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                <img src="{{ getImageUrl($product->image2) }}" style=" @if(!$product->image2) display: none; @endif " id="image2-img-tag" width="192px" height="192px" class="mt-2">
                                                <button type="button" class="btn btn-danger mt-2" style=" @if(!$product->image2) display: none; @endif " id="remove-image2">Remove</button>
                                                
                                                
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="image3">Image 3 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="image3" name="image3" accept="image/*">
                                                        <label class="custom-file-label" for="image3">Choose file</label>
                                                    </div>
                                                </div>
                                                
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                <img src="{{ getImageUrl($product->image3) }}"  style=" @if(!$product->image3) display: none; @endif " id="image3-img-tag" width="192px" height="192px" class="mt-2">
                                                <button type="button" class="btn btn-danger mt-2"  style=" @if(!$product->image3) display: none; @endif " id="remove-image3">Remove</button>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="image4">Image 4 </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control" id="image4" name="image4" accept="image/*">
                                                        <label class="custom-file-label" for="image4">Choose file</label>
                                                    </div>
                                                </div>
                                               
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>
                                                <img src="{{ getImageUrl($product->image4) }}"  style=" @if(!$product->image4) display: none; @endif " id="image4-img-tag" width="192px" height="192px" class="mt-2">
                                                <button type="button" class="btn btn-danger mt-2"  style=" @if(!$product->image4) display: none; @endif " id="remove-image4">Remove</button>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="expiry_date">Expiry Date</label>
                                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date) }}" placeholder="Enter Expiry Date">

                                                    @error('expiry_date')
                                                        <span class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-4 mt-5">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="trending" name="trending" {{ $product->trending ? 'checked' : '' }}>
                                                    <label for="trending">
                                                        Trending
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
                $('#profile-img-tag').show();
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
   
    $(document).ready(function() {
    // Function to preview selected image
    function readURL(input, imgTagId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(imgTagId).attr('src', e.target.result).show(); // Set image src and show it
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview image when selected
    $('#image').change(function() {
        readURL(this, '#profile-img-tag');
        $('#remove-image-btn').show(); // Show the remove button when a new image is selected
    });

    $('#image1').change(function() {
        readURL(this, '#image1-img-tag');
        $('#remove-image1').show();
    });

    $('#image2').change(function() {
        readURL(this, '#image2-img-tag');
        $('#remove-image2').show();
    });

    $('#image3').change(function() {
        readURL(this, '#image3-img-tag');
        $('#remove-image3').show();
    });

    $('#image4').change(function() {
        readURL(this, '#image4-img-tag');
        $('#remove-image4').show();
    });

    // Handle Remove button click for image
    $('#remove-image-btn').click(function() {
        if (confirm("Are you sure you want to remove this image?")) {
            // Perform an AJAX call to remove the image
            $.ajax({
                url: "{{ route('product.removeImage', ['product' => $product->id, 'imageType' => 'image']) }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#image').val('');  // Clear file input
                        $('#profile-img-tag').attr('src', '').hide();  // Hide image preview
                        $('#remove-image-btn').hide();  // Hide remove button
                        alert('Image removed successfully');
                    } else {
                        alert('Failed to remove image');
                    }
                }
            });
        }
    });

    // Similar functionality for other image removal buttons
    $('#remove-image1').click(function() {
        if (confirm("Are you sure you want to remove this image?")) {
            $.ajax({
                url: "{{ route('product.removeImage', ['product' => $product->id, 'imageType' => 'image1']) }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#image1').val('');
                        $('#image1-img-tag').attr('src', '').hide();
                        $('#remove-image1').hide();
                        alert('Image 1 removed successfully');
                    } else {
                        alert('Failed to remove Image 1');
                    }
                }
            });
        }
    });

    $('#remove-image2').click(function() {
        if (confirm("Are you sure you want to remove this image?")) {
            $.ajax({
                url: "{{ route('product.removeImage', ['product' => $product->id, 'imageType' => 'image2']) }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#image2').val('');
                        $('#image2-img-tag').attr('src', '').hide();
                        $('#remove-image2').hide();
                        alert('Image 2 removed successfully');
                    } else {
                        alert('Failed to remove Image 2');
                    }
                }
            });
        }
    });

    $('#remove-image3').click(function() {
        if (confirm("Are you sure you want to remove this image?")) {
            $.ajax({
                url: "{{ route('product.removeImage', ['product' => $product->id, 'imageType' => 'image3']) }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#image3').val('');
                        $('#image3-img-tag').attr('src', '').hide();
                        $('#remove-image3').hide();
                        alert('Image 3 removed successfully');
                    } else {
                        alert('Failed to remove Image 3');
                    }
                }
            });
        }
    });

    $('#remove-image4').click(function() {
        if (confirm("Are you sure you want to remove this image?")) {
            $.ajax({
                url: "{{ route('product.removeImage', ['product' => $product->id, 'imageType' => 'image4']) }}",
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#image4').val('');
                        $('#image4-img-tag').attr('src', '').hide();
                        $('#remove-image4').hide();
                        alert('Image 4 removed successfully');
                    } else {
                        alert('Failed to remove Image 4');
                    }
                }
            });
        }
    });
});


</script>

@stop
