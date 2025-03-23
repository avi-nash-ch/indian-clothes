<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your HTML head content here -->
    <style>
        /* Define print styles */
        @media print {
            /* Hide header and footer */
            @page {
                margin: 0; /* Remove default margin */
                size: auto; /* Use the standard page size */
            }
            body {
                margin: 0; /* Reset body margin */
            }
            header,
            footer {
                display: none; /* Hide header and footer */
            }
        }
    </style>
</head>
<body>


<div id="invoiceholder">
    <div id="invoice" class="effect2">
        <div id="invoice-top">
            <h2>Indian Clothes</h2>
            <h5 class="jhj"> {!!$setting->address!!}</h5>
        </div>
        <hr>
        <div id="invoice-mid">
            <div class="detail">
                <b>Name</b>:- {{$products[0]->name}} <br>
                <b>Address</b>:- {{$products[0]->house_address}}, {{$products[0]->street_address}}<br>
                {{$products[0]->locality}}<br>
                @if($products[0]->landmark != '')
                    {{$products[0]->landmark}}<br>
                @endif
                {{$products[0]->pincode}}<br>
                <b>Mobile</b>:- {{$products[0]->mobile}}
            </div>

            <div class="service">
                <p><b>Order No: </b>{{$products[0]->order_id }}</p>
                <p><b>Invoice Date: </b> {{$products[0]->created_at->format('d/m/Y') }} </p>
            </div><!--End Title-->
        </div><!--End Invoice Mid-->

        <div id="invoice-bot">
            <div id="table">
                <table>
                    <?php
                        $total = 0; // To calculate the total amount for each product
                        $mrpAmount = 0; // To calculate the MRP Amount
                        $orderAmount = 0; // To calculate the Order Amount

                        foreach ($products as $key => $value) {
                            $productTotal = floatval($value->price) * intval($value->quantity); // Ensure price and quantity are numeric
                            $productMrpTotal = floatval($value->mrp) * intval($value->quantity);
                            
                            $total += $productTotal; // Sum for Total Amount
                            $orderAmount += $productTotal; // Sum for Order Amount
                            $mrpAmount += $productMrpTotal; // Sum for MRP Amount (use $productMrpTotal instead of $productTotal)
                        }
                    ?>
                    <tr class="tabletitle">
                        <td class="item" style="width: 50px;">
                            <h2>Sr. No.</h2>
                        </td>
                        <td class="Hours">
                            <h2>Product Name</h2>
                        </td>
                        <td class="mrp_price">
                            <h2>MRP Price</h2>
                        </td>
                        <td class="Hours">
                            <h2>Price (rs)</h2>
                        </td>
                        <td class="Rate">
                            <h2>Quantity</h2>
                        </td>
                        <td class="subtotal">
                            <h2>Total (rs)</h2>
                        </td>
                    </tr>

                    @foreach ($products as $key => $product)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{$key + 1 }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{$product->product_name}}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{$product->mrp}}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"> {{$product->price}}</p> <!-- Added Rupee symbol -->
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{$product->quantity}}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"> {{($product->price * $product->quantity)}} </p> <!-- Added Rupee symbol -->
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="subtotalt">
                <table>
                    <tbody>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                MRP Amount: {{ $mrpAmount }} rs <!-- Added Rupee symbol -->
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Discount:  <span style="color: red;">- {{ $mrpAmount - $orderAmount }} rs</span> <!-- Negative sign for discount -->
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Order Amount: {{ $orderAmount }} rs <!-- Added Rupee symbol -->
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Coupon Discount: <span style="color: red;">- {{ $products[0]->coupon_discount ?? '0' }} rs </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Delivery Charge: 
                                <span style= "color: green;">
                                    @if($products[0]->delivery_charge > 0)
                                        + {{ $products[0]->delivery_charge }} rs
                                </span>
                                
                                @else
                                    <span style= "color: green;">Free Delivery</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Total Amount:  
                                {{ (float)($products[0]->total_amount ?? 0) + (float)($products[0]->delivery_charge ?? 0) }} rs
                            </td>
                        </tr>
                        <tr>
                            <td align="right" width="15.1%" style="padding: 5px;">
                                Mode Of Payment: {{ ($products[0]->payment_type == '0') ? 'COD' : 'Online' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="total-savings" style="padding: 5px; text-align: center;">
                <?php
                    $discountAmount = (float)$mrpAmount - (float)$orderAmount; // Ensure both are numeric
                    $couponDiscount = (float)$products[0]->coupon_discount ?? 0; // Ensure coupon discount is numeric
                    $totalSavings = $discountAmount + $couponDiscount; // Add both as numbers
                ?>
                <b style="color: green;">You Saved Total:  {{ $totalSavings }} rs</b> <!-- Display total savings -->
            </div>
            <div id="legalcopy">
                * Prices are inclusive of All Taxes.<br>THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE SIGNATURE.
            </div>
        </div>
    </div>
</div>
</body>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</html>






<style>
    body{
        font-family: 'Arial';
    }
    h1 {
        font-size: 1.5em;
        color: #222;
    }

    h2 {
        font-size: .9em;
        margin: 0;
    }

    h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }

    h5 {
        font-size: 13px;
        padding: 0;
        margin: 0;
    }

    p {
        font-size: 13px;
        color: #000;
        line-height: 18px;
        margin: 2px 0;
    }

    #invoiceholder {
        width: 100%;
        padding-top: 50px;
        padding-bottom: 50px;
    }


    [id*='invoice-'] {
        padding: 10px 30px 0px 30px;
    }

    #invoice-top {

        padding-bottom: 10px;

    }
    #invoice-top h2{
        text-align: center;
        text-decoration: underline;
        font-size: 16px;
    }
    #invoice-top p{
        font-size: 13px;
    }
    #invoice-bottom {
        min-height: 70px;
        display: flex;
        padding: 10px 30px 10px;
        border-top: 3px solid;
    }
    #invoice-bottom p{
        font-size: 11px;
    }

    #invoice-mid {
        min-height: 120px;

    }

    #invoice-midsub {
        min-height: 50px;
        padding: 0 30px;
        display: flex;
        justify-content: center;
    }

    #invoice-bot {
        min-height: 600px;

    }



    .info {

        border-bottom: 2px solid;
    }

    .title {
        font-size: 14px;
        float: right;
        font-family: monospace;
    }

    .title p {
        text-align: right;
        line-height: 18px;
    }



    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #6d6d6d;
    }

    td {
        padding: 5px 10px 5px 10px;

    }
    td:not(:last-child),th:not(:last-child) {
    border-right: 1px solid #6d6d6d;
    }


    .tabletitle {
        padding: 5px;
        background: #d3d3d3;
    }


    .itemtext {
        font-size: 13px;
    }

    #legalcopy {
        margin-top: 20px;
    }

    .subtotalt {
        margin-top: -1px;
        background-color: #eeeeee;
        text-align: right;
    }

    .jhj {
        margin-top: 20px;
    }


    .serivce {

        float: right;
    }

    .detail{
        width: 50%;
        float: left;
    }
    .tabletitle {
    padding: 5px;
    background: #EEE;

}
 .subtotalt td:not(:last-child),th:not(:last-child){
border: none;
    }
</style>
