<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\PlanController;
use App\Http\Controllers\Auth\MasterAdmin\RegisterController;
use App\Http\Controllers\Auth\MasterAdmin\LoginController;
use App\Http\Controllers\Auth\MasterAdmin\MasterPasswordResetLinkController;
use App\Http\Controllers\Auth\MasterAdmin\MasterNewPasswordController;
use App\Http\Controllers\Auth\MasterAdmin\MasterEmailVerificationPromptController;
use App\Http\Controllers\Auth\MasterAdmin\MasterEmailVerificationNotificationController;
use App\Http\Controllers\Masteradmin\HomeController;
use App\Http\Controllers\Masteradmin\ProfilesController;
use App\Http\Controllers\Auth\MasterAdmin\MasterPasswordController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\superadmin\HomesController;
use App\Http\Controllers\Masteradmin\UserRoleController;
use App\Http\Controllers\Masteradmin\SalesTaxController;
use App\Http\Controllers\Masteradmin\UserController;
use App\Http\Controllers\Masteradmin\SalesCustomersController;
use App\Http\Controllers\superadmin\BusinessDetailController;
use App\Http\Controllers\Masteradmin\EstimatesController;
use App\Http\Controllers\Masteradmin\SalesProductController;
use App\Http\Controllers\Masteradmin\PurchasProductController;
use App\Http\Controllers\Masteradmin\PurchasVendorController;
use App\Http\Controllers\Masteradmin\InvoicesController;
use App\Http\Controllers\Masteradmin\EmployeesController;
use App\Http\Controllers\Masteradmin\ChartOfAccountController;
use App\Http\Controllers\Masteradmin\RecurringInvoicesController;
use App\Http\Controllers\Masteradmin\BillsController;
use App\Http\Controllers\Masteradmin\TransectionController;


/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
global $adminRoute;
$adminRoute = config('global.superAdminURL');
$busadminRoute = config('global.businessAdminURL');

