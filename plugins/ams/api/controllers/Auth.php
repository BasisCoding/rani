<?php namespace Ams\Api\Controllers;

use Ams\API\Classes\ApiController;

use Ams\Api\Transformers\UserTransformer;

class Auth extends ApiController
{
    public function login()
    {
    	$rules = [
            'email'     => 'required|email',
            'password'  => 'required',
        ];
        $attributeNames = [
            'email'     => 'email',
            'password'  => 'password',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first()
            ]);
        }

        $email    = strtolower(post('email'));
        $password = strtolower(post('password'));

        $user    = \Ams\User\Models\User::whereEmail($email)->first();
        if(!$user) {
            return response()->json([
                'message' => 'Pengguna tidak ditemukan',
            ]);
        }

        if(!\Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Password tidak sesuai',
            ]);
        }

        $userTokens = \Ams\User\Models\Token::firstOrCreate([
            'user_id' => $user->id,
            'token'   => post('token')
        ]);
        $userTokens->save();

        return response()->json([
            'result'   => true,
            'response' => $this->respondwithItem($user, new UserTransformer)
        ]);
    }

    public function logout()
    {
        $token = \Ams\User\Models\Token::whereUserId(post('user_id'))->whereToken(post('token'))->orderBy('id', 'desc')->first();
        if($token->delete()) {
            return response()->json([
                'result' => true,
            ]);
        }
    }
}
