@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Delivery Boy Management</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Delivery Boy Managment</li>
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
                            {{-- <div class="card-header">
                                <h3 class="card-title">Bordered Table</h3>
                            </div> --}}
                            <div class="row mb-7 mt-3 mr-3">
                                <div class="col-sm-10">
                                    <h1></h1>
                                </div>
                                <div class="col-sm-2 text-end">
                                    <a href="{{route('delivery-boy-management.create')}}" class="btn btn-block btn-primary">Add</a>
                                </div>
                            </div>
                            <hr>

                            <div class="card-body">
                                <table class="table table-bordered" id="offerBannerTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>Aadhar No</th>
                                            <!-- <th>License No</th>
                                            <th>Pan No</th>
                                            <th>Vehicle No</th>
                                            <th>Vehicle Desc</th> -->
                                            <!-- <th>Wallet</th>
                                            <th>Delivery Charge</th> -->
                                            <th>Image</th>
                                            <th style="width: 150px" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deliveryboymanagements as $key => $deliveryboymanagement)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$deliveryboymanagement->name}}</td>
                                            <td>{{$deliveryboymanagement->mobile}}</td>
                                            <td>{{$deliveryboymanagement->address}}</td>
                                            <td>{{$deliveryboymanagement->adhar_no}}</td>
                                            <!-- <td>{{$deliveryboymanagement->license_no}}</td>
                                            <td>{{$deliveryboymanagement->pan_no}}</td>
                                            <td>{{$deliveryboymanagement->vehicle_no}}</td>
                                            <td>{{$deliveryboymanagement->vehicle_desc}}</td> -->
                                            <!-- <td>{{$deliveryboymanagement->wallet}}</td>
                                            <td>{{$deliveryboymanagement->delivery_charge}}</td> -->

                                            <td>
                                                <img src="{{getImageUrl($deliveryboymanagement->image)}}" width="192px" height="192px"/>
                                            </td>

                                            <td>
                                                <div>
                                                    <a href="{{ url('/admin/delivery-boy-management/'.encrypt($deliveryboymanagement->id).'/edit') }}" class="mr-3" title="Edit"><i class="fa fa-edit bts-popup-close mt-2"></i></a>

                                                    <a href="#" onclick="confirmDelete('{{ encrypt($deliveryboymanagement->id) }}')" class="mr-3"><i class="fa fa-times bts-popup-close mt-2"></i></a>

                                                    <a href="{{ url('/admin/delivery-boy-management/'.encrypt($deliveryboymanagement->id).'/payment') }}" class="mr-3" title="Payment"><i class="fa fa-plus bts-popup-close mt-2"></i></a>

                                                    <a href="{{ url('/admin/delivery-boy-management/'.encrypt($deliveryboymanagement->id).'/paymentHistory') }}" class="mr-3" title="Payment History"><i class="fa fa-list bts-popup-close mt-2"></i></a>

                                                    <a href="{{ url('/admin/delivery-boy-management/'.encrypt($deliveryboymanagement->id).'/orders') }}" class="mr-3" title="Orders"><i class="fa fa-list-alt bts-popup-close mt-2"></i></a>

                                                    <a href="{{ url('/admin/delivery-boy-management/'.encrypt($deliveryboymanagement->id).'/view') }}" class="mr-3" title="View Details"><i class="fa fa-eye bts-popup-close mt-2"></i></a>
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
            window.location.href = "{{ url('admin/delivery-boy-management/') }}/" + id + "/delete";
        } else {
            // If the user clicks Cancel, do nothing
        }
    }
    $(document).ready( function () {
        $('#offerBannerTable').DataTable();
    });
</script>
@stop

