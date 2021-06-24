<?php namespace Ams\Api\Controllers;

use Carbon\Carbon;

use Ams\API\Classes\ApiController;

use Ams\Asset\Models\Asset as AssetModels;
use Ams\Api\Transformers\AssetTransformer;
use Ams\Asset\Models\AssetItem as AssetItemModels;
use Ams\Api\Transformers\AssetItemTransformer;
use Ams\Asset\Models\Category as CategoryModels;
use Ams\Api\Transformers\AssetCategoryTransformer;
use Ams\Location\Models\Office as OfficeModels;
use Ams\Api\Transformers\LocationOfficeTransformer;
use Ams\Api\Transformers\LocationBuildingTransformer;
use Ams\Asset\Models\Status as StatusModels;
use Ams\Api\Transformers\AssetStatusTransformer;
use Ams\Employee\Models\Employee as EmployeeModels;
use Ams\Api\Transformers\AssetEmployeeTransformer;

class Assets extends ApiController
{

    /**
     * [get description]
     * @return array fetch all assets
     */
    public function get()
    {
        $assets = AssetItemModels::orderBy('id', 'desc')->take(50)->get();
        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithCollection($assets, new AssetItemTransformer)
        ]);
    }

    /**
     * [search description]
     * @return array search by description
     */
    public function search()
    {
        $name   = input('name');
        $assets = AssetItemModels::where('code', 'like', '%'.$name.'%')->orWhereHas('parent', function($q) use($name) {
            $q->where('name', 'like', '%'.$name.'%');
            $q->orWhereHas('category', function($r) use($name){
                $r->where('name', 'like', '%'.$name.'%');
                $r->orWhereHas('childs', function($s) use($name){
                    $s->where('name', 'like', '%'.$name.'%');
                });
            });
        })->take(50)->get();

        return response()->json([
            'result'    => true,
            'response'  =>  $this->respondwithCollection($assets, new AssetItemTransformer)
        ]);
    }

    public function filter()
    {
        $dateBefore = post('date_before');
        $dateAfter  = post('date_after');
        $category   = post('category');
        $location   = post('location');
        $status     = post('status');
        $user       = post('user');

        $asset = new AssetItemModels;

        if($dateBefore) {
            $asset = $asset->where('acquisitioned_at', '>', $dateBefore);
        }

        if($dateAfter) {
            $asset = $asset->where('acquisitioned_at', '<', $dateAfter);
        }

        if($category) {
            $category = explode(',', $category);
            $asset    = $asset->whereHas('parent', function($q) use($category){
                $q->whereIn('category_id', $category);
            });
        }

        if($location) {
            $location = explode(',', $location);
            $location = \Ams\Location\Models\Room::whereIn('parameter', $location)->select('id')->get()->toArray();
            if(count($location)) {
                $asset    = $asset->whereIn('room_id', $location);
            }
        }

        if($status) {
            $status = explode(',', $status);
            $asset  = $asset->whereIn('status_id', $status);
        }

        if($user) {
            $user  = explode(',', $user);
            $asset = $asset->whereIn('employee_id', $user);
        }

        $asset = $asset->orderBy('id', 'desc')->take(50)->get();

        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($asset, new AssetItemTransformer)
        ]);
    }

    public function move()
    {
        $rules = [
            'acquisitioned_at' => 'required|date',
            'status_id'        => 'required',
            'office_id'        => 'required',
            'building_id'      => 'required',
            'room_id'          => 'required',
        ];
        $attributeNames = [
            'acquisitioned_at' => 'tanggal akusisi',
            'status_id'        => 'status',
            'office_id'        => 'kantor',
            'building_id'      => 'gedung',
            'room_id'          => 'ruangan',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first()
            ]);
        }

        $asset                   = AssetItemModels::find(post('asset_id'));
        $asset->status_id        = post('status_id');
        $asset->room_id          = post('room_id');
        $asset->layout_x         = post('layout_x');
        $asset->layout_y         = post('layout_y');
        $asset->acquisitioned_at = post('acquisitioned_at');
        $asset->guaranteed_at    = post('guaranteed_at') ?: null;
        $asset->employee_id      = post('employee_id') ?: null;
        $asset->save();

        // History
        $assetHistory                   = new \Ams\Asset\Models\History;
        $assetHistory->item_id          = $asset->id;
        $assetHistory->code             = $asset->code;
        $assetHistory->status_id        = $asset->status_id;
        $assetHistory->room_id          = $asset->room_id;
        $assetHistory->layout_x         = $asset->layout_x;
        $assetHistory->layout_y         = $asset->layout_y;
        $assetHistory->acquisitioned_at = $asset->acquisitioned_at;
        $assetHistory->employee_id      = $asset->employee_id;
        $assetHistory->save();

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

        return response()->json([
            'result'  => true,
            'message' => 'Asset berhasil disimpan'
        ]);
    }

    /**
     * [detail description]
     * @return array search by id
     */
    public function detail()
    {
        $id     = input('id');
        $assets = AssetItemModels::find($id);
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithItem($assets, new AssetItemTransformer)
        ]);
    }

    public function detailPicture()
    {
        $id     = input('id');
        $mode   = input('mode');
        $asset  = AssetItemModels::find($id);

        $generator       = new \Ams\Core\Classes\Generator;
        $file            = new \System\Models\File;
        $file->data      = \Input::file('picture');
        $file->file_name = $generator->make();
        $file->save();

        if($mode == 'front') {
            $asset->view_front()->add($file);
        }

        if($mode == 'back') {
            $asset->view_back()->add($file);
        }

        if($mode == 'left') {
            $asset->view_left()->add($file);
        }

        if($mode == 'right') {
            $asset->view_right()->add($file);
        }

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * [code description]
     * @return array search by code
     */
    public function code()
    {
        $code   = input('code');
        $assets = AssetItemModels::whereCode($code)->first();
        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithItem($assets, new AssetItemTransformer),
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function category()
    {
        $categories = CategoryModels::whereNull('parent_id')->has('childs')->orderBy('name', 'asc')->with('childs')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($categories, new AssetCategoryTransformer)
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function room()
    {
        if(input('office_id')) {
            $officeId = input('office_id');
            $building = \Ams\Location\Models\Building::orderBy('name')->whereOfficeId($officeId)->get();

            return response()->json([
                'result'   => true,
                'response' => [
                    'data' => $building
                ]
            ]);
        }

        if(input('building_id')) {
            $buildingId = input('building_id');
            $rooms      = \Ams\Location\Models\Room::orderBy('name')->whereBuildingId($buildingId)->get();

            return response()->json([
                'result'   => true,
                'response' => [
                    'data' => $rooms
                ]
            ]);
        }


        $offices = OfficeModels::orderBy('name')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($offices, new LocationOfficeTransformer)
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function status()
    {
        $status = StatusModels::orderBy('name')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($status, new AssetStatusTransformer)
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function user()
    {
        $user = EmployeeModels::orderBy('name')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($user, new AssetEmployeeTransformer)
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function partner()
    {
        $partner = \Ams\Partner\Models\Partner::orderBy('name')->get();
        return response()->json([
            'result'   => true,
            'response' => [
                'data' => $partner
            ]
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
    */
    public function item()
    {
        $asset = AssetItemModels::whereAssetId(input('asset_id'))->orderBy('id', 'desc')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($asset, new AssetItemTransformer)
        ]);
    }

    public function report()
    {
        if(!post('body')) {
            return response()->json([
                'result'  => false,
                'message' => 'Informasi laporan wajib di isi'
            ]);
        }

        if(!\Input::file('photo')) {
            return response()->json([
                'result'  => false,
                'message' => 'Lampiran wajib di upload'
            ]);
        }

        $generator       = new \Ams\Core\Classes\Generator;
        $asset           = AssetItemModels::find(input('id'));
        $report          = new \Ams\Report\Models\Report;
        $report->item_id = $asset->id;
        $report->user_id = post('user_id');
        $report->body    = post('body');
        $report->save();

        foreach (\Input::file('photo') as $photo) {
            $file            = new \System\Models\File;
            $file->data      = $photo;
            $file->file_name = $generator->make();
            $file->save();
            $report->attachments()->add($file);
        }

        $users  = \Ams\User\Models\User::whereIn('is_admin', [0, 1])->whereNotIn('id', [$report->user_id])->select('id')->get()->toArray();
        $users  = \Ams\User\Models\Token::whereIn('user_id', $users)->select('token')->get();

        foreach ($users as $user) {
            $body    = $report->user->name.' membuat laporan baru untuk '.$report->asset->parent->name;
            $content = [
                'title' => 'Laporan Baru',
                'body'  =>  $body,
                'application' => [
                    'page'      => 'Reportdetail',
                    'parameter' => 'reportId',
                    'key'       => $report->id
                ]
            ];
            $notification = new \Ams\Core\Classes\Notification;
            $notification->pulse([$user->token], $content);
        }

        return response()->json([
            'result'    => true,
            'response'  => [
                'data' => $report
            ]
        ]);
    }
}
