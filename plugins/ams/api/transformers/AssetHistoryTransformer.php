<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Asset\Models\History as HistoryModels;

class AssetHistoryTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(HistoryModels $history)
    {
        $employee = $history->employee ? $history->employee : new \Ams\Employee\Models\Employee;
        $partner  = $history->partner ? $history->partner : new \Ams\Partner\Models\Partner;

        return [
            'id'         => $history->id,
            'code'       => $history->code,
            'name'       => $history->asset->parent->name,
            'status'     => [
                'id'          => $history->status->id,
                'name'        => $history->status->name,
                'description' => $history->status->description,
            ],
            'category'   => [
                'parent' => [
                    'id'   => (int) $history->asset->parent->category->parent->id,
                    'code' => $history->asset->parent->category->parent->code,
                    'name' => $history->asset->parent->category->parent->name,
                ],
                'child' => [
                    'id'   => (int) $history->asset->parent->category->id,
                    'name' => $history->asset->parent->category->name,
                ],
            ],
            'location'     => [
                'office'   => [
                    'id'   => (int) $history->room->building->office->id,
                    'name' => $history->room->building->office->name,
                ],
                'building'   => [
                    'id'   => (int) $history->room->building->id,
                    'name' => $history->room->building->name,
                ],
                'room'   => [
                    'id'   => (int) $history->room->id,
                    'name' => $history->room->name,
                ],
                'position' => [
                    'x' => (int) $history->location_x,
                    'y' => (int) $history->location_y,
                ]
            ],
            'acquisitioned_at' => [
                'dFY' => $history->acquisitioned_at ? $history->acquisitioned_at->format('d F Y') : (bool) false,
                'd' => $history->acquisitioned_at ? $history->acquisitioned_at->format('d') : (bool) false,
                'F' => $history->acquisitioned_at ? $history->acquisitioned_at->format('F') : (bool) false,
                'Y' => $history->acquisitioned_at ? $history->acquisitioned_at->format('Y') : (bool) false,
            ],
            'guaranteed_at' => [
                'dFY' => $history->guaranteed_at ? $history->guaranteed_at->format('d F Y') : (bool) false,
                'd'   => $history->guaranteed_at ? $history->guaranteed_at->format('d') : (bool) false,
                'F'   => $history->guaranteed_at ? $history->guaranteed_at->format('F') : (bool) false,
                'Y'   => $history->guaranteed_at ? $history->guaranteed_at->format('Y') : (bool) false,
            ],
            'employee' => [
                [
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
                ]
            ],
            'partner' => [
                [
                    'id'    => $partner->id,
                    'name'  => $partner->name,
                    'email' => $partner->email,
                    'phone' => $partner->phone
                ]
            ]
        ];
    }
}
