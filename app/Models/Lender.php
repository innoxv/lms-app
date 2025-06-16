<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lender extends Model
{
    protected $table = 'lenders';
    protected $primaryKey = 'lender_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'address', 'status', 'registration_date', 'total_loans', 'average_interest_rate', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loanOffers()
    {
        return $this->hasMany(LoanOffer::class, 'lender_id');
    }
}