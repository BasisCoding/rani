<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminAssetItem extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminAssetItem Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminAssetItem Component',
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

        $this->page['asset'] = $asset;
        $this->page['items'] = $this->getItems();
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\Asset::whereParameter($this->property('parameter'))->first();
    }

    public function getItems()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $roomIds     = $userManager->getRoomIds();
        return \Ams\Asset\Models\AssetItem::whereIn('room_id', $roomIds)->get();
    }
}
