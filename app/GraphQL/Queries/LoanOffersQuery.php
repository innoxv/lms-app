<?php

namespace App\GraphQL\Queries;

use App\Models\LoanOffer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class LoanOffersQuery extends Query
{
    protected $attributes = [
        'name' => 'loanOffers',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('LoanOffer'));
    }

    public function resolve($root, $args)
    {
        return LoanOffer::all();
    }
}