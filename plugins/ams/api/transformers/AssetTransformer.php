<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Api\Transformers\AssetHistoryTransformer;
use Ams\Api\Transformers\AssetEmployeeTransformer;

use Ams\Asset\Models\Asset as AssetModels;

class AssetTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(AssetModels $asset)
    {
        return [
            'id'         => $asset->id,
            'name'       => $asset->name,
            'qty'        => (int) $asset->items->count(),
            'category'   => [
                'parent' => [
                    'id'   => (int) $asset->category->parent->id,
                    'code' => $asset->category->parent->code,
                    'name' => $asset->category->parent->name,
                ],
                'child' => [
                    'id'   => (int) $asset->category->id,
                    'name' => $asset->category->name,
                ],
            ],
        ];
    }
}
