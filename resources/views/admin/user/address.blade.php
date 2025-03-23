@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1>Addresses</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i>
                                &nbsp;&nbsp;Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
                        <li class="breadcrumb-item active">Addresses</li>
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
                        {{-- <div class="row mb-7 mt-3 mr-3">
                                    <div class="col-sm-10">
                                        <h1></h1>
                                    </div>
                                    <div class="col-sm-2 text-end">
                                        <a href="{{route('admin.unit.create')}}" class="btn btn-block
                        btn-primary">Add</a>
                    </div>
                </div>
                <hr> --}}

                <div class="card-body">
                    <table class="table table-bordered" id="addressesTable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $key => $address)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$address->lat}}</td>
                                <td>{{$address->long}}</td>
                                <td>{{$address->street_address}}</td>
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
    $('#addressesTable').DataTable();
});
</script>
@stop