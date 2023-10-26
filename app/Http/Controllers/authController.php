<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class authController extends Controller
{
    public function index()
    {
        return view('auth.login',[
            "title" => "Log In"
        ]);
    }

    public function register()
    {
        $udin = Hash::make('password');
        
        return view('auth.register', [
            "title" => "Register Account",
            "data_jabatan" => Jabatan::all(),
            "data_lokasi" => Lokasi::where('status', 'approved')->get()
        ]);
    }

    

    public function registerProses(UserRegisterRequest $request)
    {
            $data = $request->validated();
            if(User::where('username', $data['username'])->count() === 1){
                throw new HttpResponseException(response([
                    "errors" => [
                        "username" => [
                            "Username already exists"
                        ]
                    ]
                ], 500));
            }

            if ($request->file('foto_karyawan')) {
                $data['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
            }

            $user = new User($data);
            $user->password = Hash::make($data['password']);
            $user->save();
            
            return redirect()->route('login')->with("success",(new UserResource($user))->response()->setStatusCode(201));
    }

    public function loginProses(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login Gagal!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
