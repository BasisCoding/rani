<?php namespace Web\Base\Components;

use Cms\Classes\ComponentBase;

class BaseLable extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'BaseLable Component',
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
        $generator  = new \Ams\Core\Classes\Generator;
        $asset      = $this->getCurrent();
        $lable_type = \Ams\Setting\Models\Setting::whereName('lable_type')->first()->value;
        $company    = \Ams\Setting\Models\Setting::whereName('company_name')->first()->value;

        if($lable_type == 'simple') {
            $img   = \Image::make(storage_path('app/media/lable/master-simple.png'))->text($asset->code, 600, 110, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(68);
                $font->color('#fff');
                $font->align('left');
                $font->valign('top');
            });
            $img   = $img->text($asset->parent->category->parent->name, 600, 300, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(68);
                $font->color('#fff');
                $font->align('left');
                $font->valign('top');
            });
            $img   = $img->text($asset->parent->category->name, 600, 500, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(68);
                $font->color('#fff');
                $font->align('left');
                $font->valign('top');
            });
            $img   = $img->text($asset->acquisitioned_at->format('d F Y'), 600, 690, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(68);
                $font->color('#fff');
                $font->align('left');
                $font->valign('top');
            });
            return $img->response('png');
        }

        if($lable_type == 'qr') {
            $qrcode = base64_encode(\QrCode::format('png')->size(400)->color(40,40,40)->generate($asset->code));
            $img    = \Image::make(storage_path('app/media/lable/master-qr.png'))->resize(500, 550);
            $img    = $img->insert(base64_decode($qrcode), 'center');
            $img    = $img->text($company, 250, 20, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(36);
                $font->color('#fff');
                $font->align('center');
                $font->valign('top');
            });
            $img   = $img->text($asset->code, 250, 500, function($font) {
                $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
                $font->size(36);
                $font->color('#fff');
                $font->align('center');
                $font->valign('top');
            });
            return $img->response('png');
        }
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\AssetItem::whereParameter($this->property('parameter'))->first();
    }
}
