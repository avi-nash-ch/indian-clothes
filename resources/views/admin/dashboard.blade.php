@extends('admin.layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                    <p>Welcome To Indian Clothes</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary"> <!-- Total Users -->
                        <div class="inner">
                            <h3>{{$users}}</h3>
                            <p>Total Users</p>
                        </div>
                        <a href="{{url('admin/user')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning"> <!-- Pending Orders -->
                        <div class="inner">
                            <h3>{{$pendingOrders}}</h3>
                            <p>Pending Orders</p>
                        </div>
                        <a href="{{url('admin/report_order?status=0')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info"> <!-- In Progress Orders -->
                        <div class="inner">
                            <h3>{{$inprogressOrders}}</h3>
                            <p>In Progress Orders</p>
                        </div>
                        <a href="{{url('admin/report_order?status=1')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success"> <!-- Dispatched Orders -->
                        <div class="inner">
                            <h3>{{$dispatchedOrders}}</h3>
                            <p>Dispatched Orders</p>
                        </div>
                        <a href="{{url('admin/report_order?status=2')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger"> <!-- Cancel Orders -->
                        <div class="inner">
                            <h3>{{$cancelOrders}}</h3>
                            <p>Cancel Orders</p>
                        </div>
                        <a href="{{url('admin/report_order?status=4')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary"> <!-- Refunded Amount -->
                        <div class="inner">
                            <h3>{{$refundOrders}} rs</h3>
                            <p>Refunded Amount</p>
                        </div>
                        <a href="{{url('admin/report_order?status=5')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark"> <!-- Current Month Sales -->
                        <div class="inner">
                            <h3>{{$currentMonthSales}} rs</h3>
                            <p>Current Month Sales</p>
                        </div>
                        <a href="#" class="small-box-footer" style="visibility: hidden;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-lightblue"> <!-- Current Year Sales -->
                        <div class="inner">
                            <h3>{{$currentYearSales}} rs</h3>
                            <p>Current Year Sales</p>
                        </div>
                        <a href="#" class="small-box-footer" style="visibility: hidden;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-teal"> <!-- Total COD Orders -->
                        <div class="inner">
                            <h3>{{$todayCODSales}} rs</h3>
                            <p>Total COD Orders</p>
                        </div>
                        <a href="#" class="small-box-footer" style="visibility: hidden;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-purple"> <!-- Total Prepaid Orders -->
                        <div class="inner">
                            <h3>{{$todayPrepaidSales}} rs</h3>
                            <p>Total Prepaid Orders</p>
                        </div>
                        <a href="#" class="small-box-footer" style="visibility: hidden;">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-olive"> <!-- Today Order Delivered -->
                        <div class="inner">
                            <h3>{{$todayOrderDelivered}}</h3>
                            <p>Today Order Delivered</p>
                        </div>
                        <a href="{{route('order.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.carousel').carousel({
        interval: 500
    })
});
</script>
@stop