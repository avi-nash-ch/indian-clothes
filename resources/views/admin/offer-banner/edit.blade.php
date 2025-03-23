@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Edit Promotional Banner</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Edit Promotional Banner</li>
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
                            <form action={{route('offerBanner.update', encrypt($offerBanner->id))}} method="POST" enctype="multipart/form-data">
                            @csrf

                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required  value="{{old('name', $offerBanner->name)}}" value="{{old('name')}}" placeholder="Enter Name">

                                                @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="image">Image <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
                                                            id="image" name="image" accept="image/*" >
                                                        <label class="custom-file-label" for="image">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>

                                                <img src="{{getImageUrl($offerBanner->image)}}" id="profile-img-tag"  width="192px" height="192px" class="mt-2"><br>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" required value="{{old('start_date', $offerBanner->start_date)}}" placeholder="Enter Start Date">

                                                @error('start_date')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="end_date">End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" required  value="{{old('end_date', $offerBanner->end_date)}}" placeholder="Enter End Date">

                                                @error('end_date')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="product_ids">Products:</label>
                                                <select name="product_ids[]" multiple class="form-control" id="product_ids">
                                                    <!-- Add options dynamically using Blade -->
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('offerBanner.index')}}" class="btn btn-primary">Return</a>

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
<script>
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
</script>
<script>
    $(document).ready(function() {
        // Initialize select2 plugin
        $('select[name="product_ids[]"]').select2({
            placeholder: 'Select products', // Placeholder text
            allowClear: true, // Option to clear selection
            closeOnSelect: false // Option to keep dropdown open after selection
        });
    });
</script>



@stop
