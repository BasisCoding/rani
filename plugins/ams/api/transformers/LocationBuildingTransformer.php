<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Location\Models\Building as BuildingModels;

class LocationBuildingTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(BuildingModels $building)
    {
        return [
            'id'        => $building->id,
            'name'      => $building->name,
            'rooms'     => $building->roomOrder(),
            'parameter' => $building->parameter,
        ];
    }
}
