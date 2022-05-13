<?php

namespace App\GraphQL\Queries;

final class Expenses
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return 'Hello world!';
    }
}