Route::group(['prefix' => $adminRoute], function () {
  
    Route::middleware(['auth', 'guard.session:web', 'prevent.back.history'])->group(function () {
     
        Route::get('/dashboard', [HomesController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');
    
        //profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //Subscription Plans
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('/plans/store', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/edit/{plan}', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/update/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/destroy/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
        Route::get('/plans/planrole/{plan}', [PlanController::class, 'planrole'])->name('plans.planrole');
        Route::put('/plans/updaterole/{plan}', [PlanController::class, 'updaterole'])->name('plans.updaterole');
        
        Route::get('/businessdetails', [BusinessDetailController::class, 'index'])->name('businessdetails.index');
        Route::get('/businessdetails/{id}', [BusinessDetailController::class, 'show'])->name('businessdetails.show');
        Route::post('/business-detail/{id}/update-status', [BusinessDetailController::class, 'updateStatus'])->name('business.updateStatus');

        //logs
        Route::get('/logActivity', [ProfileController::class, 'logActivity'])->name('adminlog.index');
        
    });
});

Route::group(['prefix' => $busadminRoute], function () {
    
    Route::middleware(['masteradmin'])->group(function () {
        //login and register
        Route::get('login', [LoginController::class, 'create'])->name('business.login');
        Route::get('register', [RegisterController::class, 'create'])->name('business.register');
        Route::post('register', [RegisterController::class, 'store'])->name('business.register.store');
        Route::post('login', [LoginController::class, 'store'])->name('business.login.store');
        Route::get('forgot-password', [MasterPasswordResetLinkController::class, 'create'])
                        ->name('business.password.request');
        Route::post('forgot-password', [MasterPasswordResetLinkController::class, 'store'])
                        ->name('business.password.email');
        Route::get('reset-password/{token}', [MasterNewPasswordController::class, 'create'])
                        ->name('business.password.reset');
        Route::post('reset-password', [MasterNewPasswordController::class, 'store'])
                        ->name('business.password.store');

        //user change password
        Route::get('/users/change-password', [UserController::class, 'changePassword'])
        ->name('business.userdetail.changePassword');
        
        Route::post('/users/store-password/{user_id}', [UserController::class, 'storePassword'])
        ->name('business.userdetail.storePassword');
        
        Route::get('/estimate/send/view/{id}/{slug}', [EstimatesController::class, 'sendView'])
        ->name('business.estimate.sendview');

        Route::get('/invoice/send/view/{id}/{slug}', [InvoicesController::class, 'sendView'])
        ->name('business.invoices.sendview');
    });

    Route::middleware(['auth_master','set.user.details', 'guard.session:masteradmins', 'prevent.back.history'])->group(function () {
        
        //profile
        Route::get('/dashboard', [HomeController::class, 'create'])->name('business.home');
        Route::get('/profile', [ProfilesController::class, 'edit'])->name('business.profile.edit');
        Route::patch('/profile', [ProfilesController::class, 'update'])->name('business.profile.update');
        Route::delete('/profile', [ProfilesController::class, 'destroy'])->name('business.profile.destroy');
        Route::get('states/{countryId}', [ProfilesController::class, 'getStates'])->name('business.profile.destroy');
        Route::put('password', [MasterPasswordController::class, 'update'])->name('business.password.update');
        Route::post('logout', [LoginController::class, 'destroy'])->name('business.logout');
        //create alter database
        Route::get('/create-table', [Controller::class, 'createTableRoute']);

        //Business Profile
        Route::get('/business-profile', [ProfilesController::class, 'businessProfile'])->name('business.business.edit');
        Route::patch('/business-profile-update', [ProfilesController::class, 'businessProfileUpdate'])->name('business.business.update');
        Route::patch('/business-profile-edit', [ProfilesController::class, 'updateBusinessDetails'])->name('business.business.edits');

        //Log Activity
        Route::get('/logActivity', [ProfilesController::class, 'logActivity'])->name('business.masterlog.index');
        
        // //exp plan or not plan purchase
        // Route::get('/plan/purchase', [ProfilesController::class, 'purchase'])->name('business.plan.purchase');
        
        //User Role
        Route::get('user-role-details', [UserRoleController::class, 'index'])->name('business.role.index');
        Route::get('rolecreate', [UserRoleController::class, 'create'])->name('business.role.create');
        Route::post('roleadd', [UserRoleController::class, 'store'])->name('business.role.store');
        Route::get('roleedit/{role}', [UserRoleController::class, 'edit'])->name('business.role.edit');
        Route::patch('roleupdate/{role}', [UserRoleController::class, 'update'])->name('business.role.update');
        Route::delete('roledestroy/{role}', [UserRoleController::class, 'destroy'])->name('business.role.destroy');
        Route::get('userrole/{userrole}', [UserRoleController::class, 'userrole'])->name('business.role.userrole');
        Route::put('updaterole/{userrole}', [UserRoleController::class, 'updaterole'])->name('business.role.updaterole');
               
        //saletax
        Route::get('/salestax', [SalesTaxController::class, 'index'])->name('business.salestax.index');
        Route::get('/taxcreate', [SalesTaxController::class, 'create'])->name('business.salestax.create');
        Route::post('/taxstore', [SalesTaxController::class, 'store'])->name('business.salestax.store');
        Route::get('/taxedit/{SalesTax}', [SalesTaxController::class, 'edit'])->name('business.salestax.edit');
        Route::patch('/taxupdate/{SalesTax}', [SalesTaxController::class, 'update'])->name('business.salestax.update');
        Route::delete('/taxdestroy/{salestax}', [SalesTaxController::class, 'destroy'])->name('business.salestax.destroy');

        // add by dx....master user details
        Route::get('/userdetails', [UserController::class, 'index'])->name('business.userdetail.index');
        Route::get('/usercreate', [UserController::class, 'create'])->name('business.userdetail.create');
        Route::post('/userstore', [UserController::class, 'store'])->name('business.userdetail.store');
        Route::get('/useredit/{userdetaile}', [UserController::class, 'edit'])->name('business.userdetail.edit');
        
        Route::patch('/userupdate/{userdetail}', [UserController::class, 'update'])->name('business.userdetail.update');
        Route::delete('/userdestroy/{userdetail}', [UserController::class, 'destroy'])->name('business.userdetail.destroy');
// Route for updating user role status
Route::post('/userrole/{id}/update-status', [UserController::class, 'updateStatus'])->name('business.userrole.updateStatus');

        //salesCustomer...
        Route::get('/salescustomers', [SalesCustomersController::class, 'index'])->name('business.salescustomers.index');
        Route::get('/customercreate', [SalesCustomersController::class, 'create'])->name('business.salescustomers.create');
        Route::post('/customerstore', [SalesCustomersController::class, 'store'])->name('business.salescustomers.store');
        Route::get('/customeredit/{SalesCustomers}', [SalesCustomersController::class, 'edit'])->name('business.salescustomers.edit');
        Route::patch('/customerupdate/{SalesCustomers}', [SalesCustomersController::class, 'update'])->name('business.salescustomers.update');
        Route::delete('/customerdestroy/{SalesCustomers}', [SalesCustomersController::class, 'destroy'])->name('business.salescustomers.destroy');
        Route::get('getstates/{country_id}', [SalesCustomersController::class, 'getstates'])->name('get.states');
        Route::get('/get-customer-info', [SalesCustomersController::class, 'getCustomerInfo'])->name('business.salescustomers.getCustomerInfo');
        Route::get('/customerdetails/{sale_cus_id}', [SalesCustomersController::class, 'show'])->name('business.customerdetails.show');
        Route::post('/pay/store/{sale_cus_id}', [SalesCustomersController::class, 'paymentstore'])->name('business.customerdetails.paymentsstore');

        //estimates
        Route::get('/estimates-list', [EstimatesController::class, 'index'])->name('business.estimates.index');
        Route::get('/create-estimates', [EstimatesController::class, 'create'])->name('business.estimates.create');
        Route::get('/get-product-details/{id}', [EstimatesController::class, 'getProductDetails'])->name('business.estimates.getProductDetails');
        Route::post('/estimates-store', [EstimatesController::class, 'store'])->name('business.estimates.store');
        Route::get('/edit-estimates/{id}', [EstimatesController::class, 'edit'])->name('business.estimates.edit');
        Route::patch('/update-estimates/{estimates_id}', [EstimatesController::class, 'update'])->name('business.estimates.update');
        Route::delete('/estimatesdestroy/{id}', [EstimatesController::class, 'destroy'])->name('business.estimates.destroy');
        Route::put('salescustomers/{sale_cus_id}', [EstimatesController::class, 'updateCustomer'])->name('salescustomers.update');
        Route::get('salescustomers/list', [EstimatesController::class, 'listCustomers'])->name('salescustomers.list');
        Route::patch('/estimates/menu/update', [EstimatesController::class, 'menuUpdate'])->name('estimatemenus.update');
        Route::get('/estimates/menu/list', [EstimatesController::class, 'getMenuSessionData'])->name('estimatemenus.menulist');
        Route::get('/view-estimates/{id}', [EstimatesController::class, 'view'])->name('business.estimates.view');
        Route::get('/duplicate-estimates/{id}', [EstimatesController::class, 'duplicate'])->name('business.estimates.duplicate');
        Route::patch('/duplicate-estimates-store/{id}', [EstimatesController::class, 'duplicateStore'])->name('business.estimates.duplicateStore');
        Route::post('/estimates-status-store/{id}', [EstimatesController::class, 'statusStore'])->name('business.estimates.statusStore');
        Route::get('/estimate/send/{id}/{slug}', [EstimatesController::class, 'send'])
        ->name('business.estimate.send');

        Route::get('/preview-estimates', [EstimatesController::class, 'preview'])->name('business.estimates.preview');
        Route::get('/estimate/send/views/{id}/{slug}', [EstimatesController::class, 'authsendView'])
        ->name('business.estimate.sendviews');
        

        //sales product
        Route::get('/salesproduct', [SalesProductController::class, 'index'])->name('business.salesproduct.index');
        Route::get('/productcreate', [SalesProductController::class, 'create'])->name('business.salesproduct.create');
        Route::post('/salesproductstore', [SalesProductController::class, 'store'])->name('business.salesproduct.store');
        Route::get('/productedit/{SalesProduct}', [SalesProductController::class, 'edit'])->name('business.salesproduct.edit');
        Route::patch('/productupdate/{SalesProduct}', [SalesProductController::class, 'update'])->name('business.salesproduct.update');
        Route::delete('/productdestroy/{salesproduct}', [SalesProductController::class, 'destroy'])->name('business.salesproduct.destroy');
        Route::get('productgetstates/{country_id}', [SalesProductController::class, 'productStates'])->name('get.states');


        //purchase product
        Route::get('/purchasesproduct', [PurchasProductController::class, 'index'])->name('business.purchasproduct.index');
        Route::get('/purchasesproductcreate', [PurchasProductController::class, 'create'])->name('business.purchasproduct.create');
        Route::post('/purchasesproductstore', [PurchasProductController::class, 'store'])->name('business.purchasproduct.store');
        Route::get('/purchasesproductedit/{PurchasesProduct}', [PurchasProductController::class, 'edit'])->name('business.purchasproduct.edit');
        Route::patch('/purchasesproductupdate/{PurchasesProduct}', [PurchasProductController::class, 'update'])->name('business.purchasproduct.update');
        Route::delete('/purchasesproductdestroy/{PurchasesProduct}', [PurchasProductController::class, 'destroy'])->name('business.purchasproduct.destroy');
      //   Route::get('getstates/{country_id}', [PurchasProductController::class, 'productStates'])->name('get.states');

        //purchase vendor
        Route::get('/purchasesvendor', [PurchasVendorController::class, 'index'])->name('business.purchasvendor.index');
        Route::get('/purchasesvendorcreate', [PurchasVendorController::class, 'create'])->name('business.purchasvendor.create');
        Route::post('/purchasesvendorstore', [PurchasVendorController::class, 'store'])->name('business.purchasvendor.store');
        Route::get('/purchasesvendoredit/{PurchasesVendor}', [PurchasVendorController::class, 'edit'])->name('business.purchasvendor.edit');
        Route::patch('/purchasesvendorupdate/{PurchasesVendor}', [PurchasVendorController::class, 'update'])->name('business.purchasvendor.update');
        Route::delete('/purchasesvendordestroy/{PurchasesVendor}', [PurchasVendorController::class, 'destroy'])->name('business.purchasvendor.destroy');
        Route::get('/vendordetails/{id}', [PurchasVendorController::class, 'show'])->name('business.vendordetails.show');
        Route::post('/purchasvendor/addBankDetails', [PurchasVendorController::class, 'addBankDetails'])->name('business.purchasvendor.addBankDetails');
        Route::post('/purchasvendor/addBankDetails/{PurchasesVendor}', [PurchasVendorController::class, 'addBankDetails'])->name('business.purchasvendor.addBankDetails');
        Route::get('vendorgetstates/{country_id}', [PurchasVendorController::class, 'vendorStates'])->name('get.states');
        Route::get('/purchasesvendorviewBankDetails/{purchases_vendor_id}', [PurchasVendorController::class, 'viewBankDetails'])->name('business.purchasvendor.viewBankDetails');
            // payroll employee...

            Route::get('/employee', [EmployeesController::class, 'index'])->name('business.employee.index');
            Route::get('/employeecreate', [EmployeesController::class, 'create'])->name('business.employee.create');
            Route::post('/employeestore', [EmployeesController::class, 'store'])->name('business.employee.store');
            // Route::get('/employeeedit', [EmployeesController::class, 'edit'])->name('business.employee.edit');
            Route::get('/employeeedit/{employee}', [EmployeesController::class, 'edit'])->name('business.employee.edit');
            Route::Patch('employees/{emp_id}', [EmployeesController::class, 'update'])->name('business.employee.update');
            Route::Patch('/employees/{id}/compensation', [EmployeesController::class, 'storeCompensation'])->name('employees.storeCompensation');
            Route::post('/employees/{emp_id}/taxdetails', [EmployeesController::class, 'storeTaxDetails'])->name('employees.storeTaxDetails');
// routes/web.php

Route::post('employee/{emp_id}/offboarding/store', [EmployeesController::class, 'storeOffboarding'])
    ->name('employee.offboarding.store');
// routes/web.php

// routes/web.php
Route::post('employee/offboarding/leave/{emp_id}', [EmployeesController::class, 'storeLeaveData'])
    ->name('employee.offboarding.leave');
    Route::delete('employee/{id}', [EmployeesController::class, 'destroy'])->name('business.employee.destroy');


           

        //invoice
        Route::get('/edit-invoice/{id}', [EstimatesController::class, 'viewInvoice'])->name('business.estimates.viewInvoice');
        Route::patch('/invoice-store/{id}', [InvoicesController::class, 'invoiceStore'])->name('business.invoices.invoiceStore');
        Route::get('/view-invoice/{id}', [InvoicesController::class, 'view'])->name('business.invoices.view');
        Route::post('/invoice-status-store/{id}', [InvoicesController::class, 'statusStore'])->name('business.invoices.statusStore');
        Route::get('/edit_invoices/{id}', [InvoicesController::class, 'edit'])->name('business.invoices.edit');
        Route::get('/invoice/send/{id}/{slug}', [InvoicesController::class, 'send'])
        ->name('business.invoices.send');
        Route::delete('/invoicedestroy/{id}', [InvoicesController::class, 'destroy'])->name('business.invoices.destroy');
        Route::get('/invoice/send/views/{id}/{slug}', [InvoicesController::class, 'authsendView'])
        ->name('business.invoices.sendviews');
        Route::get('/create-invoice', [InvoicesController::class, 'create'])->name('business.invoices.create');
        Route::patch('/update-invoice/{invoices_id}', [InvoicesController::class, 'update'])->name('business.invoices.update');
        Route::post('/invoice-store', [InvoicesController::class, 'store'])->name('business.invoices.store');
        Route::patch('/invoice/menu/update', [InvoicesController::class, 'menuUpdate'])->name('invoicesmenus.update');
        Route::get('/invoice/menu/list', [InvoicesController::class, 'getMenuSessionData'])->name('invoicesmenus.menulist');
        Route::get('/duplicate-invoice/{id}', [InvoicesController::class, 'duplicate'])->name('business.invoices.duplicate');
        Route::patch('/duplicate-invoice-store/{id}', [InvoicesController::class, 'duplicateStore'])->name('business.invoices.duplicateStore');
        Route::get('/invoice-list', [InvoicesController::class, 'index'])->name('business.invoices.index');
        Route::post('/payments/store/{id}', [InvoicesController::class, 'paymentstore'])->name('business.payments.paymentstore');

        });

        // chart of account..
        Route::get('/chartofaccount', [ChartOfAccountController::class, 'index'])->name('business.chartofaccount.index');
        Route::post('/chart-of-account/store', [ChartOfAccountController::class, 'store'])->name('business.chartofaccount.store');
        Route::get('/chartofaccount/edit/{acc_type_id}', [ChartOfAccountController::class, 'edit'])->name('business.chartofaccount.edit');
        Route::patch('/chartofaccount/update/{account}', [ChartOfAccountController::class, 'update'])->name('business.chartofaccount.update');
        
        //recurring invoices
        Route::get('/recurring-invoice-list', [RecurringInvoicesController::class, 'index'])->name('business.recurring_invoices.index');
        Route::get('/create-recurring-invoice', [RecurringInvoicesController::class, 'create'])->name('business.recurring_invoices.create');
        Route::post('/create-recurring-store', [RecurringInvoicesController::class, 'store'])->name('business.recurring_invoices.store');
        Route::get('/edit-recurring-invoices/{id}', [RecurringInvoicesController::class, 'edit'])->name('business.recurring_invoices.edit');
        Route::patch('/update-recurring-invoice/{reinvoices_id}', [RecurringInvoicesController::class, 'update'])->name('business.recurring_invoices.update');
        Route::get('/view-recurring-invoice/{id}', [RecurringInvoicesController::class, 'view'])->name('business.recurring_invoices.view');
        Route::get('/duplicate-recurring-invoice/{id}', [RecurringInvoicesController::class, 'duplicate'])->name('business.recurring_invoices.duplicate');
        Route::patch('/duplicate-recurring-invoice-store/{id}', [RecurringInvoicesController::class, 'duplicateStore'])->name('business.recurring_invoices.duplicateStore');
        Route::patch('/recurring-invoice-store/set_schedule/{id}', [RecurringInvoicesController::class, 'setScheduleStore'])->name('business.recurring_invoices.setScheduleStore');
        Route::get('/recurring-invoice-store/invoice/{id}', [RecurringInvoicesController::class, 'recurringinvoiceStore'])->name('business.recurring_invoices.recurringinvoiceStore');
        Route::patch('/reinvoice/menu/update', [RecurringInvoicesController::class, 'menuUpdate'])->name('reinvoicesmenus.update');
        Route::get('/reinvoice/menu/list', [RecurringInvoicesController::class, 'getMenuSessionData'])->name('reinvoicesmenus.menulist');


        //bills
        Route::get('/bill-list', [BillsController::class, 'index'])->name('business.bill.index');
        Route::get('/create-bill', [BillsController::class, 'create'])->name('business.bill.create');
        Route::get('/bill/get-product-details/{id}', [BillsController::class, 'getProductDetails'])->name('business.bill.getProductDetails');
        Route::post('/create-bill-store', [BillsController::class, 'store'])->name('business.bill.store');
        Route::get('/edit-bill/{id}', [BillsController::class, 'edit'])->name('business.bill.edit');
        Route::patch('/update-bill/{id}', [BillsController::class, 'update'])->name('business.bill.update');
        Route::delete('/bill-destroy/{id}', [BillsController::class, 'destroy'])->name('business.bill.destroy');
        Route::get('/view-bill/{id}', [BillsController::class, 'view'])->name('business.bill.view');
        Route::get('/duplicate-bill/{id}', [BillsController::class, 'duplicate'])->name('business.bill.duplicate');
        Route::patch('/duplicate-bill-store/{id}', [BillsController::class, 'duplicateStore'])->name('business.bill.duplicateStore');
        Route::get('/add-bill/{id}', [BillsController::class, 'create'])->name('business.bill.add');
        Route::post('/paybill/store/{id}', [BillsController::class, 'paymentstore'])->name('business.bill.paymentsbillstore');

//transection...
Route::get('/transection-list', [TransectionController::class, 'index'])->name('business.transection.index');
Route::get('/transactions/filter', [TransectionController::class, 'filterTransactions'])->name('transactions.filter');
Route::get('/edit-transactions', [TransectionController::class, 'edit'])->name('business.transactions.edit');


});

require __DIR__.'/auth.php';
