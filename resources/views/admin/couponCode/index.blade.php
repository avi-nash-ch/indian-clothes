@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Coupon Codes</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Coupon Codes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-primary card-outline" style="overflow-x: auto;">
                            <div class="row mb-7 mt-3 mr-3">
                                <div class="col-sm-10">
                                    <h1></h1>
                                </div>
                                <div class="col-sm-2 text-end">
                                    <a href="{{route('couponCode.create')}}" class="btn btn-block btn-primary">Add</a>
                                </div>
                            </div>
                            <hr>

                            <div class="card-body">
                                <table class="table table-bordered" id="couponCodeTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Coupon Code</th>
                                            <th>Offer (%)</th>
                                            <th>Minimum Amount (INR)</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th style="width: 100px" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($couponCodes as $key => $couponCode)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$couponCode->coupon_code}}</td>
                                            <td>{{$couponCode->offer}}</td>
                                            <td>{{$couponCode->minimum_amount}}</td>
                                            <td>{{$couponCode->start_date}}</td>
                                            <td>{{$couponCode->end_date}}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ url('admin/couponCode/'.encrypt($couponCode->id).'/edit') }}" class="mr-3"><i class="fa fa-edit bts-popup-close mt-2"></i></a>

                                                    <a href="#" onclick="confirmDelete('{{ encrypt($couponCode->id) }}')"><i class="fa fa-times bts-popup-close mt-2"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection
@section('scripts')
<script>
    function confirmDelete(id) {
        var result = window.confirm("Are you sure you want to delete?");
        if (result) {
            // If the user clicks OK in the confirmation dialog, redirect to the delete URL
            window.location.href = "{{ url('admin/couponCode/') }}/" + id + "/delete";
        } else {
            // If the user clicks Cancel, do nothing
        }
    }
    $(document).ready( function () {
        $('#couponCodeTable').DataTable();
    });
</script>
@stop
