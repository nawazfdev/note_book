<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Document management is coming soon!'
        ]);
    }

    public function show($id)
    {
        return view('documents.show');
    }

    public function edit($id)
    {
        return view('documents.edit');
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Document management is coming soon!'
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Document management is coming soon!'
        ]);
    }

    public function folder($folder)
    {
        return view('documents.folder');
    }

    public function upload(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Document management is coming soon!'
        ]);
    }
}