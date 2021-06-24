<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Api\Transformers\AssetHistoryTransformer;
use Ams\Api\Transformers\AssetEmployeeTransformer;
use Ams\Api\Transformers\AssetPartnerTransformer;

use Ams\Asset\Models\AssetItem as AssetItemModels;

class AssetItemTransformer extends TransformerAbstract
{
    // Related transformer that can be included
    public $availableIncludes = [
        'employee',
        'histories',
        'partner'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(AssetItemModels $asset)
    {
        return [
            'id'         => $asset->id,
            'code'       => $asset->code,
            'name'       => $asset->parent->name,
            'parameter'  => $asset->parameter,
            'picture'    => [
                'front' => $asset->view_front ? $asset->view_front->getPath() : (bool) false,
                'back'  => $asset->view_back ? $asset->view_back->getPath() : (bool) false,
                'left'  => $asset->view_left ? $asset->view_left->getPath() : (bool) false,
                'right' => $asset->view_right ? $asset->view_right->getPath() : (bool) false,
            ],
            'status'     => [
                'id'          => $asset->status->id,
                'name'        => $asset->status->name,
                'description' => $asset->status->description,
            ],
            'category'   => [
                'parent' => [
                    'id'   => (int) $asset->parent->category->parent->id,
                    'code' => $asset->parent->category->parent->code,
                    'name' => $asset->parent->category->parent->name,
                ],
                'child' => [
                    'id'   => (int) $asset->parent->category->id,
                    'name' => $asset->parent->category->name,
                ],
            ],
            'location'     => [
                'office'   => [
                    'id'   => (int) $asset->room->building->office->id,
                    'name' => $asset->room->building->office->name,
                ],
                'building'   => [
                    'id'   => (int) $asset->room->building->id,
                    'name' => $asset->room->building->name,
                ],
                'room'   => [
                    'id'   => (int) $asset->room->id,
                    'name' => $asset->room->name,
                ],
                'position' => [
                    'x' => (int) $asset->layout_x,
                    'y' => (int) $asset->layout_y,
                ]
            ],
            'acquisitioned_at' => [
                'dFY' => $asset->acquisitioned_at ? $asset->acquisitioned_at->format('d F Y') : (bool) false,
                'd'   => $asset->acquisitioned_at ? $asset->acquisitioned_at->format('d') : (bool) false,
                'm'   => $asset->acquisitioned_at ? $asset->acquisitioned_at->format('m') : (bool) false,
                'F'   => $asset->acquisitioned_at ? $asset->acquisitioned_at->format('F') : (bool) false,
                'Y'   => $asset->acquisitioned_at ? $asset->acquisitioned_at->format('Y') : (bool) false,
            ],
            'guaranteed_at' => [
                'dFY' => $asset->guaranteed_at ? $asset->guaranteed_at->format('d F Y') : (bool) false,
                'd'   => $asset->guaranteed_at ? $asset->guaranteed_at->format('d') : (bool) false,
                'F'   => $asset->guaranteed_at ? $asset->guaranteed_at->format('F') : (bool) false,
                'Y'   => $asset->guaranteed_at ? $asset->guaranteed_at->format('Y') : (bool) false,
            ],
        ];
    }

    public function includeEmployee(AssetItemModels $asset)
    {
        if($asset->employee) {
            return $this->item($asset->employee, new AssetEmployeeTransformer);
        }
    }

    public function includeHistories(AssetItemModels $asset)
    {
        return $this->collection($asset->reoderHistory(), new AssetHistoryTransformer);
    }

    public function includePartner(AssetItemModels $asset)
    {
        if($asset->historyLast()->partner) {
            return $this->item($asset->historyLast()->partner, new AssetPartnerTransformer);
        }
    }
}
