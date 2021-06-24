<?php namespace Ams\Location\Components;

use Cms\Classes\ComponentBase;

class Location extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Location Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getProvinces()
    {
        return \Ams\Location\Models\Province::orderBy('name')->get();
    }

    public function getRegencies($provinceId)
    {
        return \Ams\Location\Models\Regency::whereProvinceId($provinceId)->orderBy('name')->get();
    }

    public function getDistricts($regencyId)
    {
        return \Ams\Location\Models\District::whereRegencyId($regencyId)->orderBy('name')->get();
    }

    public function getVillages($districtId)
    {
        return \Ams\Location\Models\Village::whereDistrictId($districtId)->orderBy('name')->get();
    }

    public function onGetRegency($provinceId=null)
    {
        if(!$provinceId) {
            $provinceId = post('province_id');
        }
        $this->page['regencies'] = $this->getRegencies($provinceId);
    }

    public function onGetDistrict($regencyId=null)
    {
        if(!$regencyId) {
            $regencyId = post('regency_id');
        }
        $this->page['districts'] = $this->getDistricts($regencyId);
    }

    public function onGetVillage($districtId=null)
    {
        if(!$districtId) {
            $districtId = post('district_id');
        }
        $this->page['villages'] = $this->getVillages($districtId);
    }
}
