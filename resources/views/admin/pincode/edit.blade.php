@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1>Edit Pincode</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                        <li class="breadcrumb-item active">Edit Pincode</li>
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
                        <form action={{route('pincode.update', encrypt($pincode->id))}} method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="pincode">Pincode <span class="text-danger">*</span></label>
                                            <!-- <input type="text" class="form-control" id="pincode" name="pincode" required value="{{old('pincode', $pincode->pincode)}}" value="{{old('Pincode')}}" placeholder="Enter Pincode"> -->

                                            <input type="number" class="form-control" id="pincode" name="pincode" required value="{{ old('pincode', $pincode->pincode) }}" value="{{old('Pincode')}}" placeholder="Enter Pincode" min="100000" max="999999" oninput="this.value = this.value.slice(0, 6)">

                                            @error('pincode')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('pincode.index')}}" class="btn btn-primary">Return</a>

                                </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection

