<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminAssetLocationDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminAssetLocationDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminAssetLocationDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $asset = $this->getCurrent();
        if(!$asset) {

            return;
        }

        $file_data = file_get_contents( $asset->room->layout->getPath(), false, stream_context_create( [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]));

        $marker = file_get_contents(env('APP_URL').'themes/primary/assets/images/marker-default.png', false, stream_context_create( [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]));

        $img        = \Image::make($file_data);
        $img        = $img->insert($marker, 'top-left', $asset->layout_x, $asset->layout_y);
        return $img->response();
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\AssetItem::whereParameter($this->property('parameter'))->first();
    }
}
