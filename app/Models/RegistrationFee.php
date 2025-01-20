<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrationFeeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'amount',
    ];

    public static function getCurrentFee()
    {
        // Returns the most recent registration fee, assuming there is only one record
        return self::latest()->first();
    }
}
