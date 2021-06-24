<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Asset\Models\Category as CategoryModels;

class AssetCategoryTransformer extends TransformerAbstract
{
    // Related transformer that can be included
    public $availableIncludes = [
        'items',
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(CategoryModels $category)
    {
        return [
            'id'         => $category->id,
            'code'       => $category->code,
            'name'       => $category->name,
            'data'       => $category->childOrders()
        ];
    }


    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function includeItems(CategoryModels $category)
    {
        // return json_encode(['wew' => 'wow']);
    }
}
