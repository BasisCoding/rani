<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Location\Models\Office as OfficeModels;
use Ams\Api\Transformers\LocationBuildingTransformer;

class LocationOfficeTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(OfficeModels $office)
    {
        return [
            'id'         => $office->id,
            'code'       => $office->code,
            'name'       => $office->name,
            'building'   => $office->buildingOrder(),
            // 'building'   => $this->collection($office->buildingOrder(), new LocationBuildingTransformer)
        ];
    }
}
