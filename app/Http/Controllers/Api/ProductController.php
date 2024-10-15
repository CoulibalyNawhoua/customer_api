<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EditProductResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\SelectResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $resp = $this->productRepository->productList();

       return ProductResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|max:255',
        ]);

        $resp = $this->productRepository->storeProduct($request);

        return new ProductResource($resp);

        // return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
    }

    public function viewProduct($id)
    {
        $resp = $this->productRepository->view($id);

        return new EditProductResource($resp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required|max:255',
        ]);

        $resp = $this->productRepository->updateProduct($request, $id);

        // return new ProductResource($resp);

        return response()->json(['data' => $resp]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resp = $this->productRepository->delete($id);

        return new ProductResource($resp);
    }

    public function selectSubCategoryByProduitCategory($id)  {
        
        $resp = $this->productRepository->selectSubCategoryByProduitCategory($id);

        return SelectResource::collection($resp);
    }

    public function searchProduct(Request $request)  {
        
       
        $array = [];
        $q = $request->input('s');

        if ($q != null) {
            $products=Product::where('designation','LIKE', '%'.$q.'%')->get();
      
            foreach($products as $product){
                $array[ ] = [
                    "id"=> $product->id,
                    "designation" => $product->designation,
                    'cost' => $product->cost,
                    'price' => $product->price,
                    // 'quantity' => $product->quantity,
                    // 'image' => asset('storage/'.$product->image_url),
                ];
            }
        }
       
        return response()->json($array);
    }
}
