<?php

namespace App\Transformers;

use App\State;
use League\Fractal\TransformerAbstract;

class StateTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(State $state)
    {
        return [
            'icon' => 'fa fa-file-text-o text-info',
            'text' => strtoupper($state->reference),
        ];
    }
}
