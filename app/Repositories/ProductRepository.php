<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class ProductRepository extends Repository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }


    public function storeProduct(Request $request) {

        $designation = $request->designation;
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        $unit_id = $request->unit_id;
        $sku = $request->sku;
        $stock_alert = $request->stock_alert;
        $note = $request->note;
        $order_tax = $request->order_tax;
        $tax_type = $request->tax_type;
        $price = $request->price;
        $cost = $request->cost;
        $quantity = $request->quantity;
        $supplier_id = $request->supplier_id;

        
        $oldFile = '';
        $directory = 'produits';
        $fieldname = 'image';

        $data_file = $this->fileUpload($request, $fieldname, $directory, $oldFile);

        $image_url = $data_file;

        $warehouse_id = (Auth::user()->warehouse) ? Auth::user()->warehouse->id : NULL ;

        $product = Product::create([
            'designation' => Str::of($designation)->upper() ,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
            'unit_id' => $unit_id,
            'sku' => $sku,
            'stock_alert' => $stock_alert,
            'note' => $note,
            'order_tax' => $order_tax,
            'tax_type' => $tax_type,
            'price' => $price,
            'cost' => $cost,
            'warehouse_id' =>  $warehouse_id,
            'image_url' => $image_url,
            'quantity' => $quantity,
            'supplier_id' => $supplier_id,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
        ]);


        ProductWarehouse::create([
            'quantity' => $quantity,
            'product_id' => $product->id,
            'warehouse_id' => $warehouse_id,
            'price' =>  $price,
        ]);

        

        return $product;
    }


    public function productList(){

        $query = Product::leftJoin('brand', 'brand.id','=','products.brand_id')
                        ->leftJoin('category', 'category.id','=','products.category_id')
                        ->leftJoin('units', 'units.id','=','products.unit_id')
                        ->leftJoin('subcategory', 'subcategory.id','=','products.subcategory_id')
                        ->leftJoin('users', 'users.id','=','products.added_by')
                        ->leftJoin('suppliers', 'suppliers.id','=','products.supplier_id')
                        ->where('products.is_deleted', 0)
                        ->whereNull('products.warehouse_id');

        return $query->selectRaw('products.designation, products.price, category.name AS category, subcategory.name AS subcategory, brand.name AS brand, CONCAT(users.full_name) AS auteur, products.image_url, units.name AS unit, products.created_at, products.add_date, products.sku, products.id, suppliers.full_name AS supplier')->get();
        
    }

  
    public function selectSubCategoryByProduitCategory($id) {
        
        $product = $this->model->where('id', $id)->first();

        return SubCategory::where('category_id', $product->category_id)->get();
    }


    public function updateProduct(Request $request, $id) {

        $product = $this->model->find($id);

        $designation = $request->designation;
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        $unit_id = $request->unit_id;
        $sku = $request->sku;
        $stock_alert = $request->stock_alert;
        $note = $request->note;
        $order_tax = $request->order_tax;
        $tax_type = $request->tax_type;
        $price = $request->price;
        $cost = $request->cost;
        $supplier_id = $request->supplier_id;

        $oldFile =  ($product->image_url) ? $product->image_url : '' ; 
        $directory = 'produits';
        $fieldname = 'image';

        $data_file = $this->fileUpload($request, $fieldname, $directory,$oldFile);

        $image_url = $data_file;

        $product->update([
            'designation' => $designation == 'null' ? null  :  Str::of($designation)->upper() ,
            'category_id' =>  $category_id == 'null' ? null  : $category_id ,
            'subcategory_id' => $subcategory_id == 'null' ? null : $subcategory_id ,
            'unit_id' => $unit_id == 'null' ? null : $unit_id ,
            'sku' => $sku == 'null' ? null  : $sku,
            'stock_alert' =>  $stock_alert == 'null' ? null  : $stock_alert,
            'note' =>  $note == 'null' ? null  : $note,
            'order_tax' => $order_tax== 'null' ? null  : $order_tax,
            'tax_type' =>  $tax_type== 'null' ? null  : $tax_type,
            'price' => $price== 'null' ? null  : $price,
            'image_url' =>  $image_url== 'null' ? null  : $image_url,
            'cost' => $cost== 'null' ? null  : $cost,
            'supplier_id' => $supplier_id == 'null' ? null : $supplier_id ,
            'edited_by' => Auth::user()->id,
            'edit_ip' => $this->getIp(),
            'edit_date' => Carbon::now()
        ]);

        return $product;
        
    }
}
