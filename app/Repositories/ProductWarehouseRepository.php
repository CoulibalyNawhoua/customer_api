<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductWarehouseRepository extends Repository
{
   
    public function __construct(ProductWarehouse $model)
    {
        $this->model=$model;
    }

    // public function productWarehouse(){
        
    //     $query = Product::selectRaw('products.designation, products.price, product_warehouse.quantity, products.image_url, products.id')
    //             ->leftJoin('product_warehouse', 'product_warehouse.product_id', '=', 'products.id')
    //             ->where('products.added_by', Auth::user()->id)
    //             ->where('products.warehouse_id', Auth::user()->warehouse->id)
    //             ->where('products.is_deleted', 0)
    //             ->whereNull('supplier_id')
    //             ->get();

    //     return $query;
    // }

    public function productWarehouse(){
        
        $query = ProductWarehouse::selectRaw('products.designation, product_warehouse.quantity, products.image_url, product_warehouse.product_id, product_warehouse.price, product_warehouse.id AS product_warehouse_id')
                ->leftJoin('products', 'products.id','=','product_warehouse.product_id')
                ->where('product_warehouse.warehouse_id', Auth::user()->warehouse->id)
                ->get();

        return $query;
    }


      //liste des produits fournisseurs pour l'affichage boutique
      public function supplierProduct() {
        
        $query = Product::selectRaw('designation, id, price, image_url')
                ->whereNotNull('supplier_id')
                ->where('is_deleted', 0)
                ->get();

        return $query;
    }


    public function update_product_warehouse(Request $request) {
        
    
        $product_id = $request->input('product_id');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $product_warehouse_id = $request->input('product_warehouse_id');

        $product_warehouse = ProductWarehouse::where('id', $product_warehouse_id)
                            ->where('warehouse_id', Auth::user()->warehouse->id)
                            ->where('product_id', $product_id)
                            ->first();


        $product_warehouse->update([
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $product_warehouse;
    }

}
