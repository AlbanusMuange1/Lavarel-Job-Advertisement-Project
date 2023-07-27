<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Routing\Controller;
use function PHPUnit\Framework\fileExists;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
      return view('listings.index', [
        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(2)
    ]);
    }

    // Show single listing
    public function show(Listing $listing){
      return view('listings.show', [
        'listing' => $listing]);
    }

    // Show create form
    public function create(){
      return view('listings.create');
    }

    // Store listings data
    public function store(Request $request){
      $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags'  => 'required',
        'description' => 'required'
      ]);

      if ($request->hasFile('logo')) {
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
      }

      $formFields['user_id'] = auth()->id();

      Listing::create($formFields);

      return redirect('/')->with('success', 'Job Created Successfully');
    }

    // Show Edit Form
    public function edit(Listing $listing){
      return view('listings.edit', ['listing' => $listing]);
    }

    // Update to Database
    public function update(Request $request, Listing $listing){

      // Only Listings Owns Can Edit/Delete
      if ($listing->user_id != auth()->id) {
        abort(403, 'Unauthorized User');
      }

      $formFields = $request->validate([
        'title' => 'required',
        'company' => 'required',
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags'  => 'required',
        'description' => 'required'
      ]);

      if ($request->hasFile('logo')) {
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
      }

      $listing->update($formFields);

      return back()->with('success', 'Job Edited Successfully');
    }

    // Delete listing
    public function destroy(Listing $listing){

      // Only Listings Owns Can Edit/Delete
      if ($listing->user_id != auth()->id) {
        abort(403, 'Unauthorized User');
      }
      $listing->delete();
      return redirect('/')->with('success', 'Job Deleted Successfully');
    }
    // Manage Listings
    public function manage(){
      return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
