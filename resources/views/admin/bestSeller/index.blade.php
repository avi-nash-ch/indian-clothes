@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Best Sellers</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Best Sellers</li>
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
                                    <a href="{{route('bestSeller.create')}}" class="btn btn-block btn-primary">Add</a>
                                </div>
                            </div>
                            <hr>

                            <div class="card-body">
                                <table class="table table-bordered" id="bestSellerTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Product</th>
                                            <th style="width: 100px" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bestSellers as $key => $bestSeller)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$bestSeller->name}}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ url('admin/bestSeller/'.encrypt($bestSeller->id).'/edit') }}" class="mr-3"><i class="fa fa-edit bts-popup-close mt-2"></i></a>

                                                    <a href="#" onclick="confirmDelete('{{ encrypt($bestSeller->id) }}')"><i class="fa fa-times bts-popup-close mt-2"></i></a>
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
            window.location.href = "{{ url('admin/bestSeller/') }}/" + id + "/delete";
        } else {
            // If the user clicks Cancel, do nothing
        }
    }
    $(document).ready( function () {
        $('#bestSellerTable').DataTable();
    });
</script>
@stop
