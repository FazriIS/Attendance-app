<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersController extends Controller
{
    public function registerApi(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
            if(User::where('username', $data['username'])->count() === 1){
                throw new HttpResponseException(response([
                    "errors" => [
                        "username" => [
                            "Username already exists"
                        ]
                    ]
                ], 400));
            }

            if ($request->file('foto_karyawan')) {
                $data['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
            }

            $user = new User($data);
            $user->password = Hash::make($data['password']);
            $user->save();
            
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function loginApi(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();
        
        $user = User::where('username', $data['username'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            throw new HttpResponseException(response([
                    "errors" => [
                        "message" => [
                            "username or password wrong"
                        ]
                    ]
                ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function getUserCurrent(Request $request): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function updateUserCurrent(UserUpdateRequest $request): UserResource
    {
        $data = $request->validated();

        $user = Auth::user();

        if(isset($data['name'])){
            $user->name = $data['name'];
        }

        if(isset($data['foto_karyawan'])){
            $user->foto_karyawan = $data['foto_karyawan'];
        }

        if(isset($data['email'])){
            $user->email = $data['email'];
        }

        if(isset($data['username'])){
            $user->username = $data['username'];
        }

        if(isset($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        if(isset($data['tgl_lahir'])){
            $user->tgl_lahir = Carbon::parse($data['tgl_lahir'])->format('Y-m-d');
        }

        if(isset($data['gender'])){
            $user->gender = $data['gender'];
        }

        if(isset($data['status_nikah'])){
            $user->status_nikah = $data['status_nikah'];
        }

        if(isset($data['alamat'])){
            $user->alamat = $data['alamat'];
        }

        $user->save();
        return new UserResource($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json([
            "data" => [
                "message" => "Logout Success"
            ]
        ])->setStatusCode(200);
    }
}
