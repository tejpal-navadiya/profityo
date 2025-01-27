<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Profityo | View Invoice</title>
       
        <!-- css style -->
    </head>
<style>
@import url('{{ url('public/dist/css/pdf.css') }}');
    body {
        /* font-family: 'Source Sans Pro', sans-serif; */
        font-family: 'Source Sans Pro', 'DejaVu Sans', sans-serif;
        font-size: 12px;
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
                <h2>Invoice ID: {{ $invoices->sale_inv_id }}</h2>
                <div><strong>Invoice Summary</strong></div>
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
                    <div class="company_details_text">{{ $invoices->sale_cus_first_name }} {{ $invoices->sale_cus_last_name }}</div>
                    <div class="company_details_text">{{ $invoices->sale_cus_business_name }}</div>
                    <div class="company_details_text">{{ $invoices->sale_cus_phone }}</div>
                    <div class="company_details_text">{{ $invoices->sale_cus_email }}</div>
                    <div class="company_details_text">{{ $invoices->sale_bill_address1 }}</div>
                    <div class="company_details_text">{{ $invoices->sale_bill_address2 }}</div>
                    <div class="company_details_text"> {{ $invoices->bill_state_name }}, {{ $invoices->sale_bill_city_name }} {{ $invoices->sale_bill_zipcode }}</div>
                    <div class="company_details_text">{{ $invoices->bill_country_name }}</div>
                </td>
                <td class="w-half">
                    <div><h4>Shipped To:</h4></div>
                    <div >{{ $invoices->sale_ship_shipto }}</div>
                    <div >{{ $invoices->sale_ship_phone }}</div>
                    <div>{{ $invoices->sale_cus_email }}</div>
                    <div >{{ $invoices->sale_ship_address1 }}</div>
                    <div >{{ $invoices->sale_ship_address2 }}</div>
                    <div >{{ $invoices->ship_state_name }}, {{ $invoices->sale_ship_city_name }} {{ $invoices->sale_ship_zipcode }}</div>
                    <div >{{ $invoices->ship_country_name }}</div>
                </td>
                <td class="w-half">
                    <!-- <div><h4>Bill To:</h4></div> -->
                    <div ><strong>Invoice Number: </strong>{{ $invoices->sale_inv_number }}</div>
                    <div ><strong>Customer Ref:: </strong>{{ $invoices->sale_inv_customer_ref }}</div>
                    <div><strong>Invoice Date: </strong>{{ \Carbon\Carbon::parse($invoices->sale_inv_date)->format('M d, Y') }}</div>
                    <div ><strong>Valid Until: </strong>{{ \Carbon\Carbon::parse($invoices->sale_inv_valid_date)->format('M d, Y') }}</div>
                    <div ><strong>Grand Total ({{ $currency ? $currency->currency : 'N/A' }}):</strong><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_final_amount }}</strong></div>
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
            @foreach($invoiceItems as $item)
            <tr class="items">
                <td>{{ $item->sale_product_name ?? 'No Product Name' }}</td>
                <td class="text-center">{{ $item->sale_inv_item_qty }}</td>
                <td class="text-center">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_inv_item_price }}</td>
                <!-- <td class="text-center">5%</td> -->
                <td>{{ $item->tax_name ?? 'No Tax Name' }} {{ $item->tax_rate ?? 'No Tax Name' }}%</td>
                <!-- <td class="text-center">{{ $item->sale_inv_item_desc ?? 'No Tax Name' }}</td> -->
                <td class="text-right">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_inv_item_qty * $item->sale_inv_item_price ?? '0'}} </td>
            </tr>
            @endforeach
        </table>
    </div>
 
        <div class="total">
            <!-- <div class="pdf-totaltax"><strong>Sub Total :</strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_sub_total }}</div>
            <div class="pdf-totaltax"><strong>Discount: </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_discount_total }}</div>
            <div class="pdf-totaltax"><strong>Tax : </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_tax_amount }}</div>
            <div class="pdf-totaltax"><strong>Total: </strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_final_amount }}</div>
            <div class="pdf-totaltax"><strong>Grand Total ({{ $currency ? $currency->currency : 'N/A' }}):</strong><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_final_amount }}</strong></div> -->

            <table class="table total_table">
                <tr>
                    <td >Sub Total :</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_sub_total }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_discount_total }}</td>
                </tr>
                <tr>
                    <td>Tax :</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_tax_amount }}</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_final_amount }}</td>
                </tr>
                <tr>
                    <td><strong>Grand Total({{ $currency ? $currency->currency : 'N/A' }}):</strong></td>
                    <td> <strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $invoices->sale_inv_final_amount }}</td>
                </tr>
            </table>
            
        </div>

        @if(!empty($invoices->sale_inv_notes))
        <div class="margin-top">
                <p class="estimate_view_title ">Notes / Terms</p>
                <p>{{ $invoices->sale_inv_notes ?? '' }}</p>
        </div>
        @endif
        <div class="margin-top">
            <p class="text-center">{{ $invoices->sale_inv_footer_note ?? '' }}</p>
        </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
        <!-- <div>&copy; Laravel Daily</div> -->
    </div>
</body>
  
</html>