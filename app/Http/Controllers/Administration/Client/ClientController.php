<?php

namespace App\Http\Controllers\Administration\Client;

use App\Models\Administration\Client;
use App\Models\Administration\Countries\Country;
use App\Http\Controllers\Controller;
use App\Models\Administration\Agency;
use App\Models\Package\Package;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ClientController extends Controller
{

    public function index(){

        $clients = Client::all();

        return view('admin.administrations.clients.index',compact('clients'));
    }

    public function register()
    {
        $countries = Country::orderBy('name','asc')->get();

        $agencies = Agency::orderBy('id','desc')->get();

        return view('clients.register.client_register',compact('countries','agencies'));
    
    }

    public function consult($id_client){

        $packages = Package::where('id_client',$id_client)
                            ->where('status',"LIKE",'(1) Recibido en Origen')
                            ->get();

        $client = Client::find($id_client);

        
        return view('admin.administrations.clients.consult',compact('packages','client'));
    }

    public function store(Request $request)
    {
      
        $data = request()->validate([
            'email'                 =>'required|max:40',
            'type_cedula'           =>'required',
            'cedula'                =>'required',
            'password'              =>'required|min:6|max:20',
            'confirm_password'      =>'required|min:6|max:20',
            'firstname'             =>'required|max:30',
            'firstlastname'         =>'required|max:30',
           

            'id_country'            =>'required',
            'direction'             =>'required|max:50',
           
            'City'                  =>'required',
            'street_received'       =>'required',
            'urbanization_received' =>'required',

           
           
            
    
           
        ]);

        $client = new Client();

       
        $client->type_cedula            = $request->type_cedula;         
        $client->cedula                 = $request->cedula;
        
        $client->firstname              = $request->firstname;    
        $client->firstlastname          = $request->firstlastname;     
        $client->secondname             = $request->secondname;    
        $client->secondlastname         = $request->secondlastname;     

        $client->id_country             = $request->id_country;       
        $client->direction              = $request->direction;       
       
        $client->id_state_received      = $request->City;         
        $client->street_received        = $request->street_received;  
        $client->urbanization_received  = $request->urbanization_received;
    
    
        $client->type_direction_received= $request->type_direction_received;

        $client->id_agency              = $request->id_agency;  

        $client->id_code_room           = $request->code_phone_room;  
        $client->id_code_work           = $request->code_phone_work;  
        $client->id_code_mobile         = $request->code_phone_mobile;  
        $client->id_code_fax            = $request->code_phone_fax;  

       
        $client->phone_room           = $request->phone_room;  
        $client->phone_work           = $request->phone_work;  
        $client->phone_mobile         = $request->phone_mobile;  
        $client->phone_fax            = $request->phone_fax;  
    
        $client->company                = $request->company;  
        $client->rif                    = $request->rif;  
        
        $client->save();

        $client->casillero =  $client->countries['abbreviation'].$client->id;
        
        $client->save();

        $user = new User();

        $user->id_client = $client->id;
        $user->name = $request->firstname;
        $user->email = $request->email;
        $user->password =  Hash::make(request('password'));

        $user->save();
    
        return redirect('/login')->withSuccess('Se ha registrado exitosamente, puede iniciar sesion con su correo y clave!');
       
    }

    public function select()
    {
        $clients = Client::paginate(1000);

        return view('admin.packages.selects.select_client',compact('clients'));
    
    }

    public function search(Request $request, $casillero = null){
        //validar si la peticion es asincrona
        if($request->ajax()){
            try{
            
                $client = Client::select('id','firstname','firstlastname')->where('casillero',$casillero)->get();
                return response()->json($client,200);
            }catch(Throwable $th){
                return response()->json(false,500);
            }
        }
        
    }
}
