<?php namespace Web\Admin\Components;

use Renatio\DynamicPDF\Classes\PDF;

use Cms\Classes\ComponentBase;

class AdminAsset extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminAsset Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $roomIds     = $userManager->getRoomIds();
        $assetIds    = \Ams\Asset\Models\AssetItem::whereIn('room_id', $roomIds)->pluck('asset_id');
        return \Ams\Asset\Models\Asset::whereIn('id', $assetIds)->orderBy('name', 'asc')->get();
    }

    public function getOffice()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        return \Ams\Location\Models\Office::whereIn('id', $officeIds)->orderBy('name')->get();
    }

    public function getBuilding($officeId=null)
    {
        return \Ams\Location\Models\Building::whereOfficeId($officeId)->orderBy('name')->get();
    }

    public function getRoom($buildingId=null)
    {
        if(!$buildingId) {
            return \Ams\Location\Models\Room::orderBy('name')->get();
        }

        return \Ams\Location\Models\Room::whereBuildingId($buildingId)->orderBy('name')->get();
    }

    public function getParentCategory()
    {
        return \Ams\Asset\Models\Category::whereNull('parent_id')->orderBy('name')->get();
    }

    public function getChildCategory($parentId=null)
    {
        if($parentId) {
            return \Ams\Asset\Models\Category::whereParentId($parentId)->orderBy('name')->get();
        }

        return [];
    }

    public function getStatus()
    {
        return \Ams\Asset\Models\Status::orderBy('name')->get();
    }

    public function getStatusCreate()
    {
        return \Ams\Asset\Models\Status::whereIsCreate(1)->orderBy('name')->get();
    }

    public function getEmployee()
    {
        return \Ams\Employee\Models\Employee::orderBy('name')->get();
    }

    public function getPartner()
    {
        return \Ams\Partner\Models\Partner::orderBy('name', 'asc')->get();
    }

    public function onSelectAsset()
    {
        $asset      = (int) post('asset_id');
        $asset      = \Ams\Asset\Models\Asset::find(post('asset_id'));

        if(!$asset) {
            $this->page['categories']      = $this->getParentCategory();
            $this->page['childCategories'] = $this->getChildCategory();
            return;
        }

        $this->page['asset']                 = $asset;
        $this->page['categories']            = \Ams\Asset\Models\Category::whereId($asset->category->parent->id)->get();
        $this->page['selectedCategory']      = $asset->category->parent->id;
        $this->page['childCategories']       = \Ams\Asset\Models\Category::whereId($asset->category->id)->get();
        $this->page['selectedChildCategory'] = $asset->category->id;
    }

    public function onSelectOffice()
    {
        $buildings = $this->getBuilding(post('office_id'));
        $this->page['buildings'] = $buildings;
    }

    public function onSelectBuilding()
    {
        $rooms = $this->getRoom(post('building_id'));
        $this->page['rooms'] = $rooms;
    }

    public function onSelectRoom()
    {
        $room       = \Ams\Location\Models\Room::find(post('room_id'));
        if(!$room) {
            throw new \ApplicationException('Ruangan tidak dipilih');
        }

        $this->page['room'] = $room;
        return;
    }

    public function onSelectParentCategory()
    {
        $categories = \Ams\Asset\Models\Category::whereParentId(post('parent_id'))->orderBy('name')->get();
        $this->page['childCategories'] = $categories;
    }

    public function onIsEmployee()
    {
        $this->page['is_employee'] = post('is_employee');
        $this->page['employees']   = $this->getEmployee();
    }

    public function onSelectStatus()
    {
        if(!post('status_id')) {
            return false;
        }

        $status               = \Ams\Asset\Models\Status::find(post('status_id'));
        $this->page['status'] = strtolower($status->name);
    }

    public function onSave()
    {
        $generator = new \Ams\Core\Classes\Generator;
        $rules     = [
            'asset_id'         => 'required|string:new',
            // 'status_id'        => 'required|in:1,2',
            'parent_id'        => 'required',
            'category_id'      => 'required',
            'qty'              => 'required|numeric',
            'name'             => 'required',
            'acquisitioned_at' => 'required|date',

            'office_id'        => 'required',
            'building_id'      => 'required',
            'room_id'          => 'required',
        ];
        $attributeNames = [
            'asset_id'         => 'asset',
            'status_id'        => 'status',
            'parent_id'        => 'kategori',
            'category_id'      => 'jenis',
            'qty'              => 'kuantitas',
            'name'             => 'nama',
            'acquisitioned_at' => 'tanggal akusisi',
            'guaranteed_at'    => 'tanggal habis masa garansi',

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

        if(post('asset_id') == 'new') {
            // Assets
            $asset              = new \Ams\Asset\Models\Asset;
            $asset->name        = post('name');
            $asset->category_id = post('category_id');
            $asset->save();
        }
        else {
            $asset  = \Ams\Asset\Models\Asset::find(post('asset_id'));
        }


        $qty = post('qty');
        for ($i=1; $i <= $qty; $i++) {
            // Asset Items
            $item                   = new \Ams\Asset\Models\AssetItem;
            $item->asset_id         = $asset->id;
            $item->status_id        = post('status_id');
            $item->room_id          = post('room_id');
            $item->layout_x         = post('layout_x');
            $item->layout_y         = post('layout_y');
            $item->acquisitioned_at = post('acquisitioned_at');
            $item->guaranteed_at    = post('guaranteed_at') ?: null;
            $item->employee_id      = post('employee_id') ?: null;
            $item->save();

            // History
            $assetHistory                   = new \Ams\Asset\Models\History;
            $assetHistory->item_id          = $item->id;
            $assetHistory->code             = $item->code;
            $assetHistory->status_id        = $item->status_id;
            $assetHistory->room_id          = $item->room_id;
            $assetHistory->layout_x         = $item->layout_x;
            $assetHistory->layout_y         = $item->layout_y;
            $assetHistory->acquisitioned_at = $item->acquisitioned_at;
            $assetHistory->employee_id      = $item->employee_id;
            $assetHistory->save();

            // Supplier
            if(post('partner_id')) {
                $partner                    = \Ams\Partner\Models\Partner::find(post('partner_id'));

                $assetSupplier              = new \Ams\Asset\Models\Partner;
                $assetSupplier->history_id  = $assetHistory->id;
                $assetSupplier->partner_id  = $partner->id;
                $assetSupplier->name        = $partner->name;
                $assetSupplier->phone       = $partner->phone;
                $assetSupplier->email       = $partner->email;
                $assetSupplier->address     = $partner->address;
                $assetSupplier->save();
            }
        }

        \Flash::success('Asset berhasil disimpan');
        return \Redirect::to('asset');
    }

    public function onFilter()
    {
        $asset = new \Ams\Asset\Models\Asset;
        if(post('status')) {
            $status = post('status');
            $asset  = $asset->OrWhereIn('status_id', $status);
            // $asset  = $asset->with('histories')->get()->filter(function($asset) use ($status) {
            //     return in_array($asset->histories->last()->status_id, $status);
            // });
        }

        if(post('category')) {
            $category = post('category');
            $asset    = $asset->OrWhereIn('category_id', $category);
        }

        if(post('room')) {
            $room  = post('room');
            $asset = $asset->OrWhereIn('room_id', $room);
        }

        $this->page['assets'] = $asset->get();
        return;
    }

    public function onPrint()
    {
        $asset = \Ams\Asset\Models\Asset::with('items')->get();

        $templateCode   = 'renatio::invoice'; // unique code of the template
        $data           = ['asset' => $asset]; // optional data used in template
        $save           = PDF::loadTemplate($templateCode, $data)
            ->setPaper('a3', 'landscape')
            ->save('asd.pdf');

        return \Redirect::refresh();
    }

    public function onDelete()
    {
        $asset = \Ams\Asset\Models\AssetItem::whereParameter(post('parameter'))->first();
        $asset->histories()->delete();
        $asset->delete();

        \Flash::success('Item berhasil dihapus');
        return \Redirect::refresh();
    }
}
