<?php namespace Web\Base\Components;

use Cms\Classes\ComponentBase;

class BaseBarcode extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'BaseBarcode Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'BaseLable Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $barcode               = $this->getCurrent();
        $this->page['barcode'] = base64_encode(\QrCode::format('png')->size(400)->color(40,40,40)->generate($barcode->code));
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\AssetItem::whereParameter($this->property('parameter'))->first();
    }
}
