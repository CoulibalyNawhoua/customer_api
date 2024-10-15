<?php

namespace App\Core\Traits;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\Quotation;
use App\Models\Reception;

trait GeneratedCodeTrait {

    public function genererCode($table){
        $code_generer='';
        $prefix='';
        $elt='';
        $nombre_elt='';
        $random_int=random_int(000000,999999);
        $date = Carbon::now()->format('m-Y');
        switch ($table) {
            case 'Product':
                $elt= Product::latest()->first() ?? new Product();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='PROD';
            break;

            case 'Category':
                $elt= Category::latest()->first() ?? new Category();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='CAT';
            break;
            case 'Purchase':
                $elt= Purchase::latest()->first() ?? new Purchase();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='CMDFOUR';
            break;
            case 'Delivery':
                $elt= Delivery::latest()->first() ?? new Delivery();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='BL';
            break;
            case 'Order':
                $elt= Order::latest()->first() ?? new Order();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='CMDCLI';
            break;
            case 'Sale':
                $elt= Sale::latest()->first() ?? new Sale();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='SA';
            break;
            case 'Quotation':
                $elt= Quotation::latest()->first() ?? new Quotation();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='DEVCLI';
            break;
            case 'Reception':
                $elt= Reception::latest()->first() ?? new Reception();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
                $prefix='RECEP';
            break;

        }
        $code_generer=$prefix.'-'.$random_int.$nombre_elt;
        return $code_generer;
    }


    function ajouter_zero_non_significatif($value, $threshold = null)
    {
        return sprintf("%0". $threshold . "s", $value);
    }

}
