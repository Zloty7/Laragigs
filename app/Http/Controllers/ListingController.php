<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Termwind\Components\Li;

class ListingController extends Controller
{
    public function index(Request $request)
    {
//        dd(Listing::latest()->filter(request(['tag', 'search']))->paginate(2));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $newListing = Listing::create($data);

        return redirect(route('show', ['listing' => $newListing->id]))->with('message', 'Listing created
        successfully!');
    }

    public function edit(Listing $listing)
    {
        if ($listing->user_id != auth()->user()->id){
            abort(403, 'Unauthorized');
        }
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id != auth()->user()->id){
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($data);

        return redirect(route('show', ['listing' => $listing->id]))->with('message', 'Listing updated
        successfully!');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->user()->id){
            abort(403, 'Unauthorized');
        }
        $listing->delete();
        return redirect(route('index'))->with('message', 'Listing deleted successfully!');
    }

    public function manage()
    {
        $usersListings = auth()->user()->listings()->get();
        return view('listings.manage', ['listings' => $usersListings]);
    }
}
