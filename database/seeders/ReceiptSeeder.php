<?php

namespace Database\Seeders;

use App\Enums\ReceiptStatusEnum;
use App\Models\User;
use App\Services\ReceiptService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReceiptSeeder extends Seeder
{
    protected $receiptService;
    public function __construct(ReceiptService $receiptService)
    {

        $this->receiptService = $receiptService;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::limit(20)->get();
        foreach ($users as $user) {
            $field = [
                'status' => ReceiptStatusEnum::REJECTED,
                'foto' => Str::random(10),
            ];
            $this->receiptService->createNewReceipt($field['status'], $user->id, $field['foto']);
        }
        //
    }
}
