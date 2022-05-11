<?php

namespace App\Http\Controllers;

use App\Models\BuldingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuldingModelController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */

    public function add(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors(), 'data' => null], 409);
        }

        DB::beginTransaction();

        try {
            if (BuldingModel::where('name', $request->name)->exists()) {
                return response()->json(['success' => false, 'msg' => 'Name Already Exists', 'data' => null], 409); 
            }

            $data = [
                'name' => $request->name
            ];

            $result = BuldingModel::create($data);
            // var_dump($created);

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Add Model Bangunan success!', 'data' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => null], 409);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => null], 409);
        }
    }

    public function list()
    {
        // $user = auth()->user();
        // $user = auth('api')->user();
        // dd($user);
        $data = BuldingModel::all();

        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }
}
