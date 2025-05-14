<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\EmployeeController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\StockController;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\Pos\PaymentController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
Route::get('/logout', [AdminController::class, 'AdminLogoutPage'])->name('admin.logout.page');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('update.password');


    /// Supplier All Route
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
        Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
        Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
        Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
        Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
        Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');

        Route::get('/supplier/invoice/report', 'SupplierInvoiceReport')->name('supplier.invoice.report');
        Route::get('/supplier/report/pdf', 'SupplierReportPdf')->name('supplier.report.pdf');

        Route::get('/supplier/product/report', 'SupplierProductReport')->name('supplier.product.report');
        Route::get('/supplier/product/pdf', 'SupplierProductPdf')->name('supplier.product.pdf');
    });

    // Customer All Route
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'CustomerAll')->name('customer.all');
        Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/update/customer/{id}', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');


        Route::get('/customer/invoice/report', 'CustomerInvoiceReport')->name('customer.invoice.report');
        Route::get('/customer/report/pdf', 'CustomerReportPdf')->name('customer.report.pdf');

        Route::get('/customer/product/report', 'CustomerProductReport')->name('customer.product.report');
        Route::get('/customer/product/pdf', 'CustomerProductPdf')->name('customer.product.pdf');
    });

    /// Employee All Route
    Route::controller(EmployeeController::class)->group(function () {

        Route::get('/all/employee', 'AllEmployee')->name('all.employee');
        Route::get('/add/employee', 'AddEmployee')->name('add.employee');
        Route::post('/store/employee', 'StoreEmployee')->name('employee.store');
        Route::get('/edit/employee/{id}', 'EditEmployee')->name('edit.employee');
        Route::post('/update/employee/{id}', 'UpdateEmployee')->name('employee.update');
        Route::get('/delete/employee/{id}', 'DeleteEmployee')->name('delete.employee');
    });

    // Unit All Route
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit/all', 'UnitAll')->name('unit.all');
        Route::get('/unit/add', 'UnitAdd')->name('unit.add');
        Route::post('/unit/store', 'UnitStore')->name('unit.store');
        Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
        Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
        Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');
    });

    // Category All Route
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'CategoryAll')->name('category.all');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
    });

    // Product All Route
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'ProductAll')->name('product.all');
        Route::get('/product/add', 'ProductAdd')->name('product.add');
        Route::post('/product/store', 'ProductStore')->name('product.store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::post('/product/update', 'ProductUpdate')->name('product.update');
        Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');
        Route::get('/barcode/product/{id}', 'BarcodeProduct')->name('barcode.product');
        Route::get('/import/product', 'ImportProduct')->name('import.product');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });

    // Purchase All Route
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/purchase/all', 'PurchaseAll')->name('purchase.all');
        Route::get('/purchase/add', 'PurchaseAdd')->name('purchase.add');
        Route::post('/purchase/store', 'PurchaseStore')->name('purchase.store');
        Route::get('/purchase/edit/{id}', 'PurchaseEdit')->name('purchase.edit');
        Route::put('/purchase/update/{id}', 'PurchaseUpdate')->name('purchase.update');
        Route::get('/purchase/delete/{id}', 'PurchaseDelete')->name('purchase.delete');

        Route::get('/print/purchase/invoice/{id}', 'PrintPurchaseInvoice')->name('print.purchaseinvoice');

        Route::get('/purchase/invoice/report', 'PurchaseInvoiceReport')->name('purchase.invoice.report');
        Route::get('/purchase/report/pdf', 'PurchaseReportPdf')->name('purchase.report.pdf');

        Route::get('/purchase/product/report', 'PurchaseProductReport')->name('purchase.product.report');
        Route::get('/purchase/product/pdf', 'PurchaseProductPdf')->name('purchase.product.pdf');
    });

    // Sale All Route
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/all', 'InvoiceAll')->name('invoice.all');
        Route::get('/retailsale/add', 'RetailsaleAdd')->name('retailsale.add');
        Route::post('/retailsale/store', 'RetailsaleStore')->name('retailsale.store');

        // Edit routes
        Route::get('invoice/{id}/edit', 'editInvoice')->name('invoice.edit');

        // Update routes
        Route::put('retailsale/{id}/update', 'updateRetailSale')->name('retailsale.update');
        Route::put('wholesale/{id}/update', 'updateWholesaleSale')->name('wholesale.update');




        Route::get('/wholesale/add', 'WholesaleAdd')->name('wholesale.add');
        Route::post('/wholesale/store', 'WholesaleStore')->name('wholesale.store');


        Route::get('/invoice/delete/{id}', 'InvoiceDelete')->name('invoice.delete');

        Route::get('/print/invoice/{id}', 'PrintInvoice')->name('print.invoice');

        Route::get('/sales/invoice/report', 'SalesInvoiceReport')->name('sales.invoice.report');
        Route::get('/sales/report/pdf', 'SalesReportPdf')->name('sales.report.pdf');

        Route::get('/sales/product/report', 'SalesProductReport')->name('sales.product.report');
        Route::get('/sales/product/pdf', 'SalesProductPdf')->name('sales.product.pdf');
    });

    // Default All Route
    Route::controller(DefaultController::class)->group(function () {

        Route::get('/get-product-details', 'getProductDetails')->name('get-product-details');
        Route::get('/get-customer-details/{customerId}', 'getCustomerDetails')->name('get-customer-details');
        Route::get('/check-product', 'GetStock')->name('check-product-stock');
    });

    // Stock All Route
    Route::controller(StockController::class)->group(function () {

        Route::get('/stock/report', 'StockReport')->name('stock.report');
        Route::get('/stock/report/pdf', 'StockReportPdf')->name('stock.report.pdf');
        Route::get('/stock/category/wise', 'StockCategoryWise')->name('stock.category.wise');
        Route::get('/category/wise/pdf', 'CategoryWisePdf')->name('category.wise.pdf');


        Route::get('/get-category', 'GetCategory')->name('get-category');
        Route::get('/get-product', 'GetProduct')->name('get-product');

        Route::get('/damage/add', 'DamageAdd')->name('damage.add');
        Route::post('/damage/store', 'DamageStore')->name('damage.store');

        Route::get('/damage/all', 'DamageAll')->name('damage.all');
        Route::get('damage/{id}/edit', 'editDamage')->name('damage.edit');
        Route::put('damage/{id}/update', 'updateDamage')->name('damage.update');
        Route::get('/damage/delete/{id}', 'DamageDelete')->name('damage.delete');
    });


    ///Pos All Route
    Route::controller(PosController::class)->group(function () {

        Route::get('/possale', 'PosSale')->name('pos.sale');
        Route::post('/possale/store', 'PosSaleStore')->name('possale.store');
    });


    ///payment All Route
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/customer/payment', 'customerPayment')->name('customer.payment');
        Route::post('/customer/payment/store', 'storeCustomerPayment')->name('customer.payment.store');
        Route::get('/get-customer-invoices/{customerId}', 'getCustomerInvoices');
        Route::get('/get-customer-details/{customerId}', 'getCustomerDetails');

        Route::get('/supplier/payment', 'supplierPayment')->name('supplier.payment');
        Route::post('/supplier/payment/store', 'storeSupplierPayment')->name('supplier.payment.store');
    });

    Route::get('lang/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'bn'])) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    })->name('lang.switch');
}); // End User Middleware
