<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\AbilitiesController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\ReceptionController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PaymentTypeController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ActivityAreaController;
use App\Http\Controllers\Api\Auth\WebAuthController;
use App\Http\Controllers\Api\Auth\MobileAuthController;
use App\Http\Controllers\Api\ProductWarehouseController;
use App\Http\Controllers\Api\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'auth:api'],function(){
    // Route::group(['middleware'=>'jwt.verify'],function(){

    // Route::prefix('v1')->group(function () {

        Route::get('/warehouse-zone/{id}', [WarehouseController::class, 'warehouse_zone']);

        Route::get('/me', [WebAuthController::class, 'me']);
        Route::post('/web-user-auth-change-password', [WebAuthController::class, 'web_user_auth_change_password']);
       
        //category route
        Route::apiResource('categories', CategoryController::class);
        Route::get('category-select', [CategoryController::class,'categorySelect']);

        //subcategories route
        Route::apiResource('subcategories', SubCategoryController::class);
        Route::get('/categories/{category}/subcategories', [SubCategoryController::class,'selectSubCategoryByCategory']);

        //unit route
        Route::apiResource('units', UnitController::class);
        Route::get('unit-select', [UnitController::class,'unitSelect']);

        //product route
        Route::apiResource('products', ProductController::class);
        Route::get('/products/view/{id}', [ProductController::class,'viewProduct']);
        Route::get('/category/products/{id}/subcategories', [ProductController::class,'selectSubCategoryByProduitCategory']);
        Route::get('/product-search', [ProductController::class,'searchProduct']);
        
        //permission de l'utilisateur connecter si j'utilise spatie
        Route::apiResource('auth-permissions', AbilitiesController::class)->only(['index']);

        // Route::apiResource('sales', SaleController::class);
        // Route::get('/invoicereport', [SaleController::class, 'invoiceReport']);

        //facture pour une boutique
        Route::get('/create-invoice', [InvoiceController::class, 'create_invoice']);
        Route::post('/store-invoice', [InvoiceController::class, 'store_invoice']);
        Route::get('/view-invoice/{id}', [InvoiceController::class, 'view_invoice']);
        Route::delete('/delete-invoice-items/{id}', [InvoiceController::class, 'delete_invoice_items']);
        Route::put('/update-invoice/{id}', [InvoiceController::class, 'update_invoice']);

        //order route
        Route::get('/orders', [OrderController::class, 'order_list']);
        Route::get('/order-detail/{id}', [OrderController::class, 'order_detail']);
        Route::put('/accept-order/{id}', [OrderController::class, 'accept_order']);
        Route::put('/cancel-order/{id}', [OrderController::class, 'cancel_order']);
        Route::put('/mark-order-shipped/{id}', [OrderController::class, 'mark_order_shipped']);

        Route::apiResource('quotations', QuotationController::class);
        Route::get('/create-quotation', [QuotationController::class, 'create_quotation']);
        Route::delete('/delete-quotation-items/{id}', [QuotationController::class, 'delete_quotations_items']);
        Route::put('/accept-quotation/{id}', [QuotationController::class, 'accept_quotation']);
        Route::put('/refund-quotation/{id}', [QuotationController::class, 'refund_quotation']);

        // sale route 
        Route::get('/sales', [SaleController::class, 'sale_list']);
        // Route::get('/create-sale', [SaleController::class, 'create_sale']);
        // Route::post('/store-sale', [SaleController::class, 'store_sale']);
        // Route::get('/edit-sale/{id}', [SaleController::class, 'edit_sale']);
        // Route::delete('/delete-sale-items/{id}', [SaleController::class, 'delete_sale_items']);
        // Route::post('/update-sale/{id}', [SaleController::class, 'update_sale']);
        // Route::delete('/delete-sale/{id}', [SaleController::class, 'delete_sale']);
        // Route::get('/view-sale/{id}', [SaleController::class, 'view_sale']);

        //delivery route
        Route::post('/store-delivery', [DeliveryController::class, 'store_delivery']);
        Route::get('/deliveries', [DeliveryController::class, 'delivery_list']);
        Route::get('/view-delivery/{uuid}', [DeliveryController::class, 'view_delivery']);
        Route::delete('/delete-delivery/{id}', [DeliveryController::class, 'delete_delivery']);
        Route::get('/consult-delivery', [DeliveryController::class, 'consult_delivery']);
        Route::put('/mark-delivered/{id}', [DeliveryController::class, 'mark_delivered']);
        Route::put('/send-delivered/{id}', [DeliveryController::class, 'send_delivered']);
        Route::put('/cancel-delivered/{id}', [DeliveryController::class, 'cancel_delivered']);

        //supplier route
        Route::apiResource('suppliers', SupplierController::class);
        Route::get('/supplier/view/{id}', [SupplierController::class, 'viewSupplier']);
        Route::get('/supplier-select', [SupplierController::class, 'supplierSelect']);
        Route::get('/add-purchase-receipt', [SupplierController::class, 'add_purchase_receipt']);

        //user route
        Route::apiResource('users', UserController::class);
        Route::get('/users/view/{id}', [UserController::class, 'viewUser']);
        Route::put('/users/profile-update/{id}', [UserController::class, 'userProfileUpdate']);
        Route::put('/users/password-update/{id}', [UserController::class, 'userPasswordUpdate']);
        Route::put('/update-status-user/{id}', [UserController::class, 'updateStatusUser']);

        //gestion payment
        Route::apiResource('paymenttypes', PaymentTypeController::class);
        Route::put('/update-status-payment/{id}', [PaymentTypeController::class, 'updateStatusPayment']);


        //gestion des transaction
        Route::apiResource('transactions', TransactionController::class);
        Route::get('/create-transaction/{uuid}', [TransactionController::class, 'create_transation']);
       

        //gestion des devises
        Route::apiResource('currencies', CurrencyController::class);
        Route::put('/update-status-currency/{id}', [CurrencyController::class, 'updateStatusCurrency']);

        //gestions des secteurs d'activités
        Route::apiResource('activities', ActivityAreaController::class);
        Route::put('/update-status-activity/{id}', [ActivityAreaController::class,  'updateStatusActivity']);

        //zone de livraison
        Route::apiResource('zones', ZoneController::class);
        Route::put('/update-status-zone/{id}', [ZoneController::class, 'updateStatusZone']);

        //api rapport web
        Route::get('/salesreport', [ReportController::class, 'sale_report']);
        Route::get('/purchasereport', [ReportController::class, 'purchase_report']);
       
        //gestion boutique
        Route::get('/warehouses', [WarehouseController::class, 'warehouse_list']);
        Route::get('/warehouse-select', [WarehouseController::class, 'warehouse_select']);
        Route::get('/shop-select', [WarehouseController::class, 'shop_select']);

        //achat fournisseurs
        Route::apiResource('purchases', PurchaseController::class);
        Route::put('/update-purchase/{id}', [PurchaseController::class, 'update_purchase']);
        Route::get('/view-purchase/{id}', [PurchaseController::class, 'view_purchase']);
        Route::get('/create-purchase', [PurchaseController::class, 'create_purchase']);

        //Autorisation
        Route::apiResource('permissions', PermissionController::class);

        //rôle
        Route::apiResource('roles', RoleController::class);
        Route::put('/update-status-role/{id}', [RoleController::class, 'updateStatusRole']);
        Route::get('/select-role', [RoleController::class, 'select_role']);
        Route::get('/utilisateurs/{role}', [RoleController::class, 'getUtilisateursParRole']);

        //route pour verifier le token
        Route::post('/verify-token', [TokenController::class, 'verifyToken']);

        //settings

        Route::get('/test/{current_date}', [TestController::class, 'test']);
      
        /////////////////////api pour le mobile//////////////////////////////////

        //Gestion commande boutique
        Route::get('/order-warehouse', [OrderController::class, 'order_warehouse']);
        Route::post('/store-order', [OrderController::class, 'store_order']);
        Route::get('/view-order/{id}', [OrderController::class, 'view_order']);
        Route::delete('/delete-order-items/{id}', [OrderController::class, 'delete_order_items']);
        Route::post('/update-order/{id}', [OrderController::class, 'update_order']);
        Route::delete('/delete-order/{id}', [OrderController::class, 'delete_order']);
        Route::get('/order-history-received-warehouse', [OrderController::class, 'order_history_received_warehouse']);

        //client boutique
        Route::apiResource('customers', CustomerController::class);
        Route::get('/customers/view/{id}', [CustomerController::class, 'viewCustomer']);
        Route::get('/customer-select', [CustomerController::class, 'customer_select']);

        //details boutique
        Route::get('/user-warehouse', [WarehouseController::class, 'user_warehouse']);
        Route::post('/update-user-warehouse', [WarehouseController::class, 'update_user_warehouse']);

        //produit disponible dans les boutique
        Route::get('/product-warehouse', [ProductWarehouseController::class, 'product_warehouse']);
        Route::post('/update-product-warehouse', [ProductWarehouseController::class, 'update_product_warehouse']);

        //produit fournisseur
        Route::get('/supplier-product', [ProductWarehouseController::class, 'supplier_product']);

        //fournisseurs boutique
        Route::get('/suppliers-warehouse', [SupplierController::class, 'supplier_warehouse']);

        //selectionner les fournisseurs de la boutique
        Route::get('supplier-select-warehouse', [SupplierController::class, 'supplier_select_warehouse']);

        //reception de produit
        Route::post('store-receipt-order', [ReceptionController::class, 'store_receipt_order']);

        //price de livraison par zone
        Route::get('/warehouse-zone-price', [ZoneController::class, 'warehouse_zone_price']);

        Route::get('/count-warehouse-sales', [SaleController::class, 'count_warehouse_sales']);
        Route::post('/store-sale', [SaleController::class, 'store_sale']);
        Route::get('/warehouse-sale-product/{reference}', [SaleController::class, 'warehouse_sale_product']);
        Route::get('/warehouse-sales', [SaleController::class, 'warehouse_sales']);
        Route::get('/sum-warehouse-week-sales', [SaleController::class, 'sum_warehouse_week_sales']);
        Route::get('/sum-warehouse-week-sales-detail/{date}', [SaleController::class, 'sum_warehouse_week_sales_detail']);

        //refresh mobile token
        Route::post('mobile-auth-refresh', [MobileAuthController::class, 'mobile_auth_refresh']);
});

Route::get('activity-select', [ActivityAreaController::class,'activitySelect']);
Route::get('select-zone', [ZoneController::class,'select_zone']);

//controller de Authentification web
Route::post('/signin', [WebAuthController::class, 'signin']);
Route::post('/signup', [WebAuthController::class, 'signup']);

//controller authentification mobile
Route::post('/login', [MobileAuthController::class, 'mobile_login']);
Route::post('/register', [MobileAuthController::class, 'mobile_register']);

