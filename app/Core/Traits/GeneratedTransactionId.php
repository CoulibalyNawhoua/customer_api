<?php

namespace App\Core\Traits;

use App\Models\Transaction;
use Carbon\Carbon;

trait GeneratedTransactionId {

    public function transactionCode($table){
        $code_generer='';
        $random_int=random_int(000000000,999999999);
        $date = Carbon::now()->format('YmdHis');
        switch ($table) {
            case 'Transaction':
                $elt= Transaction::latest()->first() ?? new Transaction();
                $nombre_elt = $this->ajouter_zero_non_significatif((int)$elt->id +1, 2);
            break;
        }
        $code_generer=$random_int.$date;
        return $code_generer;
    }

}
