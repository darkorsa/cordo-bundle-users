<?php

namespace App\Context\Users\UI\Transformer;

use League\Fractal\TransformerAbstract;
use App\Context\Users\Application\Query\UserView;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserView $user)
    {
        return [
            'id'                    => $user->id(),
            'email'                 => $user->email(),
            'modified'              => $user->updatedAt(),
            'links'                 => [],
        ];
    }
}
