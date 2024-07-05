<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Str;

class ContactController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $contact = Contact::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.contact.table', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'description' => 'required',
        ]);

            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'description' => $request->description,
            ]);
        
     return redirect(route('contacts.company'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $contact = Contact::find($id);

        return view('admin.contact.edit')->with([
            'contact' => $contact,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        
        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'description' => 'required',
        ]);

        $contact = Contact::find($id);

            $contact->update([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'description' => $request->description,
            ]);
        
         return redirect(route('contact.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect(route('contact.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}