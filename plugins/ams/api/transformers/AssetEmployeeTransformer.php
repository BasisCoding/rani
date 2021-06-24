<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Employee\Models\Employee as EmployeeModels;

class AssetEmployeeTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(EmployeeModels $employee)
    {
        return [
            'id'       => $employee->id,
            'name'     => $employee->name,
            'uid'      => $employee->code ? $employee->code : (bool) false,
            'department' => [
                'id'   => $employee->department ? $employee->department->id : (bool) false,
                'name' => $employee->department ? $employee->department->name : (bool) false,
            ],
            'team' => [
                'id'   => $employee->team ? $employee->team->id : (bool) false,
                'name' => $employee->team ? $employee->team->name : (bool) false,
            ],
            'unit' => [
                'id'   => $employee->unit ? $employee->unit->id : (bool) false,
                'name' => $employee->unit ? $employee->unit->name : (bool) false,
            ],
        ];
    }
}
