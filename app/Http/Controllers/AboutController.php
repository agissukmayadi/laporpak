<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();

        return view('abouts.index', compact('about'));
    }

    public function update(Request $request, About $about)
    {

        $request->validate([
            'description' => ['required', 'string'],
        ]);

        $about->description = $request->description;
        $about->save();

        return redirect()->route('about')->with('success', 'About updated successfully.');
    }
}