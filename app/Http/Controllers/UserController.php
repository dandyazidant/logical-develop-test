<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['user'] = User::find($id);
        
        return view('edit-profile', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'email' => 'required|string|email|max:100',
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:13',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company' => 'required',
            'divisi' => 'required',
        ]);
        $posted = $request->all();
        $user = User::find($id);
        if ($image = $request->file('foto')) {
            $fileName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/images', $fileName);
            $posted['foto'] = $fileName;
        }else{
            unset($posted['foto']);
        }
        
        $user->update($posted);
    
        return redirect()->route('profile')->with('success','Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
