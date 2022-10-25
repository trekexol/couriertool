<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Administration\Client;
use Illuminate\Http\Request;

class PackageSelectController extends Controller
{
    public function selectClient($id_package = null)
    {
       
        $clients = Client::orderBy('firstname','asc')->paginate(30);

       
       
        return view('admin.packages.selects.select_client',compact('id_package','clients'));
    
    }
}
