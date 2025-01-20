<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'payment_type',
        'course_id',
        'status',
        'payment_intent_id', // Add payment_intent_id to the fillable array
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Static function to get the payment status for a given student ID and payment type
     */
    public static function getPaymentStatus($studentId, $paymentType)
    {
        return self::where('student_id', $studentId)
                    ->where('payment_type', $paymentType)
                    ->latest()
                    ->first(['status'])?->status;
    }
}
