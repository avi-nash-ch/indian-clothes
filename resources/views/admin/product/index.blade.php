@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
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
                            <div  class="row ml-3 mt-3 mb-4" style="align-items: center;">
                                <div class="col-sm-10">
                                    <form action="{{ route('product.index') }}" method="GET">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">Stock :</label>
                                                <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity" value="{{ request('quantity') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Expiry Date :</label>
                                                <input type="date" name="expiry_date" class="form-control" value="{{ request('expiry_date') }}">
                                            </div>
                                            <div class="col-md-4" style="margin-top:32px;">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                                <a href="{{route('product.index')}}" class="btn btn-secondary">Reset</a>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-2 text-end" style="margin-top:32px;">
                                    <a href="{{route('product.create')}}" class="btn btn-block btn-primary">Add</a>
                                </div>
                            </div>
                            <hr>

                            <div class="card-body">
                                <table class="table table-bordered" id="categoryTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Sub Category</th>
                                            <th>Expiry Date</th>
                                            <th style="width: 100px" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key => $product)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->category}}</td>
                                            <td>{{$product->quantity}}</td>
                                            <td>{{$product->subCategory}}</td>
                                            <td>{{$product->expiry_date}}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ url('admin/product/'.encrypt($product->id).'/edit') }}" class="mr-3"><i class="fa fa-edit bts-popup-close mt-2"></i></a>

                                                    <a href="#" onclick="confirmDelete('{{ encrypt($product->id) }}')"><i class="fa fa-times bts-popup-close mt-2"></i></a>
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
            window.location.href = "{{ url('admin/product/') }}/" + id + "/delete";
        } else {
            // If the user clicks Cancel, do nothing
        }
    }
    $(document).ready( function () {
        $('#categoryTable').DataTable();
    });
</script>
@stop
