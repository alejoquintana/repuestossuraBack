<?php

namespace App\Http\Controllers;

use App\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserSocial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Mail\RegConfirm;
use App\Mail\RestorePassMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResource;
use Exception;
use Tymon\JWTAuth\JWTAuth;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{   
    protected $auth;
   
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function deleteUserData() {
        $user = Auth::user();
        $userObj = User::find($user->id);

        if (!$user) {
            return;
        }
        if ($user->role_id <= 2) {
            return;
        }

        $user_social = UserSocial::where('user_id', $user->id)->get()->first();

        if ($user_social) {
            $user_social->delete();
        }

        $newMail = 'usuario_' . $user->id . '_eliminado';
        $userObj->email = $newMail;

        $userObj->password = 'usuario_eliminado';
        $userObj->save();
        return;
    }

    public function fblogin(request $request) {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function fbcallback(request $request) {
        try{
            $serviceUser = Socialite::driver('facebook')->stateless()->user();
        }catch(Exception $e){
            return redirect(env('CLIENT_BASE_URL')) . '/fbcallback?error=error-de-autenticacion';
        }
        if(!$serviceUser){return redirect(env('CLIENT_BASE_URL')) . '/fbcallback?error=error-de-autenticacion';}
        $email = $serviceUser->getEmail();
        $socialid = $serviceUser->getId();

         /* Si el usuario no tiene mail, crear uno  */
        if (!$email) {
            $email = $socialid . '@facebook';
        }
    
        $socialuser = UserSocial::where('social_id',$socialid)->get()->first();
        $user = User::where('email',$email)->get()->first();
        
        if($socialuser && $socialuser->user){
            $user = $socialuser->user;
        }
        
        else{
            $randPass = Hash::make(Rand(1111,9999) . $email);
            if(!$user){
                $user = User::create([
                    'name' => $serviceUser->getName(),
                    'email'=> $email,
                    'password'=> $randPass,
                    'reg_confirmed'=>1,
                    'service'=>'facebook'
                ]);

                $this->assign_reg_verif_code($user);
            }

            $socialuser = UserSocial::create([
                'service'=>'facebook',
                'social_id'=>$socialid,
                'user_id'=>$user->id,
            ]);
        }
        
        if($user->service == 'local'){
            $user->service = 'facebook';
            $user->reg_confirmed= 1;
            $user->save();
        }

        $token = $this->auth->fromUser($user);
        return redirect(env('CLIENT_BASE_URL').'/fbcallback?token='.$token);
    }

    public function changePassword(request $request) {
        $user = User::find($request->id);
        if(!$user){return;}

        $newpass = Hash::make($request->password);
        $user->password = $newpass;
        $user->save();
        return;
    }

    public function updateUser(request $request) {
        $user = User::find($request->id);
        if(!$user){return;}

        $field = $request->field;
        $user->$field = $request->value;
        $user->save();
        return $user;
    }

    public function usersList($search = null) {
        $q = User::where('role_id','>',2);
        if($search)
        {
            $search = '%'.$search.'%';
            $q->where('name','LIKE',$search)
                ->orWhere('email','LIKE',$search)
                ->orWhere('cuil','LIKE',$search)
                ->orWhere('razon_social','LIKE',$search)
                ->orWhere('nombre_fantasia','LIKE',$search)
                ->orWhere('id','LIKE',$search);
            }
        $q= $q->orderBy('id','DESC');
        return $q->paginate();
    } 

    public function usersMonthly() {
        return User::where('role_id','>',2)
                        ->select(DB::raw('COUNT(id) as n'),
                        DB::raw('SUM( IF( reg_confirmed = 1, 1, 0 ) ) as confirmed'), 
                        DB::raw('SUM( IF( reg_confirmed = 0, 1, 0 ) ) as not_confirmed'), 
                        DB::raw('SUM( IF( service = "local", 1, 0 ) ) as local'), 
                        DB::raw('SUM( IF( service = "facebook", 1, 0 ) ) as facebook'), 
                        DB::raw("YEAR(created_at) AS year"),
                        DB::raw("MONTH(created_at) AS month")
                        )
                        ->groupBy('year')
                        ->groupBy('month')
                        ->orderBy('year','DESC')
                        ->orderBy('month','DESC')
                        ->get();
    }

    public function usersDaily($year,$month) {

        $minDate = Carbon::create($year,$month,1);
        $maxDate = Carbon::create($year,$month+1,1);
        if($month==12)
        {
            $maxDate = Carbon::create($year+1,1,1);
        }


        return User::where('role_id','>',2)
                        ->select(DB::raw('COUNT(id) as n'),
                        DB::raw('SUM( IF( reg_confirmed = 1, 1, 0 ) ) as confirmed'), 
                        DB::raw('SUM( IF( reg_confirmed = 0, 1, 0 ) ) as not_confirmed'),
                        DB::raw('SUM( IF( service = "local", 1, 0 ) ) as local'),
                        DB::raw('SUM( IF( service = "facebook", 1, 0 ) ) as facebook'), 
                        DB::raw("YEAR(created_at) AS year"),
                        DB::raw("MONTH(created_at) AS month"),
                        DB::raw("DAY(created_at) AS day")
                        )
                        ->whereBetween('created_at',[$minDate,$maxDate])
                        ->groupBy('year')
                        ->groupBy('month')
                        ->groupBy('day')
                        ->orderBy('day','DESC')
                        ->get();
    }

    public function getAllUsers() {
        return User::all()->orderby('id','DESC');
    }

    public function assign_reg_verif_codes() {
       $users = User::all();
       
       foreach ($users as $user) {
          $this->assign_reg_verif_code($user);
       }
       print("listo");
       return null;
    }

    public function assign_reg_verif_code($user) {

        $rand = mt_rand(100000, mt_getrandmax());
        $token = strval($user->id) . strval($rand);
        $user->reg_verif_code = $token;
        $user->save(); 
    
    }

    public function register(Request $request) {
        $exists = User::where('email',$request->email)->get()->first();
        if($exists){
            return "exists";
        }else{

            /*
            $recaptcha_token = $request->recaptcha_token;
            if(!$recaptcha_token){
                return response('No se recibió token captcha',500);
            }
            $recaptcha_response = Recaptcha::verify($recaptcha_token);
            if(!$recaptcha_response['success']){
                return response($recaptcha_response['error_codes'],500);
            }
            */
            
            $user = User::create([
                'name' => $request->name,
                'email'=>$request->email,
                'cuil' => $request->cuil,
                'area_code' => $request->area_code,
                'phone' => $request->phone,
                'razon_social' => $request->razon_social,
                'nombre_fantasia' => $request->nombre_fantasia,
                'password'=>bcrypt($request->password),
                'role_id'=>$request->role_id,
                'reg_confirmed'=>1
            ]);
    
            TelegramNotificationLogController::telegramNotifyAdmins("SE REGISTRO UN NUEVO USUARIO #" . $user->id . " - " . $user->name);
     
            $this->assign_reg_verif_code($user);
        
            return $user->reg_verif_code;
        }
        
    }

    public function restorePass(Request $request) {
        $user = User::where('email',$request->email)->get()->first();

        if($user)
        {
           $this->assign_reg_verif_code($user);
           
            /* Para confirmar el registro mandamos un mail con un token en la url */
            $mail = new RestorePassMail($user->name,$user->reg_verif_code);
            Mail::to($user->email)
                ->send($mail);

            return $user;
        }
        else {
            return "error";
        }
        
    }

    public function changePass(Request $request) {
        $token = $request->token;
        $user = User::where('reg_verif_code',$token)->get()->first();
        if($user)
        {
            $user->password = bcrypt($request->password);
            $user->save();
            return $user;
        }
        else {
            return 0;
        }
    }

    public function regConfirm(Request $request) {
        $token = $request->token;
        $user = User::where('reg_verif_code',$token)->get()->first();
        if($user)
        {
            $user->reg_confirmed=true;
            $user->save();
            return $user;
        }
        else {
            return 0;
        }
    }

    public function logout() {
        Auth::logout();
    }

    public function getUser(Request $request) {
        $user = auth()->user();
        if($user){
            return new UserResource($user);
        }
    }

    public function login(Request $request) { 
    if($request->email && $request->password){
        $user = User::where('email',$request->email)->get()->first();
        if(!$user){
            return response('Usuario no registrado',400);
        }
        if($user)
        {
            $token = Auth::attempt($request->only(['email','password']));
            if (!$token)
            {
                return response('Contraseña incorrecta',400) ;
            }
            else{
                return (new UserResource($user))->additional([
                    'meta'=>[
                        'token' => $token,
                    ]
                ]);
            };
        }
    }
    
    if($request->input('token')){
        $token = $request->input('token');
        $this->auth->setToken($token);
        $user = $this->auth->authenticate();
        if($user){
            return (new UserResource($user))->additional([
                'meta' => [
                    'token' => $token,
                ]
            ]);
        }
    }
    }

    public function csrf() {
        return csrf_token();
    }
}
