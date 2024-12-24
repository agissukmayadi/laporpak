<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        return view('contacts.index', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        
        $request->validate([
            'address' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string'],
        ]);

        $contact->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('contact')->with('success', 'Contact updated successfully.');
    }
}
