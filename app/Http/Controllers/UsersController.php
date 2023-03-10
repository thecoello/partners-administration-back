<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Invoices;
use App\Models\Users;
use App\Models\Locations;
use App\Models\Packages;


class UsersController extends Controller
{
    public function showAllUsers()
    {
        return response()->json(Users::all());
    }

    public function showUser($id)
    {
        return response()->json(Users::find($id));
    }

    public function showAllUsersInvoices()
    {
        $allUsersInvoice = array();

        $userInvoice = [
            "id" => "",
            "contact" => "",
            "name" => "",
            "email" => "",
            "user_type" => "",
            "contract_file" => "",
            "location" => "",
            "pricetype" => "",
            "company_name" => "",
            "category" => "",
            "quantity" => "",
            "vat" => "",
            "subtotal" => "",
            "iva" => "",
            "total" => "",
            "address" => "",
            "zip" => "",
            "country" => "",
            "invoice_number" => "",
            "payment_status" => "",
            "payment_method" => "",
            "invoice_date" => ""
        ];

        $users = Users::all();
        
        foreach ($users as $key => $user) {
            $userInvoice["id"] = $user->id;
            $userInvoice["name"] = $user->name;
            $userInvoice["contact"] = $user->contact;
            $userInvoice["email"] = $user->email;
            $userInvoice["user_type"] = $user->user_type;
            $userInvoice["contract_file"] = $user->contract_file;
            $Invoice = Invoices::where('user_id', $user->id)->first();
            $Location = Locations::where('id', $Invoice->location)->first();
            $userInvoice["location"] = $Location->location_name;

            if($Invoice->pricetype == 1){
                $userInvoice["pricetype"] = "Regular";
            }elseif ($Invoice->pricetype == 2) {
                $userInvoice["pricetype"] = "Early bird";
            }

            $userInvoice["company_name"] = $Invoice->company_name;
            $Location = Locations::where('id', $Invoice->location)->first();
            $Category = Packages::where('id', $Invoice->category)->first();
            $userInvoice["category"] = $Category->pack_name;
            $userInvoice["quantity"] = $Invoice->quantity;
            $userInvoice["vat"] = $Invoice->vat;
            $userInvoice["subtotal"] = $Invoice->subtotal;
            $userInvoice["iva"] = $Invoice->iva;
            $userInvoice["total"] = $Invoice->total;
            $userInvoice["address"] = $Invoice->address;
            $userInvoice["zip"] = $Invoice->zip;
            $userInvoice["country"] = $Invoice->country;
            $userInvoice["invoice_number"] = $Invoice->invoice_number;
            $userInvoice["payment_status"] = $Invoice->payment_status;
            $userInvoice["payment_method"] = $Invoice->payment_method;
            $userInvoice["invoice_date"] = $Invoice->invoice_date;


            array_push($allUsersInvoice, $userInvoice);
        }
        
        return response()->json($allUsersInvoice);
    }

 /*    public function showUserInvoice($id)
    {
        $Invoice = Invoices::where('user_id', $user_id)->first();
        return response()->json(Users::all());
    } */


    public function createUser(Request $request)
    {

        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "contract_file" => "required|mimes:pdf",
            "user_type" => "required",
        ]);

        $request->file('contract_file')->move('public/contracts/', time() . "_" . $request->name . '_' . 'contract' . '.pdf');

        $userRequest = [
            "name" => $request->name,
            "contact" => $request->contact,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "contract_file" => 'public/contracts/' . time() . "_" . $request->name . '_' . 'contract' . '.pdf',
            "user_type" => $request->user_type,
        ];


        $user = Users::create($userRequest);
        return response()->json($user, 201);
    }

    public function updateUser($id, Request $request)
    {
        $user = Users::findOrFail($id);

        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email",
            "user_type" => "required",
        ]);

        if ($request->password) {
            $request->offsetSet("password", Hash::make($request->password));
            $user->update($request->all());
        }

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function deteleUser($id)
    {
        Users::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
