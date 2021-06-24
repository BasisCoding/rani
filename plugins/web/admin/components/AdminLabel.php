<?php namespace Web\Admin\Components;

use Renatio\DynamicPDF\Classes\PDF;

use Cms\Classes\ComponentBase;

class AdminLabel extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminLabel Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['isGenerated']   = \Session::get('isGenerated');
        $this->page['generatedFile'] = env('APP_DOMAIN').'storage/app/media/printed/'.\Session::get('isGenerated');
        \Session::forget('isGenerated');
    }

    public function getAll()
    {
        return \Ams\Asset\Models\AssetItem::orderBy('id', 'desc')->get();
    }

    public function onGenerate()
    {
        if(!post('checkbox_action')) {
            \Flash::error('Pilih asset terlebih dahulu');
            return;
        }

        $generator = new \Ams\Core\Classes\Generator;
        $generator = $generator->make();

        $lable_type = \Ams\Setting\Models\Setting::whereName('lable_type')->first()->value;
        if($lable_type == 'qr') {
            $templateCode   = 'ams::lable-qr'; // unique code of the template
        }

        if($lable_type == 'simple') {
            $templateCode   = 'ams::lable-simple'; // unique code of the template
        }

        $asset          = \Ams\Asset\Models\AssetItem::whereIn('parameter', post('checkbox_action'))->get();
        $data           = ['url' => env('APP_URL'), 'assets' => $asset]; // optional data used in template
        $save           = PDF::loadTemplate($templateCode, $data)
            ->setOptions(['isRemoteEnabled' => true])
            ->setPaper('a3', 'landscape')
            ->save(storage_path('app/media/printed/'.$generator.'.pdf'));

        \Flash::success('Label berhasil digenerate');
        \Session::put('isGenerated', $generator.'.pdf');
        return \Redirect::refresh();
    }

    public function onFilter()
    {
        $asset = new \Ams\Asset\Models\AssetItem;
        if(post('status')) {
            $status = post('status');
            $asset  = $asset->whereIn('status_id', $status);
        }

        if(post('category')) {
            $category = post('category');
            $asset    = $asset->whereIn('category_id', $category);
        }

        if(post('room')) {
            $room  = post('room');
            $asset = $asset->whereIn('room_id', $room);
        }

        $this->page['items'] = $asset->get();
        return;
    }
}
