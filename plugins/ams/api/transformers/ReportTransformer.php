<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\Report\Models\Report as ReportModels;

use Ams\Api\Transformers\AssetItemTransformer;

class ReportTransformer extends TransformerAbstract
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
    public function transform(ReportModels $report)
    {
        return [
            'id'          => $report->id,
            'is_finished' => (bool) $report->is_finished,
            'body'        => $report->body,
            'created_at' => [
                'dFY'   => $report->created_at->format('d F Y'),
                'dFYHi' => $report->created_at->format('d F Y H:i'),
                'd'     => $report->created_at->format('d'),
                'F'     => $report->created_at->format('F'),
                'Y'     => $report->created_at->format('Y'),
            ],
            'officer'   => [
                'id'    => $report->user->id,
                'name'  => $report->user->name,
                'email' => $report->user->email,
            ],
            'attachments' => $report->attachments
        ];
    }

    public function includeAsset(ReportModels $report)
    {
        return $this->item($report->asset, new AssetItemTransformer);
    }
}
