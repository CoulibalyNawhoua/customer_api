<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SaleRepository;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Http\Resources\Api\SaleResource;
use App\Repositories\PurchaseRepository;
use App\Http\Resources\Api\PurchaseResource;

class ReportController extends Controller
{
    private $orderRepository, $purchaseRepository, $saleRepository;

    public function __construct(
        OrderRepository $orderRepository,
        PurchaseRepository $purchaseRepository,
        SaleRepository $saleRepository
        )
    {
        $this->orderRepository=$orderRepository;
        $this->purchaseRepository=$purchaseRepository;
        $this->saleRepository=$saleRepository;
    }

    public function sale_report() {
        
        $resp = $this->saleRepository->saleRaport();

        return SaleResource::collection($resp);

    }

    public function purchase_report()
    {
        $resp = $this->purchaseRepository->purchaseReport();

        return PurchaseResource::collection($resp);
    }

    public function order_report() {
        
        $resp = $this->orderRepository->orderReport();

        return OrderResource::collection($resp);
    }
}
