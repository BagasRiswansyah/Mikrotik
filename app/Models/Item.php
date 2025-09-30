<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'quantity',
        'price',
        'category',
        'location',
        'purchase_date',
        'supplier',
        'status'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'price' => 'decimal:2'
    ];

    // Automatically update status based on quantity
    public function updateStatus()
    {
        if ($this->quantity == 0) {
            $this->status = 'out_of_stock';
        } elseif ($this->quantity <= 5) {
            $this->status = 'low_stock';
        } else {
            $this->status = 'available';
        }
        $this->save();
    }
}