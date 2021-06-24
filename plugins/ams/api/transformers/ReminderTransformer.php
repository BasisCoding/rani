<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Asset\Models\Reminder as ReminderModels;

use Ams\Api\Transformers\AssetItemTransformer;

class ReminderTransformer extends TransformerAbstract
{
    // Related transformer that can be included
    public $availableIncludes = [
        'asset',
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(ReminderModels $reminder)
    {
        if($reminder->type == 'once') {
            $type = 'Hanya Sekali';
        }

        if($reminder->type == 'repeat') {
            $type = 'Berulang Kali';
        }

        return [
            'id'          => $reminder->id,
            'name'        => $reminder->name,
            'description' => $reminder->description,
            'type'        => $type,
            'reminded_at' => [
                'dFY'   => $reminder->reminded_at->format('d F Y'),
                'd'     => $reminder->reminded_at->format('d'),
                'F'     => $reminder->reminded_at->format('F'),
                'Y'     => $reminder->reminded_at->format('Y'),
            ],
            'created_at' => [
                'dFY'   => $reminder->created_at->format('d F Y'),
                'dFYHi' => $reminder->created_at->format('d F Y H:i'),
                'd'     => $reminder->created_at->format('d'),
                'F'     => $reminder->created_at->format('F'),
                'Y'     => $reminder->created_at->format('Y'),
            ]
        ];
    }

    public function includeAsset(ReminderModels $reminder)
    {
        return $this->collection($reminder->assets, new AssetItemTransformer);
    }
}
