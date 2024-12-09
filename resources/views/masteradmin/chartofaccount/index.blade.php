@extends('masteradmin.layouts.app')
<title>Profityo | Chart of Accounts</title>
@if(isset($access['view_customers']) && $access['view_customers']) 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Chart of Accounts</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Chart of Accounts</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <button class="add_btn" data-toggle="modal" data-target="#addaccount"><i class="fas fa-plus add_plus_icon"></i>Add A New Account</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
        <ul class="nav nav-pills p-2 tab_box">
            <!-- <li class="nav-item"><a class="nav-link active" id="assets-tab" href="#account-assets" data-toggle="tab">Assets <span class="badge badge-toes">{{ count($assets) }}</span></a></li>
            <li class="nav-item"><a class="nav-link" id="liabilities-tab" href="#account-liabilities-creditcards" data-toggle="tab">Liabilities & Credit Cards <span class="badge badge-toes">{{ count($liabilitiesAndCreditCards) }}</span></a></li>
            <li class="nav-item"><a class="nav-link" id="income-tab" href="#account-income" data-toggle="tab">Income <span class="badge badge-toes">{{ count($income) }}</span></a></li>
            <li class="nav-item"><a class="nav-link" id="expenses-tab" href="#account-expenses" data-toggle="tab">Expenses <span class="badge badge-toes">{{ count($expenses) }}</span></a></li>
            <li class="nav-item"><a class="nav-link" id="equity-tab" href="#account-equity" data-toggle="tab">Equity <span class="badge badge-toes">{{ count($equity) }}</span></a></li> -->
            @foreach($tabs as $tab)
              <li class="nav-item">
                  <a class="nav-link @if($loop->first) active @endif" id="{{ strtolower($tab->chart_menu_id) }}-tab" href="#account-{{ strtolower($tab->chart_menu_id) }}" data-toggle="tab">
                      {{ $tab->chart_menu_title }} 
                      <span class="badge badge-toes"> 
                      {{ $counts->get($tab->chart_menu_id, 0) }}

                      </span>
                  </a>
              </li>
            @endforeach
          </ul>
       
        </div><!-- /.card-header -->
        <div class="tab-content px-20">
          <div class="tab-pane active" id="account-1">
            @foreach ($assets as $asset)
            <?php //dd( $assets); ?>
            <div class="card">
              <div class="card-header">
              
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$asset->chart_menu_title}}</h3></div>
                </div>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                <div class="table-responsive">
                <table class="table table-hover text-nowrap dashboard_table">
                        <thead>
                            <tr>
                                <th>Account ID</th>
                                <th>Account Name</th>
                                <th>Description</th>
                                <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if there are any accounts related to this parent (type_id) -->
                            @if (isset($list[$asset->chart_menu_id]))
                                <!-- Loop through the child accounts for this parent -->
                                @foreach ($list[$asset->chart_menu_id] as $account)
                                    <tr>
                                        <td>{{ $account->chart_account_id }}</td>
                                        <td>{{ $account->chart_acc_name }}</td>
                                        <td>{{ $account->sale_acc_desc }}</td>
                                        <td class="text-right">
                                       <div class="modal-body">
                                            <a data-toggle="modal" 
                                            data-child-id="{{ $asset->chart_menu_id }}" 
                                            data-id="{{ $asset->chart_menu_id }}" 
                                            data-target="#editthisaccount_{{ $account->chart_acc_id }}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        </td>
                                    </tr>


                                <div class="modal fade" id="editthisaccount_{{$account->chart_acc_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle1">{{$asset->chart_menu_title}}</h5> 
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form id="editAccountForm1" method="POST" action="{{ route('business.chartofaccount.update',['account'=>$account->chart_acc_id]) }}">
                                            @csrf
                                            @method('Patch')
                                            <input type="hidden" id="editAccountId" name="chart_acc_id">
                                            <div class="row pxy-15 px-10">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Account Type</label>
                                                <select id="accountTypeDropdownAssets_{{ $account->chart_acc_id }}" name="acc_type_id" class="form-control" disabled>
                                                  @foreach($assets as $asset1)
                                                    <option value="{{ $asset1->chart_menu_id }}">
                                                        {{ $asset1->chart_menu_title }}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountName">Account Name <span class="text-danger">*</span></label>
                                                  <input type="text" class="form-control" id="editAccountName" name="chart_acc_name" placeholder="Cash on Hand" value="{{ $account->chart_acc_name }}">
                                                  <span id="accountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>Account Currency <span class="text-danger">*</span></label>
                                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;" disabled>
                                                      <!-- <option value="">Select a Currency</option> -->
                                                      @foreach($Country as $cur)
                                                        <option value="{{ $cur->id }}" @if($cur->id == $account->currency_id) selected @endif>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                 
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountIdField">Account ID</label>
                                                  <input type="text" class="form-control" id="editAccountIdField" name="chart_account_id" value="{{ $account->chart_account_id }}" placeholder="">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editDescription">Description</label>
                                                  <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $account->sale_acc_desc }}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editArchiveAccount">Archive Account</label>
                                                  <div class="form-check d-flex align-items-baseline">
                                                    <input class="form-check-input" type="checkbox" id="editArchiveAccount" name="archive_account" value=1
                                                    @if($account->archive_account == 1) checked @endif>
                                                    <label class="form-check-label" for="editArchiveAccount">
                                                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                                                      <p class="mb-0">You Will Still be Able to Generate Reports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="account-divider"></div>
                                              <p class="mb-0 pad-1">No transactions for this account.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="add_btn">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                </div>
                              </div>


                                @endforeach
                            @else
                                <!-- Show a message if there are no child accounts -->
                                
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12"><div class="account-divider"></div></div>
                <div class="col-auto account_pad">
                    <a class="add_new_account_text" 
                      data-toggle="modal" 
                      data-target="#addanaccountassets" 
                      data-child-id="{{ $asset->chart_menu_id }}" 
                      data-id="{{ $asset->chart_menu_id }}">
                      <i class="fas fa-plus mr-2"></i>Add A New Account
                    </a>
                </div>

                <div class="modal fade" id="addanaccountassets" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle2">Add An Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <form id="addaccountAsset" action="{{ route('business.chartofaccount.store') }}" method="POST">
                      @csrf
                          <div class="row pxy-15 px-10">
                            <div class="col-md-6">
                            <div class="form-group">
                              <label>Account Type</label>
                              <select id="accountTypeDropdownAssets" data-id="" name="acc_type_id" class="form-control">
                                @foreach($assets as $assetss)
                                    <option value="{{ $assetss->chart_menu_id }}">
                                        {{ $assetss->chart_menu_title }}
                                    </option>
                                @endforeach
                              </select>
                            </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="asset_account_name" name="chart_acc_name" placeholder="">
                                <span id="assetaddaccountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Account Currency <span class="text-danger">*</span></label>
                                <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" id="assetcurrencyId" name="currency_id" style="width: 100%;">
                                    <option value="">Select a Currency</option>
                                    @foreach($Country as $cur) 
                                        <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                                    @endforeach
                                  </select>
                                  <span id="assetaddcurrencyError" class="text-danger mt-2" style="display:none;">Please enter account currency.</span>

                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="account_id">Account ID</label>
                                <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                              </div>
                            </div>
                          </div>
                      
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="add_btn">Save</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-2">
          @foreach ($liabilitiesAndCreditCards as $lccard)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$lccard->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                            <!-- Check if there are any accounts related to this parent (type_id) -->
                            @if (isset($list[$lccard->chart_menu_id]))
                                <!-- Loop through the child accounts for this parent -->
                                @foreach ($list[$lccard->chart_menu_id] as $liabilities)
                                    <tr>
                                        <td>{{ $liabilities->chart_account_id }}</td>
                                        <td>{{ $liabilities->chart_acc_name }}</td>
                                        <td>{{ $liabilities->sale_acc_desc }}</td>
                                        <td class="text-right">
                                        <a data-toggle="modal"
                                            data-child-id="{{ $lccard->chart_menu_id }}" 
                                            data-id="{{ $lccard->chart_menu_id }}" 
                                            data-target="#editthisliabilities_{{$liabilities->chart_acc_id}}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        </td>
                                    </tr>


                                   
                                    <!-- end -->
                                    <div class="modal fade" id="editthisliabilities_{{$liabilities->chart_acc_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle3">{{$lccard->chart_menu_title}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form id="editAccountForm2" method="POST" action="{{ route('business.chartofaccount.update',['account'=>$liabilities->chart_acc_id]) }}">
                                            @csrf
                                            @method('Patch')
                                            <input type="hidden" id="editAccountId" name="chart_acc_id">
                                            <div class="row pxy-15 px-10">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Account Type</label>
                                                <select id="accountTypeDropdownLiabilities_{{ $liabilities->chart_acc_id }}" name="acc_type_id" class="form-control" disabled>
                                                  @foreach($liabilitiesAndCreditCards as $lccard1)
                                                    <option value="{{ $lccard1->chart_menu_id }}">
                                                        {{ $lccard1->chart_menu_title }}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountName">Account Name <span class="text-danger">*</span></label>
                                                  <input type="text" class="form-control" id="editAccountName" name="chart_acc_name" placeholder="Cash on Hand" value="{{ $liabilities->chart_acc_name }}">
                                                  <span id="accountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>Account Currency <span class="text-danger">*</span></label>
                                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;" disabled>
                                                      <!-- <option value="">Select a Currency</option> -->
                                                      @foreach($Country as $cur)
                                                        <option value="{{ $cur->id }}" @if($cur->id == $liabilities->currency_id) selected @endif>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                 
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountIdField">Account ID</label>
                                                  <input type="text" class="form-control" id="editAccountIdField" name="chart_account_id" value="{{ $liabilities->chart_account_id }}" placeholder="">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editDescription">Description</label>
                                                  <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $liabilities->sale_acc_desc }}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editArchiveAccount">Archive Account</label>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="editArchiveAccount" name="archive_account" value=1
                                                    @if($liabilities->archive_account == 1) checked @endif>
                                                    <label class="form-check-label" for="editArchiveAccount">
                                                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                                                      <p class="mb-0">You Will Still be Able to Generate Reports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="account-divider"></div>
                                              <p class="mb-0 pad-1">No transactions for this account.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="add_btn">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Show a message if there are no child accounts -->
                                <tr>
                                    <td colspan="4">No accounts available for this category.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccountliabilities"
                      data-child-id="{{ $lccard->chart_menu_id }}" 
                      data-id="{{ $lccard->chart_menu_id }}"
                      ><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>

                   <!-- add model -->
                  <div class="modal fade" id="addanaccountliabilities" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle4">Add An Account</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form id="addaccountAsset" action="{{ route('business.chartofaccount.store') }}" method="POST">
                        @csrf
                            <div class="row pxy-15 px-10">
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>Account Type</label>
                                <select id="accountTypeDropdownLiabilities" name="acc_type_id" class="form-control">
                                @foreach($liabilitiesAndCreditCards as $lccardedit)
                                    <option value="{{ $lccardedit->chart_menu_id }}">
                                        {{ $lccardedit->chart_menu_title }}
                                    </option>
                                @endforeach
                                </select>
                                
                              </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="">
                                  <span id="assetaddaccountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Account Currency <span class="text-danger">*</span></label>
                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;">
                                      <option value="">Select a Currency</option>
                                      @foreach($Country as $cur) 
                                          <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_id">Account ID</label>
                                  <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="inputDescription">Description</label>
                                  <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                                </div>
                              </div>
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="add_btn">Save</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
            @endforeach
          </div>
   
          
          <div class="tab-pane" id="account-3">
          @foreach ($income as $incomes)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$incomes->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                            <!-- Check if there are any accounts related to this parent (type_id) -->
                            @if (isset($list[$incomes->chart_menu_id]))
                                <!-- Loop through the child accounts for this parent -->
                                @foreach ($list[$incomes->chart_menu_id] as $incm)
                                    <tr>
                                        <td>{{ $incm->chart_account_id }}</td>
                                        <td>{{ $incm->chart_acc_name }}</td>
                                        <td>{{ $incm->sale_acc_desc }}</td>
                                        <td class="text-right">
                                        <a data-toggle="modal" data-id="{{ $incm->chart_acc_id }}" 
                                        data-child-id="{{ $incomes->chart_menu_id }}" 
                                        data-id="{{ $incomes->chart_menu_id }}" 
                                        data-target="#editthisincm_{{$incm->chart_acc_id}}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        </td>
                                    </tr>
                                   <!-- add model addanaccountincome -->
                                  
                                   <!-- end -->
                                   
                                    <div class="modal fade" id="editthisincm_{{$incm->chart_acc_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle5">{{$incomes->chart_menu_title}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form id="editAccountForm3" method="POST" action="{{ route('business.chartofaccount.update',['account'=>$incm->chart_acc_id]) }}">
                                            @csrf
                                            @method('Patch')
                                            <input type="hidden" id="editAccountId" name="chart_acc_id">
                                            <div class="row pxy-15 px-10">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Account Type</label>
                                               
                                                <select id="accountTypeDropdownIncome_{{ $incm->chart_acc_id }}"  name="acc_type_id" class="form-control" disabled>
                                                @foreach($income as $incomess)
                                                    <option value="{{ $incomess->chart_menu_id }}">
                                                        {{ $incomess->chart_menu_title }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountName">Account Name <span class="text-danger">*</span></label>
                                                  <input type="text" class="form-control" id="editAccountName" name="chart_acc_name" placeholder="Cash on Hand" value="{{ $incm->chart_acc_name }}" >
                                                  <span id="accountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>Account Currency <span class="text-danger">*</span></label>
                                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;" disabled>
                                                      <!-- <option value="">Select a Currency</option> -->
                                                      @foreach($Country as $cur)
                                                        <option value="{{ $cur->id }}" @if($cur->id == $incm->currency_id) selected @endif>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                 
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountIdField">Account ID</label>
                                                  <input type="text" class="form-control" id="editAccountIdField" name="chart_account_id" value="{{ $incm->chart_account_id }}" placeholder="">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editDescription">Description</label>
                                                  <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $incm->sale_acc_desc }}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editArchiveAccount">Archive Account</label>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="editArchiveAccount" name="archive_account" value=1
                                                    @if($incm->archive_account == 1) checked @endif>
                                                    <label class="form-check-label" for="editArchiveAccount">
                                                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                                                      <p class="mb-0">You Will Still be Able to Generate Reports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="account-divider"></div>
                                              <p class="mb-0 pad-1">No transactions for this account.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="add_btn">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Show a message if there are no child accounts -->
                                <tr>
                                    <td colspan="4">No accounts available for this category.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text"
                      data-child-id="{{ $incomes->chart_menu_id }}" 
                      data-id="{{ $incomes->chart_menu_id }}"
                   data-toggle="modal" data-target="#addanaccountincome"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>

                  <div class="modal fade" id="addanaccountincome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle6">Add An Account</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('business.chartofaccount.store') }}" method="POST">
                        @csrf
                            <div class="row pxy-15 px-10">
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>Account Type</label>
                                <select id="accountTypeDropdownIncome" name="acc_type_id" class="form-control">
                                  @foreach($income as $income1)
                                    <option value="{{ $income1->chart_menu_id }}">
                                        {{ $income1->chart_menu_title }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Account Currency <span class="text-danger">*</span></label>
                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;">
                                      <option value="">Select a Currency</option>
                                      @foreach($Country as $cur) 
                                          <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_id">Account ID</label>
                                  <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="inputDescription">Description</label>
                                  <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                                </div>
                              </div>
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="add_btn">Save</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

              </div>
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-4">
          @foreach ($expenses as $expense)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$expense->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                            <!-- Check if there are any accounts related to this parent (type_id) -->
                            @if (isset($list[$expense->chart_menu_id]))
                                <!-- Loop through the child accounts for this parent -->
                                @foreach ($list[$expense->chart_menu_id] as $exp)
                                    <tr>
                                        <td>{{ $exp->chart_account_id }}</td>
                                        <td>{{ $exp->chart_acc_name }}</td>
                                        <td>{{ $exp->sale_acc_desc }}</td>
                                        <td class="text-right">
                                        <a data-toggle="modal" 
                                        data-id="{{ $exp->chart_acc_id }}" 
                                        data-child-id="{{ $expense->chart_menu_id }}" 
                                        data-id="{{ $expense->chart_menu_id }}" 
                                        data-target="#editthisexp_{{$exp->chart_acc_id}}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editthisexp_{{$exp->chart_acc_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle7">{{$expense->chart_menu_title}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form id="editAccountForm4" method="POST" action="{{ route('business.chartofaccount.update',['account'=>$exp->chart_acc_id]) }}">
                                            @csrf
                                            @method('Patch')
                                            <input type="hidden" id="editAccountId" name="chart_acc_id">
                                            <div class="row pxy-15 px-10">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Account Type</label>
                                                <select id="accountTypeDropdownExpenses_{{ $exp->chart_acc_id }}" name="acc_type_id" class="form-control" disabled>
                                                  @foreach($expenses as $expenses1)
                                                    <option value="{{ $expenses1->chart_menu_id }}">
                                                        {{ $expenses1->chart_menu_title }}
                                                    </option>
                                                  @endforeach
                                                </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountName">Account Name <span class="text-danger">*</span></label>
                                                  <input type="text" class="form-control" id="editAccountName" name="chart_acc_name" placeholder="Cash on Hand" value="{{ $exp->chart_acc_name }}">
                                                  <span id="accountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>Account Currency <span class="text-danger">*</span></label>
                                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;" disabled>
                                                      <!-- <option value="">Select a Currency</option> -->
                                                      @foreach($Country as $cur)
                                                        <option value="{{ $cur->id }}" @if($cur->id == $exp->currency_id) selected @endif>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                 
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountIdField">Account ID</label>
                                                  <input type="text" class="form-control" id="editAccountIdField" name="chart_account_id" value="{{ $exp->chart_account_id }}" placeholder="">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editDescription">Description</label>
                                                  <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $exp->sale_acc_desc }}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editArchiveAccount">Archive Account</label>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="editArchiveAccount" name="archive_account" value=1
                                                    @if($exp->archive_account == 1) checked @endif>
                                                    <label class="form-check-label" for="editArchiveAccount">
                                                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                                                      <p class="mb-0">You Will Still be Able to Generate Reports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="account-divider"></div>
                                              <p class="mb-0 pad-1">No transactions for this account.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="add_btn">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Show a message if there are no child accounts -->
                                <tr>
                                    <td colspan="4">No accounts available for this category.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text" data-child-id="{{ $expense->chart_menu_id }}" 
                  data-id="{{ $expense->chart_menu_id }}" data-toggle="modal" data-target="#addanaccountexpenses"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>

                    <!-- add model addanaccountexpenses -->
                    <div class="modal fade" id="addanaccountexpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle8">Add An Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="{{ route('business.chartofaccount.store') }}" method="POST">
                          @csrf
                              <div class="row pxy-15 px-10">
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label>Account Type</label>
                                  <select id="accountTypeDropdownExpenses" name="acc_type_id" class="form-control">
                                  @foreach($expenses as $expensesss)
                                    <option value="{{ $expensesss->chart_menu_id }}">
                                        {{ $expensesss->chart_menu_title }}
                                    </option>
                                  @endforeach
                                </select>
                                </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Account Currency <span class="text-danger">*</span></label>
                                    <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;">
                                        <option value="">Select a Currency</option>
                                        @foreach($Country as $cur) 
                                            <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="account_id">Account ID</label>
                                    <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="inputDescription">Description</label>
                                    <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                                  </div>
                                </div>
                              </div>
                          
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="add_btn">Save</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-5">
          @foreach ($equity as $equitys)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$equitys->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                <div class="table-responsive">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>Account ID</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                            <!-- Check if there are any accounts related to this parent (type_id) -->
                            @if (isset($list[$equitys->chart_menu_id]))
                                <!-- Loop through the child accounts for this parent -->
                                @foreach ($list[$equitys->chart_menu_id] as $eq)
                                    <tr>
                                        <td>{{ $eq->chart_account_id }}</td>
                                        <td>{{ $eq->chart_acc_name }}</td>
                                        <td>{{ $eq->sale_acc_desc }}</td>
                                        <td class="text-right">
                                        <a data-toggle="modal" data-id="{{ $eq->chart_acc_id }}" 
                                        data-child-id="{{ $equitys->chart_menu_id }}" 
                                        data-id="{{ $equitys->chart_menu_id }}" 
                                        data-target="#editthiseq_{{$eq->chart_acc_id}}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        </td>
                                    </tr>

                                  <div class="modal fade" id="editthiseq_{{$eq->chart_acc_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle9">{{$equitys->chart_menu_title}}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <form id="editAccountForm5" method="POST" action="{{ route('business.chartofaccount.update',['account'=>$eq->chart_acc_id]) }}">
                                            @csrf
                                            @method('Patch')
                                            <input type="hidden" id="editAccountId" name="chart_acc_id">
                                            <div class="row pxy-15 px-10">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                <label>Account Type</label>
                                                <select id="accountTypeDropdownEquity_{{ $eq->chart_acc_id }}"  name="acc_type_id" class="form-control" disabled>
                                                    @foreach($equity as $equityss)
                                                      <option value="{{ $equityss->chart_menu_id }}">
                                                          {{ $equityss->chart_menu_title }}
                                                      </option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountName">Account Name <span class="text-danger">*</span></label>
                                                  <input type="text" class="form-control" id="editAccountName" name="chart_acc_name" placeholder="Cash on Hand" value="{{ $eq->chart_acc_name }}">
                                                  <span id="accountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label>Account Currency <span class="text-danger">*</span></label>
                                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;" disabled>
                                                      <!-- <option value="">Select a Currency</option> -->
                                                      @foreach($Country as $cur)
                                                        <option value="{{ $cur->id }}" @if($cur->id == $eq->currency_id) selected @endif>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                  
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="editAccountIdField">Account ID</label>
                                                  <input type="text" class="form-control" id="editAccountIdField" name="chart_account_id" value="{{ $eq->chart_account_id }}" placeholder="">
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editDescription">Description</label>
                                                  <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $eq->sale_acc_desc }}</textarea>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label for="editArchiveAccount">Archive Account</label>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="editArchiveAccount" name="archive_account" value=1
                                                    @if($eq->archive_account == 1) checked @endif>
                                                    <label class="form-check-label" for="editArchiveAccount">
                                                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                                                      <p class="mb-0">You Will Still be Able to Generate Reports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="account-divider"></div>
                                              <p class="mb-0 pad-1">No transactions for this account.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="add_btn">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                            @endforeach
                            @else
                                <!-- Show a message if there are no child accounts -->
                                <tr>
                                    <td colspan="4">No accounts available for this category.</td>
                                </tr>
                            @endif
                        </tbody>
                  </table>
                </div>
                <div class="col-md-12"><div class="account-divider"></div></div>
                <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" 
                data-child-id="{{ $equitys->chart_menu_id }}" 
                      data-id="{{ $equitys->chart_menu_id }}"
                      data-target="#addanaccountequity"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>

                  <div class="modal fade" id="addanaccountequity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle10">Add An Account</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('business.chartofaccount.store') }}" method="POST">
                        @csrf
                            <div class="row pxy-15 px-10">
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>Account Type</label>
                                <select id="accountTypeDropdownEquity" name="acc_type_id" class="form-control">
                                    @foreach($equity as $equity1)
                                      <option value="{{ $equity1->chart_menu_id }}">
                                          {{ $equity1->chart_menu_title }}
                                      </option>
                                    @endforeach
                                </select>
                              </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Account Currency <span class="text-danger">*</span></label>
                                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;">
                                      <option value="">Select a Currency</option>
                                      @foreach($Country as $cur) 
                                          <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                                      @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="account_id">Account ID</label>
                                  <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="inputDescription">Description</label>
                                  <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                                </div>
                              </div>
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="add_btn">Save</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="addaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle11">Add an Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form id="addaccountForm" action="{{ route('business.chartofaccount.store') }}" method="POST">
          @csrf
              <div class="row pxy-15 px-10">
                <div class="col-md-6">
                <div class="form-group">
                  <label>Account Type</label>
                  <select id="account" data-id="" name="acc_type_id" class="form-control">
                  @foreach ($tabs as $tab)
                    <optgroup label="{{ $tab->chart_menu_title }}">
                        @foreach ($subMenus[$tab->chart_menu_id] ?? [] as $submenu)
                            <option value="{{ $submenu->chart_menu_id }}">
                                {{ $submenu->chart_menu_title }}
                            </option>
                        @endforeach
                    </optgroup>
                  @endforeach
                    <!-- @foreach($assets as $assetss)
                        <option value="{{ $assetss->chart_menu_id }}">
                            {{ $assetss->chart_menu_title }}
                        </option>
                    @endforeach -->
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="">
                    <span id="addaccountNameError" class="text-danger mt-2" style="display:none;">Please enter account name.</span>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Account Currency <span class="text-danger">*</span></label>
                    <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" id="currencyId" name="currency_id" style="width: 100%;">
                        <option value="">Select a Currency</option>
                        @foreach($Country as $cur) 
                            <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                        @endforeach
                      </select>
                      <span id="addcurrencyError" class="text-danger mt-2" style="display:none;">Please enter account currency.</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="account_id">Account ID</label>
                    <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="inputDescription">Description</label>
                    <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                  </div>
                </div>
              </div>
          
          </div>
          <div class="modal-footer">
            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
            <button type="submit" class="add_btn">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.content -->
