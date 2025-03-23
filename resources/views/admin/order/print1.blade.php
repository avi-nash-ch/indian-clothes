<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{asset('images/logo.png')}}" alt="logo" style="width:145px; height:100px">
                            </div>
                            <div class="col-8">
                                <span class="float-left" style="text-transform: uppercase"><strong>Indian Clothes</strong></span><br>
                                A/312, Shiv Chamber, Near MTNL, Sector-11, CBD Belapur, Navi Mumbai - 400614<br>
                                Contact Number: +91 8879835066 | Email: support@pioneerfacility.com

                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <address>
                                    <strong></strong><br>
                                    {{$products[0]->house_address}} ,{{$products[0]->street_address}}<br>
                                    {{$products[0]->locality}}<br>
                                    @if($products[0]->landmark != '')
                                    {{$products[0]->landmark}}<br>
                                    @endif 
                                    {{$products[0]->pincode}}<br>
                                    Mobile:- {{$products[0]->mobile}}
                                </address>
                            </div>
                            <div class="col-4 text-left">
                                <address>
                                    <!-- CIN: U01100MH2019PLC327505<br>
                                    GSTIN: 27AAHCK7023K1ZB<br> -->
                                    <br>
                                    Order No: {{$products[0]->order_id }}<br>
                                    Invoice Date: {{$products[0]->created_at->format('d/m/Y') }} <br>
                                </address>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>

                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td><strong>#</strong></td>
                                                <td><strong>Item</strong></td>
                                                <td class="text-center"><strong>Price</strong></td>
                                                <td class="text-center"><strong>Quantity</strong>
                                                </td>
                                                <td class="text-right"><strong>Totals</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            foreach ($products as $key => $value) {
                                                $total += ($value->price * $value->quantity);
                                            }
                                            ?>
                                            @foreach ($products as $key => $product)
                                            <tr>
                                                <td>{{$key + 1 }}</td>
                                                <td>{{$product->product_name }}</td>
                                                <td class="text-center">{{$product->price}}</td>
                                                <td class="text-center">{{$product->quantity}}</td>
                                                <td class="text-right">{{($product->price * $product->quantity)}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Subtotal</strong>
                                                </td>
                                                <td class="thick-line text-right">{{$total }}</td>
                                            </tr>

                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Delivery Charges</strong>
                                                </td>
                                                <td class="thick-line text-right">{{$product->delivery_charge }}</td>
                                            </tr>

                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total</strong>
                                                </td>
                                                <td class="no-line text-right">
                                                    <h4 class="m-0">{{$total + $product->delivery_charge }}</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Mode of Payment</strong>
                                                </td>
                                                <td class="no-line text-right">
                                                    @if($products[0]->payment_type == 0)
                                                    <h4 class="m-0">COD</h4>
                                                    @else
                                                    <h4 class="m-0">Online</h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-print-none">
                                <div class="float-right">
                                    <a href="javascript:void(0);" onclick="document.title = 'Invoice_for_Order_id_{{$products[0]->order_id}}'; window.print();" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                </div>
                            </div>

                            <!-- <button id="printButton">Print or Save PDF</button> -->

                        </div>
                    </div>

                </div>
            </div> <!-- end row -->

        </div>
    </div>
    <br>
    * Prices are inclusive of All Taxes.<br>THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE.
</div> <!-- end col -->
</div>