@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Add Promotional Banner</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Add Promotional Banner</li>
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
                            <form action={{route('offerBanner.store')}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required  value="{{old('name')}}" value="{{old('name')}}" placeholder="Enter Name">

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
                                                            id="image" name="image" accept="image/*" required>
                                                        <label class="custom-file-label" for="image">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">The image should be 1 mb in size.</small>

                                                @error('image')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <img src="" id="profile-img-tag" width="192px" height="192px" class="mt-2" style="display:none;" /> <br>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" required  value="{{old('start_date')}}" value="{{old('start_date')}}" placeholder="Enter Start Date">

                                                @error('start_date')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="end_date">End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" required  value="{{old('end_date')}}" value="{{old('end_date')}}" placeholder="Enter End Date">

                                                @error('end_date')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="product_ids">Products <span class="text-danger">*</span></label>
                                                <select name="product_ids[]" multiple class="form-control">
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('product_ids')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
