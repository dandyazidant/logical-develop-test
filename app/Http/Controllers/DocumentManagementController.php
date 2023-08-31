<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DocumentManagement;
use Illuminate\Support\Facades\Storage;

class DocumentManagementController extends Controller
{
    public function index()
    {
        $data['document'] = DocumentManagement::all();

        return view('document.index',$data);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required',
            'signin' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $fileName = time() . '.' . $request->signin->extension();
        $request->signin->storeAs('public/document', $fileName);
        
        $posted = $request->all();

        $user = new DocumentManagement;
        $user->title = $posted['title'];
        $user->content = $posted['content'];
        $user->signing = $fileName;
        $user->save();

        return redirect()->route('doc')->with(['message' => 'Document added successfully!', 'status' => 'success']);
    }

    public function show($id)
    {
        $data['doc'] = DocumentManagement::find($id);
        return view('document.view',$data);
    }

    public function edit($id)
    {
        $data['doc'] = DocumentManagement::find($id);
        return view('document.edit',$data);
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required',
        ]);

        $fileName = '';
        $posted = $request->all();
        $doc = DocumentManagement::find($id);

        if ($request->hasFile('signing')) {
            $fileName = time() . '.' . $request->signing->extension();
            $request->signing->storeAs('public/document', $fileName);
            if ($doc->signing) {
                Storage::delete('public/document/' . $doc->signing);
            }
        } else {
            $fileName = $doc->signing;
        }

        $doc->title = $posted['title'];
        $doc->content = $posted['content'];
        $doc->signing = $fileName;
        $doc->save();

        return redirect()->route('doc')->with(['message' => 'Document updated successfully!', 'status' => 'success']);
    }

    public function destroy($id)
    {   
        $doc = DocumentManagement::find($id);
        if($doc->signing){
            Storage::delete('public/document/' . $doc->signing);
        }
        $doc->delete();

        return redirect()->route('doc')->with([
            'message' => 'Document deleted successfully!', 
            'status' => 'success'
        ]);
    }
}
