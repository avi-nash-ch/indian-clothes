@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" style="min-height: 1345.31px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1>Delivery Boy Payment</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="nav-icon fa fa-dashboard"></i> &nbsp;&nbsp;Home</a></li>
                            <li class="breadcrumb-item active">Delivery Boy Payment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary card-outline">
                            <form id="paymentForm" action={{route('delivery-boy-management.addPayment', encrypt($deliveryboy->id))}} method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="wallet">Wallet (INR)</label>
                                                <input type="text" class="form-control" id="wallet" wallet="wallet" value="{{old('wallet', $deliveryboy->wallet)}}" value="{{old('wallet')}}" placeholder="Enter Wallet" disabled>

                                                @error('wallet')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="amount">Amount (INR) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="amount" name="amount" required value="{{ old('amount', $deliveryboy->amount) }}" placeholder="Enter Amount">
                                                @error('amount')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="password-vertical">Description </label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                                @error('description')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('delivery-boy-management.index')}}" class="btn btn-primary">Return</a>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('#description').forEach(function(element) {
        ClassicEditor
            .create(element)
            .catch(function(error) {
                console.error(error);
            });
    });
</script>

<script>
    $("#amount").keypress(function(event) {
        var character = String.fromCharCode(event.keyCode);
        return isValids(character);
    });

    function isValids(str) {
        return !/[~`!@#$%\^&*()s=\-\[\]\\abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+';,/{}|\\":<>\?]/g.test(str);
    }
</script>
<script>
    
</script>


@stop
