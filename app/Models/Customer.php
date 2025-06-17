<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

    public $timestamps = false; // No created_at/updated_at columns in the table

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'dob',
        'national_id',
        'address',
        'status',
        'registration_date',
        'bank_account',
        'user_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'registration_date' => 'datetime',

    ];

    /**
     * Get the user associated with the customer.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}