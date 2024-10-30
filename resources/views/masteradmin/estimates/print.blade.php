<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Profityo | View Estimates</title>
        @include('masteradmin.layouts.headerlink')

    </head>    
    <body class="hold-transition layout-fixed">
    <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 align-items-center justify-content-between">
                    <div class="col-auto">
                        <ol class="breadcrumb float-sm-right">
                            <a href="#"><button class="add_btn_br" onclick="printPage()"><i
                                        class="fas fa-solid fa-print mr-2"></i>Print</button></a>
                            <a href="{{ route('business.estimate.sendviews', [ $id, $slug, 'download' => 'true']) }}">
                                <button class="add_btn_br"><i class="fas fa-solid fa-file-pdf mr-2"></i>Download PDF</button>
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content px-10">
            <div class="container">
                <!-- card -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body2">
                        
                        <div class="row justify-content-between pad-3 print-box" style="display:flex;">
                            <div class="col-auto" style="width: 200px;">
                                @if($businessDetails && $businessDetails->bus_image)
                                    <img src="{{ url(env('IMAGE_URL') . 'masteradmin/business_profile/' . $businessDetails->bus_image) }}"
                                    class="elevation-2" target="_blank">
                                @endif
                            </div>
                            <!-- /.col -->
                            <div class="col-auto">
                                <p class="estimate_view_title text-right">Estimate</p>
                                <p class="company_details_text text-right">Summary</p>
                                <p class="company_business_name text-right">{{ $businessDetails->bus_company_name }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_address1 }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_address2 }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->country_name ?? '' }}</p>
                                <p class="company_details_text text-right">{{ $businessDetails->state_name ?? '' }},
                                {{  $businessDetails->city_name }} {{ $businessDetails->zipcode }}</p>
                                <p class="company_details_text text-right">Phone: {{  $businessDetails->bus_phone }}</p>
                                <p class="company_details_text text-right">Mobile: {{  $businessDetails->bus_mobile }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_website }}</p>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-between pad-2">
                            <div class="col-auto px-10" id="sale_customer">
                                <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                                <p class="company_details_text">{{ $estimates->sale_cus_first_name }} {{ $estimates->sale_cus_last_name }}</p>
                                <p class="company_details_text">{{ $estimates->sale_cus_business_name }}</p>
                                <p class="company_details_text">{{ $estimates->sale_cus_phone }}</p>
                                <p class="company_details_text">{{ $estimates->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $estimates->sale_bill_address1 }}</p>
                                <p class="company_details_text">{{ $estimates->sale_bill_address2 }}</p>
                                <p class="company_details_text"> {{ $estimates->bill_state_name }}, {{ $estimates->sale_bill_city_name }} {{ $estimates->sale_bill_zipcode }}</p>
                                <p class="company_details_text">{{ $estimates->bill_country_name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10" id="ship_customer">
                                <p class="company_business_name" style="text-decoration: underline;">Shipped To</p>
                                <p class="company_details_text">{{ $estimates->sale_ship_shipto }}</p>
                                <p class="company_details_text">{{ $estimates->sale_ship_phone }}</p>
                                <p class="company_details_text">{{ $estimates->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $estimates->sale_ship_address1 }}</p>
                                <p class="company_details_text">{{ $estimates->sale_ship_address2 }}</p>
                                <p class="company_details_text">{{ $estimates->ship_state_name }}, {{ $estimates->sale_ship_city_name }} {{ $estimates->sale_ship_zipcode }}</p>
                                <p class="company_details_text">{{ $estimates->ship_country_name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10">
                                <table class="table estimate_detail_table">
                                    <tr>
                                        <td><strong>Estimate Number:</strong></td>
                                        <td>{{ $estimates->sale_estim_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Customer Ref:</strong></td>
                                        <td>{{ $estimates->sale_estim_customer_ref }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estimate Date:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($estimates->sale_estim_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valid Until:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($estimates->sale_estim_valid_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total ({{ $currency ? $currency->currency : 'N/A' }}):</strong></td>
                                        <td><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row px-10">
                            <div class="col-md-12 table-responsive ">
                                <table class="table table-hover text-nowrap dashboard_table item_table">
                                    <thead>
                                        <tr>
                                            <th>Items</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Tax</th>
                                            <!-- <th class="text-center">Description</th> -->
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    @foreach($estimatesItems as $item)
                                    <tbody>
                                        <tr>
                                            <td>{{ $item->sale_product_name ?? 'No Product Name' }}</td>
                                            <td class="text-center">{{ $item->sale_estim_item_qty }}</td>
                                            <td class="text-center">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_estim_item_price }}</td>
                                            <!-- <td class="text-center">5%</td> -->
                                            <td class="text-center">{{ $item->tax_name ?? 'No Tax Name' }} {{ $item->tax_rate ?? 'No Tax Name' }}%</td>
                                            <!-- <td class="text-center">{{ $item->sale_estim_item_desc ?? 'No Tax Name' }}</td> -->
                                            <td class="text-right">{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $item->sale_estim_item_qty * $item->sale_estim_item_price ?? '0'}} </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4 subtotal_box">
                                <div class="table-responsive">
                                    <table class="table total_table">
                                        <tr>
                                            <td><strong>Sub Total :</strong></td>
                                            <td><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_sub_total }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Discount:</strong></td>
                                            <td><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_discount_total }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tax :</strong></td>
                                            <td><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_tax_amount }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <td><strong>{{ $currency ? $currency->currency_symbol : 'N/A' }}{{ $estimates->sale_estim_final_amount }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($estimates->sale_estim_notes))
                    <div class="col-md-12">
                            <p class="estimate_view_title ">Notes / Terms</p>
                            <p>{{ $estimates->sale_estim_notes ?? '' }}</p>
                    </div>
                    @endif
                    <div class="col-md-12">
                    <p class="estimate_view_title ">Footer</p>
                        <p>{{ $estimates->sale_estim_footer_note ?? '' }}</p>
                    </div>
                </div>
                <!-- /.card -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    
   
    </div>
    </div>
    <!-- ./wrapper -->
 
      @include('masteradmin.layouts.footerlink')
    <script>
        function printPage() {
            window.print();
        }
        window.print();

      

    </script>
    <style>
          @media print {
            /* Hide unnecessary elements */
            .no-print {
                display: none;
            }
            .print-box {
                background-color: red;

            }
        }
    </style>
    </body>
</html>