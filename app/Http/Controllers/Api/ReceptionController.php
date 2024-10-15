<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\ReceptionRepository;

class ReceptionController extends Controller
{
    
    private $receptionRepository;
    
    public function __construct(ReceptionRepository $receptionRepository)
    {
        $this->receptionRepository = $receptionRepository;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    //requete mobile
    public function store_receipt_order(Request $request)
    {
        $resp = $this->receptionRepository->store_receipt_order($request);

        return response()->json(['success' => 'Stock mit a jours']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
