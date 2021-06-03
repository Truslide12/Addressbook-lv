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
        return Contact::orderBy('id', 'asc')->get();
        // $contacts = Contact::latest()->paginate(5);
        // return response()->json($contacts);
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
        // dump($request);
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

    public function deleteContact(Request $request) {
        // validate
        $contact = Contact::find($request->id);
        $contact->delete();

        return response()->json('The contact successfully deleted');
    }

    // Addresses
    public function details(Request $request) {
        // dump($request);
        $contactData = Contact::find($request->id);

        $addressList = $contactData->addresses;
        // $data = [$contactData,$addressLists];
        // dump($contactData);
        // dump($addressList);
        if($addressList) {
            // $addressLists = $contactData->addresses;
            // return ($contactData);
            return response()->json($addressList->toArray());
        } else {
            return response()->json('The contact details failed');
            // return redirect('index');
        }
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
