@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Add Delivery Boy</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Add Delivery Boy</li>
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
                            <form action={{route('delivery-boy-management.store')}} method="POST" enctype="multipart/form-data">
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
                                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" required value="{{ old('mobile') }}" placeholder="Enter Mobile Number" minlength="10" maxlength="10">

                                                @error('mobile')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="password">password <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="password" name="password" required value="{{ old('password') }}" placeholder="Enter Password">
                                                @error('password')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="address">Address </label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Enter Address">

                                                @error('address')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="adhar_no">Aadhar Number</label>
                                                <input type="text" class="form-control" id="adhar_no" name="adhar_no" value="{{ old('adhar_no') }}" placeholder="Enter Aadhar" minlength="12" maxlength="12">

                                                @error('adhar_no')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="license_no">License Number</label>
                                                <input type="text" class="form-control" id="license_no" name="license_no"
                                                    value="{{ old('license_no') }}" placeholder="Enter License Number" 
                                                    maxlength="12" pattern="^[a-zA-Z0-9]{12}$" title="License number must be exactly 12 alphanumeric characters.">

                                                @error('license_no')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="pan_no">PAN Card Number </label>
                                                <input type="text" class="form-control" id="pan_no" name="pan_no"
                                                    value="{{ old('pan_no') }}" placeholder="Enter PAN Card Number"
                                                    maxlength="10" pattern="^[A-Z]{5}[0-9]{4}[A-Z]{1}$" title="PAN number must be in the format AAAAA9999A.">

                                                @error('pan_no')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="wallet">Wallet (INR) </label>
                                                <input type="text" class="form-control" id="wallet" name="wallet" value="{{ old('wallet') }}" placeholder="Enter Wallet">

                                                @error('wallet')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="vehicle_no">Vehicle Number</label>
                                                <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="{{ old('vehicle_no') }}" placeholder="Enter Vehicle No.">

                                                @error('vehicle_no')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="vehicle_desc">Vehicle Description</label>
                                                <input type="text" class="form-control" id="vehicle_desc" name="vehicle_desc" value="{{ old('vehicle_desc') }}" placeholder="Enter Vehicle Description">

                                                @error('vehicle_desc')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="delivery_charge">Delivery Charge (INR) </label>
                                                <input type="text" class="form-control" id="delivery_charge" name="delivery_charge" value="{{ old('delivery_charge') }}" placeholder="Enter Delivery Charge">

                                                @error('delivery_charge')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="image">Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
                                                            id="image" name="image" accept="image/*">
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



                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{route('delivery-boy-management.index')}}" class="btn btn-primary">Return</a>
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

    $("#adhar_no, #mobile").keypress(function(event) {
        var character = String.fromCharCode(event.keyCode);
        return isValids(character);
    });

    function isValids(str) {
        return !/[~`!@#$%\^&*()s=\-\[\]\\abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';,/{}|\\":<>\?]/g.test(str);
    }
</script>

@stop
