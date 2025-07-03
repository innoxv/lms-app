<?php

namespace App\GraphQL\Mutations;

use App\Models\LoanOffer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateLoanOfferMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateLoanOffer',
        'description' => 'Update an existing loan offer',
    ];

    public function type(): Type
    {
        return GraphQL::type('LoanOffer');
    }

    public function args(): array
    {
        return [
            'offer_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the loan offer to update',
            ],
            'lender_id' => [
                'type' => Type::id(),
                'description' => 'The ID of the lender',
            ],
            'loan_type' => [
                'type' => Type::string(),
                'description' => 'The type of loan',
            ],
            'interest_rate' => [
                'type' => Type::float(),
                'description' => 'The interest rate of the loan offer',
            ],
            'max_amount' => [
                'type' => Type::float(),
                'description' => 'The maximum loan amount',
            ],
            'max_duration' => [
                'type' => Type::int(),
                'description' => 'The maximum duration of the loan in months',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $loanOffer = LoanOffer::findOrFail($args['offer_id']);
        $loanOffer->update(array_filter($args));
        return $loanOffer;
    }
}