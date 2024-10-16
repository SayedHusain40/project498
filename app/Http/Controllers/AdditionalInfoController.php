<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;

class AdditionalInfoController extends Controller
{
    public function edit($id)
    {
        $user = User::with('major', 'expertise')->findOrFail($id);
        $departments = Department::all();
        
        $courses = Course::all();

        return view('profile.additional_info_edit', compact('user', 'departments', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'major_id' => 'nullable|exists:departments,id',
            'course_ids' => 'array', 
            'course_ids.*' => 'exists:courses,id',
        ]);

        $user = User::findOrFail($id);
        $user->major_id = $request->major_id;
        $user->save();

        $user->expertise()->sync($request->course_ids);

        return redirect()->route('profile.edit')->with('success', 'Information updated successfully.');
    }


}
