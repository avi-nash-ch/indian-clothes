@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Edit Coupon Code</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Edit Coupon Code</li>
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
                            <form action={{route('couponCode.update', encrypt($couponCode->id))}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="coupon_code">Coupon Code <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="coupon_code" name="coupon_code" required value="{{old('coupon_code', $couponCode->coupon_code)}}" placeholder="Enter Coupon Code">

                                                @error('coupon_code')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="offer">Offer (%) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control uppercase-text" id="offer" name="offer" required value="{{old('offer', $couponCode->offer)}}" placeholder="Enter Offer in (%)">

                                                @error('offer')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="minimum_amount">Minimum Amount (INR) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="minimum_amount" name="minimum_amount" required value="{{old('minimum_amount', $couponCode->minimum_amount)}}" placeholder="Enter Minimum Amount">

                                                @error('minimum_amount')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="maximum_user">Maximum Users <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="maximum_user" name="maximum_user" required value="{{old('maximum_user', $couponCode->maximum_user)}}" placeholder="Enter Maximum Users">

                                                @error('maximum_user')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control uppercase-text" id="start_date" name="start_date" required value="{{old('start_date', $couponCode->start_date)}}" placeholder="Enter Start Date">

                                                @error('start_date')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="end_date">End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control uppercase-text" id="end_date" name="end_date" required value="{{old('end_date', $couponCode->end_date)}}" placeholder="Enter End Date">

                                                @error('end_date')
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
                                    <a href="{{route('couponCode.index')}}" class="btn btn-primary">Return</a>

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
    
    $("#minimum_amount").keypress(function(event) {
        var character = String.fromCharCode(event.keyCode);
        return isValids(character);     
    });

    function isValids(str) {
        return !/[~`!@#$%\^&*()s=\-\[\]\\abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';,/{}|\\":<>\?]/g.test(str);
    }
</script>

@stop
