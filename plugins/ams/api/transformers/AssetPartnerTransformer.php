<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Asset\Models\Partner as AssetPartnerModels;

class AssetPartnerTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(AssetPartnerModels $partner)
    {
        return [
            'id'    => $partner->id,
            'name'  => $partner->name,
            'email' => $partner->email,
            'phone' => $partner->phone
        ];
    }
}
