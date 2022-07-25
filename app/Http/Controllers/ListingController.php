<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{


    /*
        Common Resouse Routes:
        index - show all listings
        show - Show single listing
        create - Show form to create new listing
        store - Store new listing
        edit - Show form to edit listing
        update - update listing
        destroy - delete listing
    */

    public function index()
    {
        return view(
            'listings.index',
            [
                'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6)
            ]
        );
    }
    //Show Single Listing
    public function show(Listing $listing)
    {
        return view('listings.show', ['item' => $listing]);
    }

    //Show create form
    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email']
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully');
    }
    //Show Edit Form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        //Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email']
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFields);
        return back()->with('message', 'Listing updated successfully');
    }

    //Delete Listing
    public function destroy(Listing $listing)
    {
        //Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', "Listing deleted succesfully");
    }
    //Manage Listings
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
