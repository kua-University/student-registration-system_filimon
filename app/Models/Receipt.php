<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    // Define the table name (if it's different from the default plural name)
    protected $table = 'receipts';

    // Define the fillable fields
    protected $fillable = [
        'payment_intent_id',
        'amount',
        'currency',
        'description',
        'receipt_email',
        'status',
    ];

    // Cast the amount field to a decimal (optional but useful for money fields)
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Define any relationships (if applicable)
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_intent_id', 'payment_intent_id');
    }
}
