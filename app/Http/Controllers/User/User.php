<?php

/**
 * @OA\Info(title="API Test", version="1.0")
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Validator;


class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(UserModel::get(), 200);
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        /**
     * @OA\Get(
     *     path="/api/user/store", tags={"Users"},
     *     @OA\Response (response="200", description="Success"),
     *     @OA\Response (response="404", description="Not Found"),
     * )
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'phone_no' => 'required|min:11|max:11',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = UserModel::create($request->all());
        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/api/user", tags={"countrySave"},
     *     @OA\Response (response="200", description="Success"),
     *     @OA\Response (response="404", description="Not Found"),
     * )
     */

     /**
     * @OA\Get(
     *     path="/api/user/show", tags={"Users"},
     *     @OA\Response (response="200", description="Success"),
     *     @OA\Response (response="404", description="Not Found"),
     * )
     */
    public function show($id)
    {
        $user = UserModel::find($id);
        if(is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/user/update", tags={"Users"},
     *     @OA\Response (response="200", description="Success"),
     *     @OA\Response (response="404", description="Not Found"),
     * )
     */

    public function update(Request $request, $id)
    {
        $user = UserModel::find($id);
        if(is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/user/destroy", tags={"Users"},
     *     @OA\Response (response="200", description="Success"),
     *     @OA\Response (response="404", description="Not Found"),
     * )
     */
    public function destroy($id)
    {
        $user = UserModel::find($id);
        if(is_null($user)) {
            return response()->json(["message" => "Record not found!"], 404); 
        }
        $user->delete();
        return response()->json(null, 204);
    }
}
