<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Asset\Models\Status as StatusModels;

class AssetStatusTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(StatusModels $status)
    {
        return [
            'id'          => $status->id,
            'name'        => $status->name,
            'description' => $status->description,
        ];
    }
}
