<?php

namespace App\Models;

use App\Enums\ReceiptStatusEnum;
use App\Enums\ReceiptTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'type',
        'code',
        'status',
        'user_id'
    ];

    protected $casts = [
        'status' => ReceiptStatusEnum::class,
        'type' => ReceiptTypeEnum::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
