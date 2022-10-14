<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Administration\Agency\AgencyController;
use App\Http\Controllers\Controller;
use App\Models\Administration\Agency;
use App\Models\Administration\Agent;
use App\Models\Administration\Client;
use App\Models\Administration\Countries\Country;
use App\Models\Administration\DeliveryCompany;
use App\Models\Administration\PackageStatus;
use App\Models\Administration\TypeOfGood;
use App\Models\Administration\TypeOfPackaging;
use App\Models\Administration\Wharehouse;
use App\Models\Historial\HistorialStatus;
use App\Models\Package\Package;
use App\Models\Package\PackageCharge;
use App\Models\Package\PackageLump;
use App\Models\Package\PackageTypeOfGood;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\ArrayList;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
      
        $packages = Package::leftJoin('package_lumps','package_lumps.id_package','packages.id')
                            ->leftJoin('clients','clients.id','packages.id_client')
                            ->leftJoin('agencies as agencies_client','agencies_client.id','clients.id_agency')
                            ->leftJoin('agencies','agencies.id','packages.id_agency_office_location')
                            ->leftJoin('agents','agents.id','packages.id_agent_vendor')
                            ->leftJoin('agents as agent_shipper','agent_shipper.id','packages.id_agent_shipper')
                            ->leftJoin('wharehouses','wharehouses.id','packages.id_wharehouse')
                            ->leftJoin('countries','countries.id','packages.id_origin_country')
                            ->leftJoin('countries as destination_country','destination_country.id','packages.id_destination_country')
                            ->leftJoin('delivery_companies','delivery_companies.id','packages.id_delivery_company')
                            ->where('id_tula',null)
                            ->where('id_paddle',null)
                            ->select('packages.id','packages.id_agent_shipper','packages.id_agent_vendor'
                            ,'agencies_client.name as name_agency_client','agent_shipper.name as agent_shipper_name',
                            'packages.tracking','packages.status','clients.direction','clients.street_received','clients.urbanization_received','clients.casillero','clients.firstname','clients.firstlastname','clients.type_cedula','clients.id_agency','clients.cedula',
                            'packages.description','packages.starting_weight','packages.final_weight','packages.arrival_date','packages.volume','packages.cubic_foot'
                            ,'packages.date_payment','packages.instruction','packages.content','packages.value',
                            'agencies.name as agency_name','wharehouses.code as wharehouse_code','wharehouses.name as wharehouse_name','agents.name as agent_name',
                            DB::raw('COUNT(package_lumps.id_package) As count_package_lumps')
                            ,'destination_country.name as destination_country_name','countries.name as country_name'
                            ,'delivery_companies.description as delivery_company_name'
                            ,'packages.service_type','packages.instruction','packages.number_transport_guide'
                            ,'packages.instruction_type','package_lumps.length_weight','package_lumps.width_weight','package_lumps.high_weight'
                            ,'packages.id_tula','packages.id_paddle'
                            ,'packages.dangerous_goods','packages.sed'
                            ,'packages.document','packages.fragile')
                            ->groupBy('packages.id','packages.id_agent_shipper','packages.id_agent_vendor',
                                    'agencies_client.name','agent_shipper.name',
                                    'packages.tracking','packages.status','clients.direction','clients.street_received','clients.urbanization_received','clients.casillero','clients.firstname','clients.firstlastname','clients.type_cedula','clients.id_agency','clients.cedula',
                                    'packages.description','packages.starting_weight','packages.final_weight','packages.arrival_date','packages.volume','packages.cubic_foot'
                                    ,'packages.date_payment','packages.instruction','packages.content','packages.value','agencies.name','wharehouses.code','wharehouses.name','agents.name'
                                    ,'destination_country.name','countries.name'
                                    ,'delivery_companies.description','packages.service_type','packages.instruction','packages.number_transport_guide'
                                    ,'packages.instruction_type','package_lumps.length_weight','package_lumps.width_weight','package_lumps.high_weight'
                                    ,'packages.id_tula','packages.id_paddle'
                                     ,'packages.dangerous_goods','packages.sed'
                                    ,'packages.document','packages.fragile')
                            ->orderBy('packages.id','desc')
                            ->get();

        
        if(isset($packages)){
            $agencyController = new AgencyController();
            foreach($packages as $package){
                $package->agency = $agencyController->returnAgencyById($package->id_agency);
            }
        }

      
        $agencies = Agency::orderBy('name','asc')->get();

        $wharehouses = Wharehouse::orderBy('name','asc')->get();

      
        
      
        return view('admin.packages.index',compact('packages','agencies','wharehouses'));
    
    }

    public function create($id_package = null)
    {
        if(isset($id_package)){

            $package = Package::find($id_package);

            $package_lumps = PackageLump::where('id_package',$package->id)->orderBy('id','asc')->get();

            $package_type_of_goods = PackageTypeOfGood::where('id_package',$package->id)->orderBy('id','asc')->get();

        }else{
           
            $package = null;

            $package_lumps = null;

            $package_type_of_goods = null;
        }
        
        $agents = Agent::orderBy('name','asc')->get();

        $agencies = Agency::orderBy('name','asc')->get();

        $countries = Country::orderBy('name','asc')->get();

        $wharehouses = Wharehouse::orderBy('name','asc')->get();

        $delivery_companies = DeliveryCompany::orderBy('description','asc')->get();

        $type_of_goods = TypeOfGood::orderBy('description','asc')->get();

        $type_of_packagings = TypeOfPackaging::orderBy('description','asc')->get();

        $clients = Client::orderBy('firstname','asc')->get();

        $date = Carbon::now();
        $datenow = $date->format('Y-m-d'); 
       
        return view('admin.packages.create',compact('datenow','agencies','package_type_of_goods','package_lumps','package','clients','agents','countries','wharehouses','delivery_companies','type_of_goods','type_of_packagings'));
    
    }

    public function createWithClient($id_client,$id_package = null)
    {
        $client = Client::find($id_client);

        if(empty($client)){
            $client = null;
        }

        if(isset($id_package)){
            $package = Package::find($id_package);

            $package_lumps = PackageLump::where('id_package',$package->id)->orderBy('id','asc')->get();

            $package_type_of_goods = PackageTypeOfGood::where('id_package',$package->id)->orderBy('id','asc')->get();

        }else{
            $package = null;

            $package_lumps = null;

            $package_type_of_goods = null;
        }
        
        $agents = Agent::orderBy('name','asc')->get();

        $agencies = Agency::orderBy('name','asc')->get();

        $countries = Country::orderBy('name','asc')->get();

        $wharehouses = Wharehouse::orderBy('name','asc')->get();

        $delivery_companies = DeliveryCompany::orderBy('description','asc')->get();

        $type_of_goods = TypeOfGood::orderBy('description','asc')->get();

        $type_of_packagings = TypeOfPackaging::orderBy('description','asc')->get();

        $date = Carbon::now();
        $datenow = $date->format('Y-m-d'); 
       
        return view('admin.packages.create',compact('datenow','agencies','package_type_of_goods','package_lumps','package','client','agents','countries','wharehouses','delivery_companies','type_of_goods','type_of_packagings'));
    
    }

    
    public function createByTracking($tracking)
    {
        
        if(isset($tracking)){
            $package = Package::where('tracking',$tracking)->first();
           
            if(isset($package)){

                $package_lumps = PackageLump::where('id_package',$package->id)->orderBy('id','asc')->get();

                $package_type_of_goods = PackageTypeOfGood::where('id_package',$package->id)->orderBy('id','asc')->get();    
            
            }else{

                $package = null;

                $package_lumps = null;
    
                $package_type_of_goods = null;
            }
           
        }else{
            return redirect('/packages')->withDanger('No se recibio el tracking!');
        }
        
        $agents = Agent::orderBy('name','asc')->get();

        $countries = Country::orderBy('name','asc')->get();

        $wharehouses = Wharehouse::orderBy('name','asc')->get();

        $delivery_companies = DeliveryCompany::orderBy('description','asc')->get();

        $type_of_goods = TypeOfGood::orderBy('description','asc')->get();

        $type_of_packagings = TypeOfPackaging::orderBy('description','asc')->get();

        $clients = Client::orderBy('firstname','asc')->get();

        $agencies = Agency::orderBy('name','asc')->get();
       
        return view('admin.packages.create',compact('agencies','tracking','package_type_of_goods','package_lumps','package','clients','agents','countries','wharehouses','delivery_companies','type_of_goods','type_of_packagings'));
    
    }
 

    public function store(Request $request)
    {
        //VALIDACION PARA SABER SI EL TRACKING YA EXISTE, SI EXISTE SE ENVIA UN MENSAJE DE ALERTA
        if(isset($request->tracking)){
            $exist_tracking = Package::where('tracking',$request->tracking)->first();
            if($exist_tracking){
                return redirect('/packages')->withDanger('El tracking ya existe en la base de datos!');
            }
        }

        if(isset($request->client_casillero)){
            $client = Client::where('casillero',$request->client_casillero)->first();
            if(empty($client)){
                return redirect('/packages')->withDanger('El casillero del cliente no existe en la base de datos!');
            }
        }else{
            return redirect('/packages')->withDanger('El casillero del cliente no existe en la base de datos!');
        }
        

        $package = new Package();

        $package->id_client = $client->id;
        $package->tracking = $request->tracking;
        $package->id_agent_shipper = $request->id_agent_shipper;
        $package->id_agent_vendor = $request->id_agent_vendor;
        $package->arrival_date = $request->arrival_date.' '.$request->check_in;
        $package->id_agency_office_location = $request->id_agency_office_location;
        $package->id_wharehouse = $request->id_wharehouse;
        $package->content = $request->content;
        $package->value = str_replace(',', '.', str_replace('.', '',$request->value));
        $package->id_origin_country = $request->id_origin_country;
        $package->id_destination_country = $request->id_destination_country;
        $package->id_delivery_company = $request->id_delivery_company;
        $package->number_transport_guide = $request->number_transport_guide;
        $package->service_type = $request->service_type;
        $package->instruction = $request->instruction;
        $package->instruction_type = $request->instruction_type;
        $package->description = $request->description;

       
        if(isset($request->checks)){
            foreach($request->checks as $check){
                if($check == "high_value"){
                    $package->high_value = true;
                }
                if($check == "dangerous_goods"){
                    $package->dangerous_goods = true;
                }
                if($check == "sed"){
                    $package->sed = true;
                }
                if($check == "document"){
                    $package->document = true;
                }
                if($check == "fragile"){
                    $package->fragile = true;
                }
            }
        }
        $package->status = "(1) Recibido en Origen";
       
        $package->save();
       

        return redirect('/packages/create/'.$package->id.'')->withSuccess('Se ha registrado exitosamente!');
       
    }
   
    public function payment($id)
    {
        //VALIDACION PARA SABER SI EL TRACKING YA EXISTE, SI EXISTE SE ENVIA UN MENSAJE DE ALERTA
        if(isset($id)){
            $package = Package::findOrFail($id);
        }
        $date = Carbon::now();
        $datenow = $date->format('Y-m-d'); 

        if(empty($package->date_payment)){
            $package->date_payment = $datenow;
            $message = 'Se ha registrado el pago exitosamente!';
        }else{
            $package->date_payment = null;
            $message = 'Se ha eliminado el pago exitosamente!';
        }

        $package->save();

        return redirect('/packages/index')->withSuccess($message);
    }

    public function tipoEnvio($id)
    {
        //VALIDACION PARA SABER SI EL TRACKING YA EXISTE, SI EXISTE SE ENVIA UN MENSAJE DE ALERTA
        if(isset($id)){
            $package = Package::findOrFail($id);
        }
        $date = Carbon::now();
        $datenow = $date->format('Y-m-d'); 

        if($package->instruction == "Aéreo"){
            $package->instruction = "Marítimo";
            $message = 'Se ha cambiado a Marítimo exitosamente!';
        }else{
            $package->instruction = "Aéreo";
            $message = 'Se ha cambiado a Aéreo exitosamente!';
        }

        $package->save();

        return redirect('/packages/index')->withSuccess($message);
    }

    public function update(Request $request,$id)
    {
        //VALIDACION PARA SABER SI EL TRACKING YA EXISTE, SI EXISTE SE ENVIA UN MENSAJE DE ALERTA
        if(isset($id)){
            $package = Package::findOrFail($id);
        }

        if(isset($request->client_casillero)){
            $client = Client::where('casillero',$request->client_casillero)->first();
            if(empty($client)){
                return redirect('/packages')->withDanger('El casillero del cliente no existe en la base de datos!');
            }
        }else{
            return redirect('/packages')->withDanger('El casillero del cliente no existe en la base de datos!');
        }

        $package->id_client = $client->id;
        $package->tracking = $request->tracking;
        $package->id_agent_shipper = $request->id_agent_shipper;
        $package->id_agent_vendor = $request->id_agent_vendor;
        $package->arrival_date = $request->arrival_date.' '.$request->check_in;
        $package->id_agency_office_location = $request->id_agency_office_location;
        $package->id_wharehouse = $request->id_wharehouse;
        $package->content = $request->content;
        $package->value = str_replace(',', '.', str_replace('.', '',$request->value));
        $package->id_origin_country = $request->id_origin_country;
        $package->id_destination_country = $request->id_destination_country;
        $package->id_delivery_company = $request->id_delivery_company;
        $package->number_transport_guide = $request->number_transport_guide;
        $package->service_type = $request->service_type;
        $package->instruction = $request->instruction;
        $package->instruction_type = $request->instruction_type;
        $package->description = $request->description;

        //dd($request);
     
        if(isset($request->checks)){
            
            foreach($request->checks as $check){
               
                if($check == "high_value"){
                    $package->high_value = true;
                    $high_value = true;
                }

                if($check == "dangerous_goods"){
                    $package->dangerous_goods = true;
                    $dangerous_goods = true;
                }

                if($check == "sed"){
                    $package->sed = true;
                    $sed = true;
                }

                if($check == "document"){
                    $package->document = true;
                    $document = true;
                }

                if($check == "fragile"){
                    $package->fragile = true;
                    $fragile = true;
                }
            }
            if(empty($high_value)){
                $package->high_value = false;
            }
            if(empty($dangerous_goods)){
                $package->dangerous_goods = false;
            }
            if(empty($sed)){
                $package->sed = false;
            }
            if(empty($document)){
                $package->document = false;
            }
            if(empty($fragile)){
                $package->fragile = false;
            }
        }

       
        $package->save();
       

        return redirect('/packages/create/'.$package->id.'')->withSuccess('Se ha Actualizado exitosamente!');
       
    }

    public function destroy(Request $request)
    {
         $package = Package::find($request->id_package_modal); 
 
         if(isset($package)){
            PackageLump::where('id_package',$package->id)->delete();
            PackageCharge::where('id_package',$package->id)->delete();
            HistorialStatus::where('id_package',$package->id)->delete();
            Package::where('id',$package->id)->delete();

            $package->delete();
     
            return redirect('/packages/index')->withSuccess('Se ha Eliminado Correctamente el Paquete!!');
         }
    }
}
