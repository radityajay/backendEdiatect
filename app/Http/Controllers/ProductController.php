<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validator = \Validator::make($request->all(), [
            'name'              => 'required',
            'price'             => 'required',
            'photo'             => 'required',
            'surface_area_id'   => 'required',
            'building_type_id'  => 'required',
            'building_model_id'  => 'required',
            'category_id'       => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors(), 'data' => null], 409);
        }

        DB::beginTransaction();

        try {
            if (Product::where('name', $request->name)->exists()) {
                return response()->json(['success' => false, 'msg' => 'Name Already Exists', 'data' => null], 409);
            }

            $data = [
                'name'              => $request->name,
                'price'             => $request->price,
                'photo'             => $request->photo,
                'surface_area_id'   => $request->surface_area_id,
                'building_type_id'  => $request->building_type_id,
                'building_model_id'  => $request->building_model_id,
                'category_id'       => $request->category_id
            ];

            $result = Product::create($data);

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
        $data = Product::all();

        return response()->json(['success'=> true, 'msg' => null, 'data' => $data], 200);
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        // $user = auth()->user();
        // $user = auth('api')->user();
        // dd($user);
        
        // if($request->category_id){
        //     $data_filter = Product::where('category_id', $request->category_id);
        // }

        DB::beginTransaction();

        try {
            $data = [
                'category_id'       => $request->category_id,
                'surface_area_id'   => $request->surface_area_id,
                'building_type_id'  => $request->building_type_id,
                'building_model_id'  => $request->building_model_id,
            ];

            $data = Product::where($data)->get();

            DB::commit();

            return response()->json(['success'=> true, 'msg' => null, 'data' => $data], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => null], 409);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $e->getMessage(), 'data' => null], 409);
        }
    }
}