</div>
  </div>
</div>
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>


<script>
  $(document).ready(function() {
    // Listen for when the modal is about to be shown
    $('#addanaccountassets').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        // alert('hi');
        // Find the dropdown and set its value
        var dropdown = $(this).find('#accountTypeDropdownAssets');
        dropdown.val(childId); // Set the value of the dropdown

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('#addanaccountliabilities').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        // alert('hi');
        // Find the dropdown and set its value
        var dropdown = $(this).find('#accountTypeDropdownLiabilities');
        dropdown.val(childId); // Set the value of the dropdown

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('#addanaccountincome').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        // alert('hi');
        // Find the dropdown and set its value
        var dropdown = $(this).find('#accountTypeDropdownIncome');
        dropdown.val(childId); // Set the value of the dropdown

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('#addanaccountexpenses').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        // alert('hi');
        // Find the dropdown and set its value
        var dropdown = $(this).find('#accountTypeDropdownExpenses');
        dropdown.val(childId); // Set the value of the dropdown

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('#addanaccountequity').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        // alert('hi');
        // Find the dropdown and set its value
        var dropdown = $(this).find('#accountTypeDropdownEquity');
        dropdown.val(childId); // Set the value of the dropdown

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });
    
});

$(document).ready(function() {
    // Listen for when the modal is about to be shown
    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        
        // Extract the specific modal ID to target the correct modal
        var modalId = button.data('target');
        
        // Find the dropdown inside the modal with the correct ID
        var dropdown = $(modalId).find('select[id^="accountTypeDropdownAssets_"]');
        
        // Set the value of the dropdown
        dropdown.val(childId); 

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        
        // Extract the specific modal ID to target the correct modal
        var modalId = button.data('target');
        
        // Find the dropdown inside the modal with the correct ID
        var dropdown = $(modalId).find('select[id^="accountTypeDropdownLiabilities_"]');
        
        // Set the value of the dropdown
        dropdown.val(childId); 

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        
        // Extract the specific modal ID to target the correct modal
        var modalId = button.data('target');
        
        // Find the dropdown inside the modal with the correct ID
        var dropdown = $(modalId).find('select[id^="accountTypeDropdownIncome_"]');
        
        // Set the value of the dropdown
        dropdown.val(childId); 

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        
        // Extract the specific modal ID to target the correct modal
        var modalId = button.data('target');
        
        // Find the dropdown inside the modal with the correct ID
        var dropdown = $(modalId).find('select[id^="accountTypeDropdownExpenses_"]');
        
        // Set the value of the dropdown
        dropdown.val(childId); 

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });

    $('.modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var childId = button.data('child-id'); // Extract info from data-* attributes
        
        // Extract the specific modal ID to target the correct modal
        var modalId = button.data('target');
        
        // Find the dropdown inside the modal with the correct ID
        var dropdown = $(modalId).find('select[id^="accountTypeDropdownEquity_"]');
        
        // Set the value of the dropdown
        dropdown.val(childId); 

        // Optional: Trigger change event if you need to update other parts of the UI
        dropdown.trigger('change');
    });
});

