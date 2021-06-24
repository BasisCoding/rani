<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Employee\Models\Employee as EmployeeModels;

class AssetUserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(EmployeeModels $employee)
    {
        return [
            'id'          => $employee->id,
            'name'        => $employee->name,
        ];
    }
}
