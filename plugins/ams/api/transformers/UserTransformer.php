<?php namespace Ams\Api\Transformers;

use League\Fractal\TransformerAbstract;

use Ams\User\Models\User as UserModels;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(UserModels $user)
    {
        return [
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'phone'    => $user->phone,
            'is_admin' => (bool) $user->is_admin
        ];
    }
}
