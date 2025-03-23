@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('delivery-boy-management.index')}}">Delivery Boy</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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

                            <div class="card-body">
                                <table class="table table-bordered" id="orderTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>User Name</th>
                                            <th>Mobile</th>
                                            <th>Order Id</th>
                                            <th>Amount (INR)</th>
                                            <th>Delivery Charge (INR)</th>
                                            <th>Address</th>
                                            <th style="width: 100px" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->mobile }}</td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->total_amount }}</td>
                                                <td>{{ $order->delivery_charge }}</td>
                                                <td>{{ $order->house_address }}, {{ $order->street_address }}, {{ $order->locality}}, @if($order->landmark != null){{ $order->landmark}}, @endif{{ $order->pincode}}</td>

                                                <td>
                                                    <div>

                                                        @if($order->status == 3)
                                                            <a href="{{ url('admin/order/'.encrypt($order->id).'/print') }}" class="mr-3"><i class="fa fa-print bts-popup-close mt-2"></i></a>
                                                        @endif

                                                        <a href="{{ url('admin/order/'.encrypt($order->id).'/view') }}" class="mr-3"><i class="fa fa-eye bts-popup-close mt-2"></i></a>

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
    $(document).ready( function () {
        $('#orderTable').DataTable();
    });
</script>
@stop

