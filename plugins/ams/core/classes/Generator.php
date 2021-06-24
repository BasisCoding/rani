<?php namespace Ams\Core\Classes;

/**
 * Core Plugin Information File
 */
class Generator
{
    public function make()
    {
        $code = $this->code();
        return md5(\Hash::make(date('Y-m-d H:i:s')).$this->code());
    }

    public function getCode($categoryId)
    {
    	$category = \Ams\Asset\Models\Category::whereId($categoryId)->first();
    	$category = $category->parent->code;
    	return $category.$this->code();
    }

    public function code()
    {
        return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    public function makeBarcode($asset)
    {
        $path     = storage_path('app/media/qrcode/'.$asset->code.'.png');
        $generate = \QrCode::format('png')->size(400)->color(40,40,40)->generate($asset->code, $path);

        if($generate) {
            $file = new \System\Models\File;
            $file->fromUrl(env('APP_URL').'storage/app/media/qrcode/'.$asset->code.'.png');
            // $file->fromUrl($path);
            $asset->qrcode()->add($file);
            return;
        }
    }

    public function makeLableSimple($asset)
    {
        $img   = \Image::make(storage_path('app/media/lable/master-simple.png'))->text($asset->code, 600, 110, function($font) {
            $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
            $font->size(68);
            $font->color('#fff');
            $font->align('left');
            $font->valign('top');
        });
        $img   = $img->text($asset->category->parent->name, 600, 300, function($font) {
            $font->file(storage_path('app/media/lable/fonts/Segoe-UI-Bold.ttf'));
            $font->size(68);
            $font->color('#fff');
            $font->align('left');
            $font->valign('top');
        });
        $img   = $img->text($asset->category->name, 600, 500, function($font) {
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
        $save = $img->save(storage_path('app/media/lable/'.$asset->code.'.png'), 60);

        if($save) {
            $file = new \System\Models\File;
            $file->fromUrl(env('APP_URL').'storage/app/media/lable/'.$asset->code.'.png');
            // $file->fromUrl($path);
            $asset->lable()->add($file);
            return;
        }
    }

    public function makeLableQr($asset)
    {
        $company = \Ams\Setting\Models\Setting::whereName('company_name')->first()->value;

        $img     = \Image::make(storage_path('app/media/lable/master-qr.png'))->resize(500, 550);
        $img     = $img->insert(storage_path('app/media/qrcode/'.$asset->code.'.png'), 'center');
        $img     = $img->text($company, 250, 20, function($font) {
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
        $save = $img->save(storage_path('app/media/lable/'.$asset->code.'.jpg'), 60);

        if($save) {
            $file = new \System\Models\File;
            $file->fromUrl(env('APP_URL').'storage/app/media/lable/'.$asset->code.'.jpg');
            // $file->fromUrl($path);
            $asset->lable()->add($file);
            return;
        }
    }

    public function makeGetcontents($text)
    {
        return file_get_contents($text);
        return file_get_contents(str_replace(env('APP_URL'), '', $text), false, stream_context_create( [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]));
    }
}
