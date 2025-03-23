@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Payment History</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Payment History</li>
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
                                <table class="table table-bordered" id="offerBannerTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Delivery Boy Name</th>
                                            <th>Amount (INR)</th>
                                            <th>Description</th>
                                            <th>Added Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentHistories as $key => $paymentHistory)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$paymentHistory->name}}</td>
                                            <td>{{$paymentHistory->amount}}</td>
                                            <td>{{strip_tags($paymentHistory->description)}}</td>
                                            <td>{{$paymentHistory->created_at->format('d/m/Y')}}</td>
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
        $('#offerBannerTable').DataTable();
    });

</script>
@stop

