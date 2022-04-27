<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Permission::with(["students"])->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
            'description' => 'required',
            'reason' => 'required',
        ]);
        $permiss = new Permission();
        $permiss->start_date = $request->start_date;
        $permiss->end_date = $request->end_date;
        $permiss->description = $request->description;
        $permiss->reason = $request->reason;
        $permiss->student_id = $request->student_id;
        $permiss->save();
        return response()->json(['message' => 'permission created!', 'data' => $permiss], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Permission::with('students')->findOrFail($id);
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
        $request->validate([

            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
        ]);
        $permiss = Permission::findOrFail($id);
        $permiss->start_date = $request->start_date;
        $permiss->end_date = $request->end_date;
        $permiss->description = $request->description;
        $permiss->reason = $request->reason;
        $permiss->student_id = $request->student_id;
        $permiss->save();

        return response()->json(['message' => 'permission updated!', 'data' => $permiss], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Permission::destroy($id);
        if($isDeleted === 1){
            return response()->json(["message" => "Deleted"],200);
        }else{
            return response()->json(["message" => "ID not found"],401);
        } 
    }
}
