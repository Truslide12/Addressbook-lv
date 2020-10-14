<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Address;
use Carbon\Carbon;

class ContactController extends Controller
{
    // Contacts
    public function index() {
        return Contact::orderBy('firstName', 'desc')->get();
    }

    public function createContact(Request $request) {
        // validate
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthday' => 'required'
        ]);
        // convert birtday date to proper format
        $birthday = \Carbon\Carbon::parse($request->birthday)->format('Y/m/d');
        // create contact in database
        return Contact::create([
            'firstName'=> $request->firstName,
            'lastName'=> $request->lastName,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'birthday'=> $birthday,
        ]);
    }

    public function editContact(Request $request) {
        // validate
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthday' => 'required'
        ]);
        // convert birtday date to proper format
        $birthday = \Carbon\Carbon::parse($request->birthday)->format('Y/m/d');
        return Contact::where('id', $request->id)->update([
            'firstName'=> $request->firstName,
            'lastName'=> $request->lastName,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'birthday'=> $birthday,
        ]);
    }

    public function deleteContact($id) {
        // validate
        $contact = Contact::find($id);
        $contact->delete();

        return response()->json('The contact successfully deleted');
    }

    // Addresses
    public function details() {
        $contacts = Contact::orderBy('id', 'desc')->get();
        dd($contacts);
        return  $contacts;
    }

    public function createAddress(Request $request) {
        // validate
        $this->validate($request, [
            'number' => 'required',
            'Street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'type' => 'required',
        ]);
        return Address::create([
            'number'=> $request->firstName,
            'street'=> $request->lastName,
            'city'=> $request->email,
            'state'=> $request->phone,
            'zip'=> $request->birthday,
            'type'=> $request->type,
        ]);
    }

    public function editAddress(Request $request) {
        // validate
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'birthday' => 'required'
        ]);
        return Address::where('id', $request->id)->update([
            'firstName'=> $request->firstName,
            'lastName'=> $request->lastName,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'birthday'=> $request->birthday,
        ]);
    }

    public function deleteAddress($id) {
        // validate
        $address = Address::find($id);
        $address->delete();

        return response()->json('The address successfully deleted');
    }
}
