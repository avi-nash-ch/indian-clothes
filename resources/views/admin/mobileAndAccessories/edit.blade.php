@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Edit Mobile And Accessories Product</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Edit Mobile And Accessories Product</li>
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
                            <form action={{route('mobileAndAccessories.update', encrypt($mobileAndAccessories->id))}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="product_id">Product <span class="text-danger">*</span></label>

                                                <select id="product_id" name="product_id" class="js-example-basic-multiple form-control select2" required="">
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" @if(old('product_id', $mobileAndAccessories->product_id) == $product->id) selected @endif>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('product_id')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('mobileAndAccessories.index')}}" class="btn btn-primary">Return</a>

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

    $(document).ready( function () {
        $('.select2').select2();
    });
</script>

@stop
