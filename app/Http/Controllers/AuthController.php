<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors(), 'data' => null], 409);
        }

        $data = ([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (User::where('email', $request->email)->count() == 0) {
            return response()->json(['success' => false, 'msg' => 'Email not found.', 'data' => null], 401);
        } else {
            if (Auth::guard('web')->attempt($data)) {
                $user = Auth::guard('web')->user();
                $user['token'] =  $user->createToken('ediatect_backend')->accessToken;
                return response()->json(['success' => true, 'msg' => 'Login success.', 'data' => $user], 200);
            } else {
                return response()->json(['success' => false, 'msg' => 'The password is wrong.', 'data' => null], 401);
            }
        }
    }

    public function signup(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'      => 'required|unique:users',
            'username'  => 'required|unique:users',
            'email'     => 'required|unique:users',
            'alamat'    => 'required',
            'phone'     => 'required',
            'password'  => 'required',
            'role_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors(), 'data' => null], 409);
        }

        DB::beginTransaction();

        try {
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['success' => false, 'msg' => 'Email Already Exists', 'data' => null], 409);
            }

            if (User::where('phone', $request->phone)->exists()) {
                return response()->json(['success' => false, 'msg' => 'Phone Number Already Exists', 'data' => null], 409);
            }

            $data = [
                'name'      => $request->name,
                'username'  => $request->username,
                'email'     => $request->email,
                'alamat'    => $request->alamat,
                'phone'     => $request->phone,
                'password'  => bcrypt($request->password),
                'role_id'   => $request->role_id,
            ];

            $result = User::create($data);

            $result['token'] = $result->createToken('ediatect_backend')->accessToken;

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Register success!', 'data' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => $result], 409);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => $result], 409);
        }
    }

    public function profile()
    {
        // $user = auth()->user();
        $user = auth('api')->user();
        // dd($user);
        $data = User::where('id', $user->id)
                    ->first();

        return response()->json(['success'=> true, 'msg' => null, 'data' => $data], 200);
    }
}
