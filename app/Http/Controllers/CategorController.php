<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorController extends Controller
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
            // if (Category::where('name', $request->name)->exists()) {
            //     return response()->json(['success' => false, 'msg' => 'Email Already Exists', 'data' => null], 409); 
            // }

            $data = [
                'name' => $request->name
            ];
            
            $result = Category::create($data);
            // var_dump($created);

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Add role success!', 'data' => $result], 200);
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
        $data = Category::all();

        return response()->json(['success'=> true, 'msg' => null, 'data' => $data], 200);
    }
}
