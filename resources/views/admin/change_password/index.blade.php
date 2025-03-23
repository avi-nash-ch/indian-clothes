@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1>Change Password</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">

                    <div class="card card-primary card-outline">
                        <form method="post" action="{{ route('postChangePassword') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="new_password"> Change Password <span class="text-danger">*</span></label>
                                            <input type="password" id="new_password" class="form-control" name="new_password" required placeholder="Change Password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-primary">Return</a>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
@endsection