<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors(), 'data' => null], 409);
        }

        DB::beginTransaction();

        try {
            if (Role::where('name', $request->name)->exists()) {
                return response()->json(['success' => false, 'msg' => 'Name Already Exists', 'data' => null], 409);
            }

            $data = [
                'name'      => $request->name
            ];

            $result = Role::create($data);

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Add role success!', 'data' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => $result], 409);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => $result], 409);
        }
    }

    public function list()
    {
        // $user = auth()->user();
        // $user = auth('api')->user();
        // dd($user);
        $data = Role::all();

        return response()->json(['success'=> true, 'msg' => null, 'data' => $data], 200);
    }
}
