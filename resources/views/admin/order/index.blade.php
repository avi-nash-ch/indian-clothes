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
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="nav-icon fa fa-dashboard"></i>
                                &nbsp;&nbsp;Home</a></li>
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

                        <form action="{{ route('order.index') }}" method="GET">
                            @csrf
                            <div class="row ml-3 mt-3 mb-4" style="align-items: center;">

                                <!-- status -->
                                <div class="col-md-4">
                                    <label for="status">Order Status</label>
                                    <select id="status" name="status"
                                        class="js-example-basic-multiple form-control select2">
                                        <option value="">Select Status</option>
                                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>In Process</option>
                                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>Dispatched</option>
                                        <option value="3" {{ $status == 3 ? 'selected' : '' }}>Delivered</option>
                                        <option value="4" {{ $status == 4 ? 'selected' : '' }}>Cancel</option>
                                        <option value="5" {{ $status == 5 ? 'selected' : '' }}>Refund</option>
                                        <option value="6" {{ $status == 6 ? 'selected' : '' }}>Door Locked</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2 mt-2">
                                    <label for="status">Payment Method</label>
                                    <select id="payment_status" name="payment_status"
                                        class="js-example-basic-multiple form-control select2">
                                        <option value="">Select Status</option>
                                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>COD</option>
                                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-2 mt-2">
                                    <label for="">From :</label>
                                    <input type="date" id="fromDate" name="from_date" value="{{ request()->from_date }}"
                                        class="form-control" placeholder="From Date">
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <label for="">To :</label>
                                    <input type="date" id="toDate" name="to_date" value="{{ request()->to_date }}"
                                        class="form-control" placeholder="To Date">
                                </div>
                                <div class="col-sm-2 text-end" style="margin-top: 40px">
                                    <button type="submit" id="filterOrder" class="btn btn-primary">Filter</button>
                                    <a href="{{route('order.index')}}" class="btn btn-secondary">Reset</a>
                                </div>


                                <div class="col-md-2 mt-3 ">
                                    <button type="submit" style="margin-top: 15px;"
                                        class="btn btn-primary custom-btn custom-btn-submit ml-2"
                                        id="form_submit_btn">Search</button>
                                    <a href="{{route('order.index')}}" class="btn btn-secondary mt-3">Reset</a>

                                </div>
                            </div>
                        </form>

                        <div class="card-body">
                            <table class="table table-bordered" id="orderTable">
                                @if($status == 4 || $status == 5)
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Sr. No.</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Order Id</th>
                                        <th>Amount (INR)</th>
                                        <th>Delivery Charge (INR)</th>
                                        <th>Reason</th>
                                        <th data-sortable="false">Action</th>
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
                                        @if($status == 4 )
                                        <td>{{ $order->reason }}</td>
                                        @elseif($status == 5)
                                        <td>{{ $order->refund_reason }}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td>
                                            <div>
                                                <a href="{{ url('admin/order/'.encrypt($order->id).'/view') }}"
                                                    class="mr-3"><i class="fa fa-eye bts-popup-close mt-2"></i></a>

                                                <a href="#" onclick="confirmDelete('{{ encrypt($order->id) }}')"><i
                                                        class="fa fa-times bts-popup-close mt-2"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @elseif($status == 3)
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Sr. No.</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Order Id</th>
                                        <th>Amount (INR)</th>
                                        <th>Delivery Charge (INR)</th>
                                        <th>Status</th>
                                        <th>Delivery Boy</th>
                                        <th>Refund and Cancellation</th>
                                        <th>Address</th>
                                        <th style="width: 130px" data-sortable="false">Action</th>
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
                                        @if($order->status == 4 || $order->status == 3)
                                        <td style="pointer-events: none; opacity: 0.5;">
                                            @else
                                        <td>
                                            @endif
                                            <div style="width: 120px">
                                                <select class="form-control  status-dropdown select2"
                                                    data-order-id="{{ $order->id }}">
                                                    <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>In
                                                        Process
                                                    </option>
                                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>
                                                        Dispatched
                                                    </option>
                                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>
                                                        Delivered
                                                    </option>
                                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Cancel
                                                    </option>
                                                </select>
                                            </div>
                                        </td>

                                        @if($order->status == 4 || $order->status == 3)
                                        <td style="pointer-events: none; opacity: 0.5;">
                                            @else
                                        <td>
                                            @endif
                                            <div style="width: 170px">
                                                <select class="form-control deliveryboy-dropdown select2"
                                                    data-order-id="{{$order->id}}">
                                                    <option value="">Select Delivery Boy</option>
                                                    @foreach($deliveryboys as $deliveryboy)
                                                    <option value="{{ $deliveryboy->id }}"
                                                        {{ $order->delivery_boy_id == $deliveryboy->id ? 'selected' : '' }}>
                                                        {{ $deliveryboy->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>

                                        <td>
                                            <div style="width: 120px">
                                                <select class="form-control refund-dropdown select2"
                                                    data-order-id="{{$order->id}}">
                                                    <option>Refund</option>
                                                    <option>Refund</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td>{{ $order->house_address }}, {{ $order->street_address }},
                                            {{ $order->locality}}, @if($order->landmark != null){{ $order->landmark}},
                                            @endif{{ $order->pincode}}</td>
                                        <td>
                                            <div>

                                                <a href="{{ url('admin/order/'.encrypt($order->id).'/print') }}"
                                                    class="mr-3"><i class="fa fa-print bts-popup-close mt-2"></i></a>

                                                <a href="{{ url('admin/order/'.encrypt($order->id).'/view') }}"
                                                    class="mr-3"><i class="fa fa-eye bts-popup-close mt-2"></i></a>

                                                <a href="#" onclick="confirmDelete('{{ encrypt($order->id) }}')"><i
                                                        class="fa fa-times bts-popup-close mt-2"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @else
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Sr. No.</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Order Id</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Status</th>
                                        <th>Amount (INR)</th>
                                        <th>Delivery Charge (INR)</th>
                                        <th>Comment</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Delivery Boy</th>
                                        <th>Address</th>
                                        <th style="width: 130px" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->mobile }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @if($order->payment_type == 0)
                                            Cash On Delivery
                                            @elseif($order->payment_type == 1)
                                            Online
                                            @else
                                            Unknown Payment Type
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->payment_type == 0) 
                                                @if($order->payment_status == 0)
                                                    COD
                                                @elseif($order->payment_status == 1)
                                                    COD
                                                @else
                                                    COD
                                                @endif
                                            @else
                                                @if($order->payment_status == 0)
                                                    Pending
                                                @elseif($order->payment_status == 1)
                                                    Success
                                                @else
                                                    Failure
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>{{ $order->delivery_charge }}</td>
                                        <td>{{ $order->reason }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        @if($order->status == 4 || $order->status == 3 || $order->status == 6)
                                        <td style="pointer-events: none; opacity: 0.5;">
                                            @else
                                        <td>
                                            @endif
                                            <div style="width: 120px">
                                                <select class="form-control  status-dropdown select2"
                                                    data-order-id="{{ $order->id }}">
                                                    <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>In
                                                        Process
                                                    </option>
                                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>
                                                        Dispatched
                                                    </option>
                                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>
                                                        Delivered
                                                    </option>
                                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>
                                                        {{ $order->refund_reason == null ? 'Cancel' : 'Refund' }}
                                                    </option>
                                                    <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>
                                                    Door Locked
                                                    </option>
                                                </select>
                                            </div>
                                        </td>

                                        @if($order->status == 4 || $order->status == 3 || $order->status == 6)
                                        <td style="pointer-events: none; opacity: 0.5;">
                                            @else
                                        <td>
                                            @endif
                                            <div style="width: 170px">
                                                <select class="form-control deliveryboy-dropdown select2"
                                                    data-order-id="{{$order->id}}">
                                                    <option value="">Select Delivery Boy</option>
                                                    @foreach($deliveryboys as $deliveryboy)
                                                    <option value="{{ $deliveryboy->id }}"
                                                        {{ $order->delivery_boy_id == $deliveryboy->id ? 'selected' : '' }}>
                                                        {{ $deliveryboy->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>{{ $order->house_address }}, {{ $order->street_address }},
                                            {{ $order->locality}}, @if($order->landmark != null){{ $order->landmark}},
                                            @endif{{ $order->pincode}}</td>
                                        <td>
                                            <div>

                                                <a href="#" class="mr-3 comment-link" data-id="{{ $order->id }}"
                                                    data-toggle="modal" data-target="#commentModal">
                                                    <i class="fa fa-comment bts-popup-close mt-2"></i>
                                                </a>

                                                <a href="{{ url('admin/order/'.encrypt($order->id).'/print') }}"
                                                    class="mr-3"><i class="fa fa-print bts-popup-close mt-2"></i></a>

                                                <a href="{{ url('admin/order/'.encrypt($order->id).'/view') }}"
                                                    class="mr-3"><i class="fa fa-eye bts-popup-close mt-2"></i></a>

                                                <a href="#" onclick="confirmDelete('{{ encrypt($order->id) }}')"><i
                                                        class="fa fa-times bts-popup-close mt-2"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="commentForm">
                <div class="modal-body">
                    <textarea class="form-control" id="commentText" rows="4"
                        placeholder="Enter your comment"></textarea>
                    <input type="hidden" id="orderId" value=""> <!-- ID will be dynamically set -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="assignDeliveryBoyModal" tabindex="-1" role="dialog"
    aria-labelledby="assignDeliveryBoyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignDeliveryBoyModalLabel">Confirm Delivery Boy Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to assign <span id="deliveryBoyName"></span> as the delivery boy?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAssignBtn">Assign</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div class="modal" id="refundModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refund Confirmation</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="refundReason" rows="3"
                    placeholder="Enter refund reason..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="refundCancelBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmRefundBtn">Confirm Refund</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
function confirmDelete(id) {
    var result = window.confirm("Are you sure you want to delete?");
    if (result) {

        window.location.href = "{{ url('admin/order/') }}/" + id + "/delete";
    } else {

    }
}

$(document).ready(function() {
    $('#orderTable').DataTable();
});

$(document).ready(function(){
    $('.select2').select2();
});

$('.status-dropdown').change(function() {
    var orderId = $(this).data('order-id');
    var status = $(this).val();

    $.ajax({
        url: '/admin/update-order-status',
        type: 'GET',
        data: {
            orderId: orderId,
            status: status
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });

});

$('.deliveryboy-dropdown').change(function() {
    var deliveryBoyName = $(this).find('option:selected').text();
    deliveryBoyId = $(this).val();
    orderId = $(this).data('order-id');


    $('#deliveryBoyName').text(deliveryBoyName);
    $('#assignDeliveryBoyModal').modal('show');
});


$('#confirmAssignBtn').click(function() {

    // var orderId = $(".deliveryboy-dropdown").data('order-id');
    $.ajax({
        url: '/admin/get-delivery-boys',
        type: 'post',
        data: {
            delivery_boy_id: deliveryBoyId,
            orderId
        },
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        success: function(response) {

        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });
    $('#assignDeliveryBoyModal').modal('hide');
});

$('#cancelBtn').click(function() {
    $('#assignDeliveryBoyModal').modal('hide');
});

$('#refundCancelBtn').click(function() {
    $('#refundModal').modal('hide');
});

$('.refund-dropdown').change(function() {
    orderId = $(this).data('order-id');
    $('#refundModal').modal('show');
});

$('#confirmRefundBtn').click(function() {
    var refundReason = $('#refundReason').val();
    $.ajax({
        url: '/admin/order/refund',
        method: 'POST',
        data: {
            reason: refundReason,
            orderId
        },
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        success: function(response) {

            $('#refundModal').modal('hide');
            location.reload();

        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error(error);
        }
    });
});

$(document).on('click', '.comment-link', function() {
    var orderId = $(this).data('id'); // Get the order ID from the clicked element
    $('#orderId').val(orderId); // Set the order ID in the hidden input field
});


$('#commentForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    var orderId = $('#orderId').val(); // Get the plain order ID
    var comment = $('#commentText').val(); // Get the comment

    $.ajax({
        url: '{{ route("order.comment") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Include CSRF token
            order_id: orderId, // Send the order ID directly
            comment: comment // Send the comment text
        },
        success: function(response) {
            if (response.success) {
                $('#commentModal').modal('hide'); // Hide the modal
                $('#commentText').val(''); // Optionally reset the comment field
                location.reload(); // Reload the page on success
            } else {
                alert('Failed to add comment: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
        }
    });
});
</script>

@stop