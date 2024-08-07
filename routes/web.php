<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\VehicleModelVariantController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\JobManagementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SalesProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/inquiries/status', [YourControllerName::class, 'getInquiriesByStatus'])->name('inquiries.by-status');


Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::resources([
        'dashboard'             => DashboardController::class,
        'profile'               => ProfileController::class,
        'vehicle-categories'    => VehicleCategoryController::class,
        'vehicle-types'         => VehicleTypeController::class,
        'vehicle-brands'        => VehicleBrandController::class,
        'vehicle-models'        => VehicleModelController::class,
        'vehicle-model-variants'=> VehicleModelVariantController::class,
        'branches'              => BranchController::class,
        'bay'                   => BayController::class,
        'users'                 => UserController::class,
        'customers'             => CustomerController::class,
        'roles'                 => RoleController::class,
        'roles-and-permissions' => RoleAndPermissionController::class,
        'products'              => ProductController::class,
        'product-categories'    => ProductCategoryController::class,
        'vehicles'              => VehicleController::class,
        'settings'              => SettingController::class,
        'coupons'               => CouponController::class,
        'inquiries'             => InquiryController::class,
        'inspection'            => InspectionController::class,
        'emails'                => EmailTemplateController::class,
        'carts'                 => CartController::class,
        'orders'                => OrderController::class,
        'reports'               => ReportsController::class,
        'jobs'                  => JobManagementController::class,
        'invoices'              => InvoiceController::class,
        'banners'               => BannerController::Class,
        'sales-products'        => SalesProductController::class,
        'services'              => ServiceController::class
    ]);
});

Route::get('/', function (){
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/* Routes for Ajax calls */
Route::post('get-vehicle-brand', [ VehicleModelController::class, 'getVehicleBrand']);  // get vechicle brands according to category
Route::post('get-vehicle-model', [ VehicleModelVariantController::class, 'getVehicleModel']); // get vechicle models according to category
Route::post('get-vehicle-model-variant', [ProductController::class, 'getVehicleModelVariant']); //get vehicle model variant through model.

Route::post('users/import', [UserController::class, 'import'])->name('users.import');  // import users csv file
Route::post('products/import', [ProductController::class, 'import'])->name('products.import');  // import products csv file
Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');  //import customers csv file

Route::post('general-setting',[SettingController::class, 'generalSetting'])->name('settings.general-setting');

Route::post('update-status', [OrderController::class, 'statusUpdate'])->name('update-status');

Route::get('download-product-sample', function () {
    $file = public_path('assets/sample-product/product.csv');
    return Response::download($file);
});
Route::get('download-customer-sample', function () {
    $file = public_path('assets/sample-customer/customer.csv');
    return Response::download($file);
});

// routes/web.php
Route::post('/save-event', [EventController::class, 'saveEvent']);

Route::post('/inquery-data', [InquiryController::class, 'inqueryInfo']);
Route::get('/fetch-data', [ReportsController::class, 'fetchData'])->name('fetch-data');
Route::post('/disable-branch',[BranchController::class,'disableBranch'])->name('disable-branch');

Route::post('/disable-bay',[BayController::class,'disableBay'])->name('disable-bay');

// route for inquery status update
Route::post('/inquiries/{id}/update-status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');

Route::post('/get-vehicle-name', [ReportsController::class, 'getVehicleName']);
Route::post('/get-vehicle_mileage', [ReportsController::class, 'getVehicleMileage']);
Route::post('/get-dob', [ReportsController::class, 'getDob']);
Route::get('/charts',[ReportsController::class,'showCharts'])->name('reports-chart');
Route::get('/chart-data',[ReportsController::class,'showLatestInqueries'])->name('chart-data');
Route::get('/inquiries/status', [ReportsController::class, 'getInquiriesByStatus'])->name('inquiries.by-status');


// route for inspection status  and licenceinfo update
Route::post('/inspection-data', [InspectionController::class, 'inqueryInfo']);
Route::post('/inspection/{id}/update-status', [InspectionController::class, 'updateStatus'])->name('inspection.update-status');

// route for job status  and licenceinfo update
Route::post('/job-data', [JobManagementController::class, 'jobInfo']);
Route::post('/jobs/{id}/update-status', [JobManagementController::class, 'updateStatus'])->name('jobs.update-status');

Route::post('/get-bay', [JobManagementController::Class, 'getBay']);
Route::get('/autocomplete', [InvoiceController::class,'autocomplete'])->name('autocomplete');
Route::get('/autocomplete-model', [ServiceController::class, 'autocompleteModel'])->name('autocomplete-model');
Route::get('/getProductDetails', [InvoiceController::class,'productDetails'])->name('getProductDetails');


//Download invoice pdf routes
// routes/web.php
Route::get('/download-invoice-pdf/{id}', [InvoiceController::class, 'downloadInvoicePdf'])->name('download-invoice-pdf');
