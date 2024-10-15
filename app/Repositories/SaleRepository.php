<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class SaleRepository extends Repository
{
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    

    public function saleList () {
        

        // $debutSemaine = Carbon::now()->startOfWeek();
        // $finSemaine = Carbon::now();

        // $no = 1;
        // $data = [];

        // while ($debutSemaine <= $finSemaine) {

        //     $date = $debutSemaine ;

        //     $total_sale = Sale::where('is_deleted', 0)
        //                         ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
        //                         ->sum('total_amount');
            
        //     $row = [];

        //     $row['DT_RowIndex'] = $no++;
        //     $row['date'] = Date::parse($date)->locale('fr')->isoFormat('LL') ;
        //     $row['total_sale'] = $total_sale;

        //     $data[] = $row;

        //     $debutSemaine->addDay();
        // }

        $query = Sale::selectRaw('sales.add_date, sales.sale_date, sales.reference, sales.total_amount, sales.paid_amount, sales.due_amount, sales.payment_status, sales.status, warehouses.warehouse_name, CONCAT(users.first_name," ",users.last_name) as auteur, customers.full_name as customer, sales.uuid, sales.id')
                ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
                ->leftJoin('users', 'users.id', '=', 'sales.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'sales.warehouse_id')
                ->where('sales.is_deleted', 0)
                ->get();

        return $query;
    }

    public function warehouse_sales () {

        $warehouse_id = Auth::user()->warehouse->id  ;
    
        $query = Sale::selectRaw('sales.add_date, sales.sale_date, sales.reference, sales.total_amount')
                ->where('warehouse_id', $warehouse_id)
                ->where('sales.is_deleted', 0)
                ->get();
    
        return $query;
    }

    public function sum_warehouse_week_sales() {
        
        $warehouse_id = Auth::user()->warehouse->id  ;

        // $now = Carbon::now();

        // $startOfWeek = $now->startOfWeek()->format('Y-m-d');
        // $endOfWeek = $now->endOfWeek()->format('Y-m-d');
    
        // $query = Sale::where('warehouse_id', $warehouse_id)
        //         ->where('is_deleted', 0)
        //         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        //         ->groupBy(DB::raw('WEEK(created_at)'))
        //         ->sum('total_amount');
    
        // return $query;

        $debutSemaine = Carbon::now()->startOfWeek();
        $finSemaine = Carbon::now();

        $no = 1;
        $data = [];

        while ($debutSemaine <= $finSemaine) {

            $date = $debutSemaine ;

            $total_sale = Sale::where('is_deleted', 0)
                                ->where('warehouse_id', $warehouse_id)
                                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                                ->sum('total_amount');
            
            $row = [];

            $row['DT_RowIndex'] = $no++;
            $row['date'] = Date::parse($date)->format('Y-m-d') ;
            $row['total_sale'] = $total_sale;

            $data[] = $row;

            $debutSemaine->addDay();
        }

        return $data;
    }

    public function invoiceReport () {
        
        $query = Sale::selectRaw('sales.add_date, sales.reference, sales.total_amount, sales.paid_amount, sales.due_amount, sales.payment_status, sales.status, warehouses.warehouse_name, CONCAT(users.first_name," ",users.last_name) as auteur, CONCAT(customers.first_name," ",customers.last_name) as customer, sales.uuid, sales.id')
                ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
                ->leftJoin('users', 'users.id', '=', 'sales.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'sales.warehouse_id')
                ->get();

        return $query;

    }

        public function store_sale(Request $request)  {
        
        
            $product_id = $request->input("product_id");
            $quantity = $request->input("quantity");
            $unit_price = $request->input("unit_price");
            $reference = $request->input("reference");

            $warehouse_id = Auth::user()->warehouse->id  ;

            $sale = Sale::where('reference', $reference)
                            ->where('warehouse_id', $warehouse_id)
                            ->first();



                   

            if (is_null($sale) ) {

                
            $productStck = ProductWarehouse::where('warehouse_id', $warehouse_id)
                ->where('product_id', $product_id)
                ->first();
                
                $newSale = Sale::create([
                    'reference' =>  $reference,
                    'warehouse_id' => $warehouse_id,
                    'sale_date' => Carbon::now(),
                    'added_by' => Auth::user()->id,
                    'add_ip' => $this->getIp()
                ]);

                SaleProduct::create([
                    'quantity' => $quantity,
                    
                    'product_id' => $product_id,
                    'unit_price' => $unit_price,
                    'sale_id' => $newSale->id
                ]);

              

                $productStck->decrement('quantity', $quantity);

                $newSale->increment('total_amount', $unit_price);

            

                if ($productStck->quantity < 0) {
                    $productStck->update(['quantity' => 0]);
                }
            } 
            else {

                
                $productStck = ProductWarehouse::where('warehouse_id', $warehouse_id)
                    ->where('product_id', $product_id)
                    ->first();

                SaleProduct::create([
                    'quantity' => $quantity,
                    'product_id' => $product_id,
                    'unit_price' => $unit_price,
                    'sale_id' => $sale->id
                ]);

                $productStck->decrement('quantity', $quantity);

                $sale->increment('total_amount', $unit_price );

                if ($productStck->quantity < 0) {
                    $productStck->update(['quantity' => 0]);
                }
            }
    
            return $reference;
    
        }
    
        // public function view_sale($id) {
            
        //     $sale = Sale::where('id', $id)->with(['customer','sale_items.product'])->first();
    
        //     return $sale;
        // }

        // public function edit_sale($id) {
            
        //     $sale = Sale::where('id', $id)->with(['customer','sale_items.product'])->first();
    
        //     return $sale;
        // }

        
        public function deleteSaleItems($id) {
    
            return  Sale::find($id)->delete();
        }


    public function saleRaport() {
        
        $query = Sale::selectRaw('sales.sale_date, sales.reference, sales.total_amount, sales.paid_amount, sales.due_amount, sales.payment_status, sales.status, warehouses.warehouse_name, CONCAT(users.first_name," ",users.last_name) as auteur, CONCAT(customers.first_name," ",customers.last_name) as customer, sales.uuid, sales.id')
                ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
                ->leftJoin('users', 'users.id', '=', 'sales.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'sales.warehouse_id')
                ->where('sales.is_deleted', 0)
                ->get();

        return $query;
    }




    public function count_warehouse_sales() {
        
        $warehouse_id = Auth::user()->warehouse->id  ;

        $saleCount = Sale::where('warehouse_id', $warehouse_id)->count();

        $code = $this->genererCode('Sale');

        return $code.$saleCount;

    }

    // public function warehouse_sale_product(Request $request) {
        
    //     $reference = $request->reference;

    //       $warehouse_id = Auth::user()->warehouse->id  ;


    //     $sale = Sale::where('reference', $reference)
    //                 ->where('warehouse_id', $warehouse_id)
    //                 ->first();

    //     $sale_items = SaleProduct::selectRaw('products.designation, sales_products.quantity, sales_products.unit_price')
    //                     ->leftJoin('products', 'products.id', '=', 'sales_products.product_id')
    //                     ->where('sales_products.sale_id', $sale->id)
    //                     ->get();
        
    //     return $sale_items;
    // }


    public function warehouse_sale_product($reference) {
        
        // $reference = $request->reference;

        $warehouse_id = Auth::user()->warehouse->id  ;


        $sale = Sale::where('reference', $reference)
                    ->where('warehouse_id', $warehouse_id)
                    ->firstOrFail();

        $sale_items = SaleProduct::selectRaw('products.designation, sales_products.quantity, sales_products.unit_price, products.image_url')
                        ->leftJoin('products', 'products.id', '=', 'sales_products.product_id')
                        ->where('sales_products.sale_id', $sale->id)
                        ->get();
        
        return $sale_items;
    }


    public function sum_warehouse_week_sales_detail($date) {
        

        $query = SaleProduct::selectRaw('products.designation, products.image_url, sales_products.quantity, sales_products.unit_price')
                            ->leftJoin('products', 'products.id', '=', 'sales_products.product_id')
                            ->where(DB::raw("(DATE_FORMAT(sales_products.created_at,'%Y-%m-%d'))"), $date)
                            ->get();

        return $query;
    }




}
