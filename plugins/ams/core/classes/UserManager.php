<?php namespace Ams\Core\Classes;

/**
 * Core Plugin Information File
 */
class UserManager
{
    public function setUser($user)
    {
        $user = \Session::put('userLogin', $user);
        return $user;
    }

    public function removeUser()
    {
        \Session::forget('userLogin');
        return true;
    }

    public function getUser()
    {
        $user = \Session::get('userLogin');
        if($user) {
            return \Ams\User\Models\User::find($user);
        }
    }

    /**
     * Location Purpose
     * Controlling office, building and rooms
     */
    public function getOfficeIds()
    {
        $user       = $this->getUser();
        return \Ams\User\Models\Location::whereUserId($user->id)->pluck('office_id');
    }

    public function getOffice()
    {
        $officeIds = $this->getOfficeIds();
        return \Ams\Location\Models\Office::whereIn('id', $officeIds)->get();
    }

    public function getBuildingIds()
    {
        $officeIds = $this->getOffice();
        return \Ams\Location\Models\Building::whereIn('office_id', $officeIds)->pluck('id');
    }

    public function getRoomIds()
    {
        $buildingIds = $this->getBuildingIds();
        return \Ams\Location\Models\Room::whereIn('building_id', $buildingIds)->pluck('id');
    }
}
