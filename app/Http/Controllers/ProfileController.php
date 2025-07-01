<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
        
    }

    public function edit(){
        return view('pages.profiles.edit');
    }

    public function update(Request $request){
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:20|',
            'username' => 'required|string|max:20|unique:users,username,'.$user->id,
            'photo' => 'nullable|image|file|max:1024'
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'photo' => $request->file('photo'),
        ]);

        return redirect()->back();
    }

    
}
