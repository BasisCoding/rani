<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminAssetDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminAssetDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminAssetDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function init()
    {
        $asset     = $this->getCurrent();
        $viewFront = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'viewFrontUploader',
            ['deferredBinding' => false]
        );
        $viewFront->bindModel('view_front', \Ams\Asset\Models\AssetItem::find($asset->id));

        $viewBack = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'viewBackUploader',
            ['deferredBinding' => false]
        );
        $viewBack->bindModel('view_back', \Ams\Asset\Models\AssetItem::find($asset->id));

        $viewLeft = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'viewLeftUploader',
            ['deferredBinding' => false]
        );
        $viewLeft->bindModel('view_left', \Ams\Asset\Models\AssetItem::find($asset->id));

        $viewRight = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'viewRightUploader',
            ['deferredBinding' => false]
        );
        $viewRight->bindModel('view_right', \Ams\Asset\Models\AssetItem::find($asset->id));
    }

    public function onRun()
    {
        $asset = $this->getCurrent();
        if(!$asset) {

            return;
        }

        $this->page['asset'] = $asset;
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\AssetItem::whereParameter($this->property('parameter'))->first();
    }

    public function onPreviewBarcode()
    {
        $asset    = $this->getCurrent();
        $path     = storage_path('app/media/qrcode/'.$asset->code.'.png');
        $generate = \QrCode::format('png')->size(400)->color(40,40,40)->generate($asset->code, $path);

        if($generate) {
            $file = new \System\Models\File;
            $file->fromUrl('localhost/ams-admin/storage/app/media/qrcode/'.$asset->code.'.png');
            $file->fromUrl($path);
            $asset->qrcode()->add($file);
            return \Redirect::to($asset->qrcode->getPath());
        }
    }

    public function onViewHistory()
    {
        $asset = $this->getCurrent();
        $this->page['asset'] = $asset;
    }

    public function onCompare()
    {
        $asset                    = $this->getCurrent();
        $this->page['prev']       = $asset;

        $current                   = new \Ams\Asset\Models\AssetItem;
        $current->acquisitioned_at = post('acquisitioned_at') ?: null;
        $current->status_id        = post('status_id') ?: null;
        $current->name             = post('name') ?: null;
        $current->category_id      = post('category_id') ?: null;
        $current->room_id          = post('room_id') ?: null;
        $current->employee_id      = post('employee_id') ?: null;
        $current->layout_x         = post('layout_x') ?: null;
        $current->layout_y         = post('layout_y') ?: null;
        $this->page['current']     = $current;
    }

    public function onUpdate()
    {
        $asset = $this->getCurrent();
        $rules = [
            'status_id'        => 'required',
            'acquisitioned_at' => 'required|date|after:'.$asset->acquisitioned_at->format('Y-m-d'),
            'office_id'        => 'required',
            'building_id'      => 'required',
            'room_id'          => 'required',
        ];
        $attributeNames = [
            'status_id'        => 'status',
            'acquisitioned_at' => 'tanggal akusisi',
            'office_id'        => 'kantor',
            'building_id'      => 'gedung',
            'room_id'          => 'ruangan',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $before                    = $asset;

        $asset->employee_id        = post('employee_id') ?: NULL;
        $asset->status_id          = post('status_id');
        $asset->room_id            = post('room_id');
        $asset->layout_x           = post('layout_x');
        $asset->layout_y           = post('layout_y');
        $asset->acquisitioned_at   = post('acquisitioned_at');
        $asset->save();

        $history                   = new \Ams\Asset\Models\History;
        $history->code             = $asset->code;
        $history->item_id          = $asset->id;
        $history->employee_id      = $before->employee_id ?: NULL;
        $history->status_id        = $before->status_id;
        $history->room_id          = $before->room_id;
        $history->layout_x         = $before->layout_x;
        $history->layout_y         = $before->layout_y;
        $history->acquisitioned_at = $before->acquisitioned_at;
        $history->save();

        if(post('partner_id')) {
            $partner                  = \Ams\Partner\Models\Partner::find(post('partner_id'));
            $assetPartner             = new \Ams\Asset\Models\Partner;
            $assetPartner->history_id = $history->id;
            $assetPartner->partner_id = $partner->id;
            $assetPartner->name       = $partner->name;
            $assetPartner->phone      = $partner->phone;
            $assetPartner->email      = $partner->email;
            $assetPartner->address    = $partner->address;
            $assetPartner->save();
        }

        \Flash::success('Asset berhasil disimpan');
        return \Redirect::refresh();
    }
}
