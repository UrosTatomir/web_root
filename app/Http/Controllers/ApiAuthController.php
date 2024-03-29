<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User; 
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Validator;
use Illuminate\Support\Facades\Validator;
class ApiAuthController extends Controller
{
  public $successStatus=200;

public function register(Request $request){
$validator=Validator::make($request->all(),
           [
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'=>['required', 'string', 'min:8','confirmed'],
           ]);
   // dd('stiglo');

if($validator->fails()){
   return response()->json(['error'=>$validator->errors()],401);
}else{
   
   return User::forceCreate([
      'name' => $request['name'],
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
      'remember_token' => Str::random(80),
  ]);
   return response()->json(['success'=>$success],$this->successStatus);
  }
}
public function login(){ 
if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
   // $user = Auth::user();
   $user=App\user::find(1);
   $success['token'] =  $user->createToken('AppName')-> accessToken; 
    return response()->json(['success' => $success], $this-> successStatus); 
  } else{ 
   return response()->json(['error'=>'Unauthorised'], 401); 
   } 
}
public function getUser() {
 $user = Auth::user();
 return response()->json(['success' => $user], $this->successStatus); 
 }

}//end class 


