<?php

namespace App\GraphQL\Mutations;

use App\Models\LoanOffer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteLoanOfferMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteLoanOffer',
        'description' => 'Delete a loan offer',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'offer_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The ID of the loan offer to delete',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $loanOffer = LoanOffer::findOrFail($args['offer_id']);
        return $loanOffer->delete();
    }
}