</script>
<script>
$(document).ready(function() {
    // Generic form validation function
    function validateForm(formId, fieldConfig) {
        $(formId).on('submit', function(e) {
            let isValid = true;

            // Iterate through each field to validate
            fieldConfig.forEach(config => {
                let field = $(config.selector);
                let errorField = $(config.errorSelector);

                if (field.val().trim() === "") {
                    errorField.show(); // Show the error message
                    field.addClass("is-invalid"); // Add invalid class to highlight the field
                    isValid = false; // Mark the form as invalid
                } else {
                    errorField.hide(); // Hide the error message if input is valid
                    field.removeClass("is-invalid"); // Remove invalid class if input is valid
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if invalid
            }
        });
    }

    // Generic input field validation
    function hideErrorOnInput(fieldSelector, errorSelector) {
        $(fieldSelector).on('input', function() {
            let errorField = $(errorSelector);
            if ($(this).val().trim() !== "") {
                errorField.hide(); // Hide the error message if the field is no longer empty
                $(this).removeClass("is-invalid"); // Remove the invalid class
            }
        });
    }

    // Configuration for each form
    const formsConfig = [
        {
            formId: '#editAccountForm1',
            fields: [
                { selector: '#editAccountName', errorSelector: '#accountNameError' }
            ]
        },
        
        {
            formId: '#addaccountForm',
            fields: [
                { selector: '#account_name', errorSelector: '#addaccountNameError' },
                { selector: '#currencyId', errorSelector: '#addcurrencyError' }
            ]
        },
        {
            formId: '#addaccountAsset',
            fields: [
                { selector: '#asset_account_name', errorSelector: '#assetaddaccountNameError' },
                { selector: '#assetcurrencyId', errorSelector: '#assetaddcurrencyError' }
            ]
        }
    ];

    // Initialize validation for each form
    formsConfig.forEach(config => {
        validateForm(config.formId, config.fields);
        config.fields.forEach(field => {
            hideErrorOnInput(field.selector, field.errorSelector);
        });
    });
});
</script>

@endsection
@endif