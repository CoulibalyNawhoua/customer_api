<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PurchaseResource;
use App\Repositories\InvoiceRepository;

class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }


    public function store_invoice(Request $request){

        $resp = $this->invoiceRepository->store_invoice($request);

        
        return new PurchaseResource($resp);

    }

    public function view_invoice($id) {
        
        $resp = $this->invoiceRepository->view_invoice($id);

        return response()->json(['data' => $resp]);
    }

    public function delete_invoice_items($id) {
        
        $resp = $this->invoiceRepository->deleteInvoiceItems($id);

        return response()->json(['message' => 'Le produit a été supprimer de la commande',], 200);
    }


    public function update_invoice(Request $request, $id) {
        
        $resp = $this->invoiceRepository->update_invoice($request, $id);

        return new PurchaseResource($resp);
    }


    public function create_invoice()  {
        
        $formData = $this->invoiceRepository->create_invoice();

        return response()->json($formData);
    }

}
