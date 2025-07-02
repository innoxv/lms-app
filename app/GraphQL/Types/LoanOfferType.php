<?php

namespace App\GraphQL\Types;

use App\Models\LoanOffer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoanOfferType extends GraphQLType
{
    protected $attributes = [
        'name' => 'LoanOffer',
        'description' => 'A loan offer',
        'model' => LoanOffer::class,
    ];

    public function fields(): array
    {
        return [
            'offer_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the loan offer',
            ],
            'lender_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the lender',
            ],
            'loan_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The type of loan',
            ],
            'interest_rate' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The interest rate of the loan offer',
            ],
            'max_amount' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The maximum loan amount',
            ],
            'max_duration' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The maximum duration of the loan in months',
            ],
        ];
    }
}