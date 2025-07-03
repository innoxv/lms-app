<?php

namespace App\GraphQL\Mutations;

use App\Models\LoanOffer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateLoanOfferMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createLoanOffer',
        'description' => 'Create a new loan offer',
    ];

    public function type(): Type
    {
        return GraphQL::type('LoanOffer');
    }

    public function args(): array
    {
        return [
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

    public function resolve($root, $args)
    {
        return LoanOffer::create($args);
    }
}