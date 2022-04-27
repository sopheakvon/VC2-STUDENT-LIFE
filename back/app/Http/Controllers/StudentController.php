<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::with(['permissions','disciplines'])->latest()->get();
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
            'first_name' => 'max:10|required',
            'last_name' => 'max:10|required',
            'gender' => 'required',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:1999|',
            'class' => 'required',
            'phone' => 'required|min:9|numeric',
        ]);
        $student = new Student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        $student->profile = $request->profile;
        if($request->profile !== null) {
            $request->file('profile')->store('public/images');
            $student->profile = $request->file('profile')->hashName();
        } else {
            $student->profile = "";
        };
        $student->class = $request->class;
        $student->phone = $request->phone;
       
        $student->save();

        return response()->json(['message' => 'Student created!', 'data' => $student], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::with('permissions', 'disciplines')->findOrFail($id);
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
            'first_name' => 'min:1|max:10',
            'last_name' => 'min:1|max:10',
            'gender' => 'required',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:1999|',
            'class' => 'required',
            'phone' => 'required|min:11|numeric',
        ]);
        $student = Student::findOrFail($id);

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->gender = $request->gender;
        // $student->profile = $request->profile;
        // if($request->profile !== null) {
        //     $request->file('profile')->store('public/images');
        //     $student->profile = $request->file('profile')->hashName();
        // } else {
        //     $student->profile = "";
        // };
        $student->class = $request->class;
        $student->phone = $request->phone;
        $student->save();

        return response()->json(['message' => 'Student updated!', 'data' => $student], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Student::destroy($id);
    }
}


// 1|Xp0kxtvW24zBbDTWNLcHdmVZrOaxQUXnfZCAZVkq