<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $role)
    {
        try {
            $arrayRole = ['admin', 'kurir', 'user'];
            if(!in_array($role,  $arrayRole)) {
                $message = api_format(false, ["url_404" => ["Not Found!"]], [], []);
                return response()->json($message, 404);
            }
            
            $validator = Validator::make($request->only(['email', 'password', 'device_name']), [
                'email' => 'required|email|exists:users',
                'password' => 'required',
                'device_name' => 'required|max:150',
            ]);
            
            if ($validator->fails()) {
                $error = api_format(false, $validator->errors()->toArray(), [], []);
                return response()->json($error, 200);
            } else {
                $model = User::where('role', $role)->where('email', $request->input('email'))->first();
                if($model && Hash::check($request->input('password'), $model->password)) {
					$loginData = [
                        'id' => $model->id,
                        'name' => $model->name,
                        'email' => $model->email,
                        'role' => $model->role,
                        'type' => 'Bearer',
                        'token' => $model->createToken($request->device_name)->plainTextToken,
                    ];
                    
                    $success = api_format(true, ["msg" => [Lang::get('messages.api_login')]], $loginData, []);
                    
                    return response()->json($success, 200);
                } 
                
                $errorlogin = [
                    "email" => [Lang::get('messages.login_failed')]
                ]; 
                
                $success = api_format(false, $errorlogin, [], []);
                return response()->json($success, 200);
            }
        } catch (\Exception $ex) {
            $success = api_format(false, ["message" => [$ex->getMessage()]], [], []);
            return response()->json($success, 200);
        }
    }

}
