<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discipline;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Discipline::with(["students"])->latest()->get();
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

            'discipline_type' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);
        $discipline = new Discipline();
        $discipline->date = $request->date;
        $discipline->discipline_type = $request->discipline_type;
        $discipline->description = $request->description;
        $discipline->student_id = $request->student_id;
        $discipline->save();
        return response()->json(['message' => 'discipline created!', 'data' => $discipline], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Discipline::with('students')->findOrFail($id);
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
            'date' => 'required',
        ]);
        $discipline = Discipline::findOrFail($id);
        $discipline->date = $request->date;
        $discipline->discipline_type = $request->discipline_type;
        $discipline->description = $request->description;
        $discipline->student_id = $request->student_id;
        $discipline->save();

        return response()->json(['message' => 'discipline updated!', 'data' => $discipline], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Discipline::destroy($id);
        if($isDeleted === 1){
            return response()->json(["message" => "Deleted"],200);
        }else{
            return response()->json(["message" => "ID not found"],401);
        } 
    }
}
