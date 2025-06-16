<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanOffer extends Model
{
    protected $table = 'loan_offers';
    protected $primaryKey = 'offer_id';
    public $timestamps = false;

    protected $fillable = [
        'lender_id', 'loan_type', 'interest_rate', 'max_amount', 'max_duration'
    ];

    public function lender()
    {
        return $this->belongsTo(Lender::class, 'lender_id');
    }
}