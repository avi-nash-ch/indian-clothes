@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1>Profile</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="card card-primary card-outline">
                        <form method="POST" action="{{ route('profile.update') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <label for="name">Name:</label>
                                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div> -->
                                        <div class="col-md-6">
                                            <label for="name"> Name <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name) }}" required placeholder="Name">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email"> Email <span class="text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" name="email" required placeholder="Email">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mt-3" >
                                            <label for="new_password">  Password <span class="text-danger">*</span></label>
                                            <input type="password" id="new_password" class="form-control" name="new_password"  placeholder=" Password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back </a>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection