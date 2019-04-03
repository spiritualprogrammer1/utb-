<?php

namespace App\Transformers;

use App\Bus;
use League\Fractal\TransformerAbstract;

class BusTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    protected $availableIncludes = ['children'];

    public function transform(Bus $bus)
    {
        return [
            'id' => $bus->id,
            'text' => ucwords($bus->matriculation),
            'icon' => 'fa fa-car text-success'
        ];


    }
    public function includeChildren(Bus $bus){
        return $this->collection($bus->state, new StateTransformer());
    }
}
