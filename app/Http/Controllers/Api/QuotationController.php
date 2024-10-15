<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\QuotationResource;
use App\Repositories\QuotationRepository;
use Illuminate\Http\Request;

class QuotationController extends Controller
{

    private $quotationRepository;

    public function __construct(QuotationRepository $quotationRepository)
    {
        $this->quotationRepository=$quotationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resp = $this->quotationRepository->quotationList();

        return new QuotationResource($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $resp = $this->quotationRepository->store_quotation($request);

        return response()->json(['message' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resp =  $this->quotationRepository->show_quotation($id);

        return response()->json(['data' => $resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $resp = $this->quotationRepository->update_quotation($request, $id);

        return new QuotationResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function create_quotation()  {
        
        $resp = $this->quotationRepository->create_quotation();

        return response()->json($resp);
    }


    public function delete_quotations_items($id) {
        
        $resp = $this->quotationRepository->deleteQuotationItems($id);

        return response()->json(['message' => 'Le produit a été supprimer de la commande',], 200);
    }

    public function accept_quotation($id) {
        
        $resp = $this->quotationRepository->accept_quotation($id);

        return response()->json(['message' => 'success',], 200);
    }

    public function refund_quotation($id) {
        
        $resp = $this->quotationRepository->refund_quotation($id);

        return response()->json(['message' => 'success',], 200);
    }
}
