<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first()) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'User already exists'
            ], 409);
        }

        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        $user = User::create($request->except([ 'photo' ]));

        if ($request->photo && $request->photo->isValid()) {
            $filename = 'photo-'.$user->id.'.'.$request->photo->getClientOriginalExtension();
            $request->photo->storeAs('public/users', $filename);
            $user->update([
                'photo' => $filename
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'User successfully registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($user = User::find($id)) {
            return $user;
        }

        return response()->json([
            'status' => 'ERROR',
            'message' => 'User does not exist'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (User::find($id)) {
            return response()->json([
                'status' => 'OK',
                'message' => 'User successfully updated'
            ]);
        }
        
        return response()->json([
            'status' => 'ERROR',
            'message' => 'User does not exist'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::find($id)) {
            return response()->json([
                'status' => 'OK',
                'message' => 'User successfully deleted'
            ]);
        }
        
        return response()->json([
            'status' => 'ERROR',
            'message' => 'User does not exist'
        ]);
    }
}
