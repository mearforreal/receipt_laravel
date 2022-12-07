<?php

namespace App\Services;

use App\Enums\ReceiptTypeEnum;
use App\Models\Receipt;
use Carbon\Carbon;

class ReceiptService
{
    public function __construct()
    {
    }

    private function random_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    private function receiptIfhourIsEven(): array
    {
        $currentHour = Carbon::now()->format('H');

        if ((int)$currentHour % 2 == 0) {

            return ['type' => ReceiptTypeEnum::PRIZED, 'code' => $this->random_code(8)];
        }

        return ['type' => ReceiptTypeEnum::REGULAR, 'code' => null];
    }


    public function createNewReceipt($status, $user_id, $foto)
    {
        $newReceipt = new Receipt();

        $newReceipt->status = $status;
        $newReceipt->foto = $foto;
        $newReceipt->user_id = $user_id;

        // check is even
        $receiptTypeField = $this->receiptIfhourIsEven();

        $newReceipt->type = $receiptTypeField['type'];
        $newReceipt->code = $receiptTypeField['code'];

        $newReceipt->save();

        return $newReceipt;
    }
}
