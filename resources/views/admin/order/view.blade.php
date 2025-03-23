@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>View Order</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i>
                                    &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">View Order</li>
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
                                <div class="col-sm-9">
                                    <h1></h1>
                                </div>
                                <?php 
                                    $totalAmount = 0;
                                    foreach($products as $product){
                                        $totalAmount += $product->amount; 
                                    }
                                ?>
                                <div class="col-sm-3 text-end">
                                    Order No: {{$products[0]->orderId}}<br>
                                    Order Date: {{$products[0]->created_at->format('d/m/Y')}}<br>
                                    Total Amount: {{$totalAmount}} rs<br>
                                    Delivery Charge: {{$products[0]->delivery_charge}} rs<br>
                                    Final Amount: {{$totalAmount + $products[0]->delivery_charge}} rs<br>
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <table class="table table-bordered" id="orderTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Product</th>
                                            <th>Price (INR)</th>
                                            <th>Quantity</th>
                                            <th>Total Amount (INR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->amount }}</td>
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
    $(document).ready(function() {
        $('#orderTable').DataTable();
        $('.select2').select2();
    });

</script>

@stop
