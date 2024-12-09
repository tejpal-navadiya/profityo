<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Profityo | View Estimates</title>
       
        <!-- css style -->
    </head>
<style>
@import url('{{ url('public/dist/css/pdf.css') }}');
    body {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 14px;
        color: #333;
    }
</style> 
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                @if($businessDetails && $businessDetails->bus_image)
                    <img src="{{ url(env('IMAGE_URL') . 'masteradmin/business_profile/' . $businessDetails->bus_image) }}"
                class="elevation-2" target="_blank"  width="200">
                @endif
            </td>
            <td class="w-half">
                <h2>Invoice ID: {{ $estimates->sale_estim_id }}</h2>
                <div><strong>Estimate Summary</strong></div>
                <div >{{ $businessDetails->bus_company_name }}</div>
                <div >{{  $businessDetails->bus_address1 }}</div>
                <div >{{  $businessDetails->bus_address2 }}</div>
                <div >{{  $businessDetails->country_name ?? '' }}</div>
                <div >{{ $businessDetails->state_name ?? '' }},
                {{  $businessDetails->city_name }} {{ $businessDetails->zipcode }}</div>
                <div >Phone: {{  $businessDetails->bus_phone }}</>
                <div>Mobile: {{  $businessDetails->bus_mobile }}</div>
                <div >{{  $businessDetails->bus_website }}</div>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>Bill To:</h4></div>
                    <div class="company_details_text">{{ $estimates->sale_cus_first_name }} {{ $estimates->sale_cus_last_name }}</div>
                    <div class="company_details_text">{{ $estimates->sale_cus_business_name }}</div>
                    <div class="company_details_text">{{ $estimates->sale_cus_phone }}</div>
                    <div class="company_details_text">{{ $estimates->sale_cus_email }}</div>
                    <div class="company_details_text">{{ $estimates->sale_bill_address1 }}</div>
                    <div class="company_details_text">{{ $estimates->sale_bill_address2 }}</div>
                    <div class="company_details_text"> {{ $estimates->bill_state_name }}, {{ $estimates->sale_bill_city_name }} {{ $estimates->sale_bill_zipcode }}</div>
                    <div class="company_details_text">{{ $estimates->bill_country_name }}</div>
                </td>
                <td class="w-half">
                    <div><h4>Shipped To:</h4></div>
                    <div >{{ $estimates->sale_ship_shipto }}</div>
                    <div >{{ $estimates->sale_ship_phone }}</div>
                    <div>{{ $estimates->sale_cus_email }}</div>
                    <div >{{ $estimates->sale_ship_address1 }}</div>
                    <div >{{ $estimates->sale_ship_address2 }}</div>
                    <div >{{ $estimates->ship_state_name }}, {{ $estimates->sale_ship_city_name }} {{ $estimates->sale_ship_zipcode }}</div>
                    <div >{{ $estimates->ship_country_name }}</div>
                </td>
                <td class="w-half">
                    <!-- <div><h4>Bill To:</h4></div> -->
                    <div ><strong>Estimate Number: </strong>{{ $estimates->sale_estim_number }}</div>
                    <div ><strong>Customer Ref:: </strong>{{ $estimates->sale_estim_customer_ref }}</div>
                    <div><strong>Estimate Date: </strong>{{ \Carbon\Carbon::parse($estimates->sale_estim_date)->format('M d, Y') }}</div>
                    <div ><strong>Valid Until: </strong>{{ \Carbon\Carbon::parse($estimates->sale_estim_valid_date)->format('M d, Y') }}</div>
                    <div ><strong>Grand Total ({{ $currency ? $currency->currency : 'N/A' }}):</strong><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</strong></div>
                </td>
           
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Tax</th>
                <!-- <th>Description</th> -->
                <th >Amount</th>
            </tr>
            @foreach($estimatesItems as $item)
            <tr class="items">
                <td>{{ $item->sale_product_name ?? 'No Product Name' }}</td>
                <td class="text-center">{{ $item->sale_estim_item_qty }}</td>
                <td class="text-center">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_estim_item_price }}</td>
                <!-- <td class="text-center">5%</td> -->
                <td class="text-center">{{ $item->tax_name ?? 'No Tax Name' }} {{ $item->tax_rate ?? 'No Tax Name' }}%</td>
                <!-- <td class="text-center">{{ $item->sale_estim_item_desc ?? 'No Tax Name' }}</td> -->
                <td class="text-right">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_estim_item_qty * $item->sale_estim_item_price ?? '0'}} </td>
            </tr>
            @endforeach
        </table>
    </div>
 
        <div class="total">
            <!-- <div class="pdf-totaltax"><strong>Sub Total :</strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_sub_total }}</div>
            <div class="pdf-totaltax"><strong>Discount: </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_discount_total }}</div>
            <div class="pdf-totaltax"><strong>Tax : </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_tax_amount }}</div>
            <div class="pdf-totaltax"><strong>Total: </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</div>
            <div class="pdf-totaltax"><strong>Grand Total ({{ $currency ? $currency->currency : 'N/A' }}):</strong><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</strong></div> -->

            <table class="table total_table">
                <tr>
                    <td >Sub Total :</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_sub_total }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_discount_total }}</td>
                </tr>
                <tr>
                    <td>Tax :</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_tax_amount }}</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</td>
                </tr>
                <tr>
                    <td><strong>Grand Total({{ $currency ? $currency->currency : 'N/A' }}):</strong></td>
                    <td> <strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</td>
                </tr>
            </table>
            
        </div>

        @if(!empty($estimates->sale_estim_notes))
        <div class="margin-top">
                <p class="estimate_view_title ">Notes / Terms</p>
                <p>{{ $estimates->sale_estim_notes ?? '' }}</p>
        </div>
        @endif
        <div class="margin-top">
            <p class="text-center">{{ $estimates->sale_estim_footer_note ?? '' }}</p>
        </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
        <!-- <div>&copy; Laravel Daily</div> -->
    </div>
</body>
  
</html>