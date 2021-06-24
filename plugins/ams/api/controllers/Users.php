<?php namespace Ams\Api\Controllers;

use Ams\Api\Classes\ApiController;

use Ams\Api\Transformers\UserTransformer;

class Users extends ApiController
{
    public function get()
    {
        $user = input('id');
        $user = \Ams\User\Models\User::find($user);

        if($user) {
            return response()->json([
                'result'   => true,
                'response' => $this->respondwithItem($user, new UserTransformer)
            ]);
        }

        $this->respondwithItem($user, new UserTransformer);
    }
}
