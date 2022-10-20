<?php

namespace App\Http\Controllers\Paddle;

use App\Http\Controllers\Controller;
use App\Models\Administration\Agency;
use App\Models\Administration\Agent;
use App\Models\Administration\Countries\State;
use App\Models\Package\Package;
use App\Models\Paddle\Paddle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaddleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
      
        $paddles = Paddle::orderBy('id','desc')->get();
       
        return view('admin.paddles.index',compact('paddles'));
    
    }

    public function create($id = null)
    {
        if(isset($id)){
            $paddle = Paddle::find($id);
            $packages = Package::where('id_paddle',$id)->get();
        }else{
            $paddle = null;
            $packages = null;
        }
      
        $agencies = Agency::orderBy('id','desc')->get();

        $agents = Agent::orderBy('id','desc')->get();

        $states = State::orderBy('id','desc')->get();

       
        return view('admin.paddles.create',compact('paddle','agencies','agents','states','packages'));
    
    }

    public function store(Request $request)
    {
       
        $paddle = new Paddle();

        $paddle->id_office_agency = $request->id_office_agency;
        $paddle->id_agent = $request->id_agent;
        $paddle->id_destination_state = $request->id_destination_state;
        $paddle->dimension_width = str_replace(',', '.', str_replace('.', '', $request->dimension_width));
        $paddle->dimension_length = str_replace(',', '.', str_replace('.', '', $request->dimension_length));
        $paddle->dimension_high = str_replace(',', '.', str_replace('.', '', $request->dimension_high));
        $paddle->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $paddle->weight = str_replace(',', '.', str_replace('.', '', $request->weight));
        $paddle->loadable_weight = str_replace(',', '.', str_replace('.', '', $request->loadable_weight));
        $paddle->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $paddle->type_of_service = $request->type_of_service;
        $paddle->class = $request->class;
        $paddle->loose_packages = $request->loose_packages;
        $paddle->reference = $request->reference;
        $paddle->record = $request->record;
        $paddle->number_of_packages = str_replace(',', '.', str_replace('.', '', $request->number_of_packages));
        
        $paddle->save();

        return redirect('/paddles/create/'.$paddle->id.'')->withSuccess('Se ha registrado exitosamente!');
       
    }
    public function storePackage(Request $request)
    {
        try{

            $package = Package::findOrFail($request->package_reference);

            $return = $this->validationStorePackage($package,$request);
            
            if($return != null){
                return $return;
            }
        
            $package->id_paddle = $request->id_paddle;

            $package->save();

            $this->updatePaddle($request);

            return redirect('/paddles/create/'.$request->id_paddle.'')->withSuccess('Se ha registrado exitosamente el Paquete!');
        
        }catch(Exception $e){
            return redirect('/paddles/create/'.$request->id_paddle.'')->withDanger('No se ha encontrado el Paquete!');
        }

    }

    public function updatePaddle($request){
        
        $consult_package_lumps = Package::leftJoin('package_lumps','package_lumps.id_package','packages.id')
        ->where('packages.id_paddle',$request->id_paddle)
        ->select(
         DB::raw('SUM(package_lumps.length_weight) As sum_length_weight')
        ,DB::raw('SUM(package_lumps.width_weight) As sum_width_weight')
        ,DB::raw('SUM(package_lumps.high_weight) As sum_high_weight')
        )
        ->first();

        $consult_packages = Package::
        where('packages.id_paddle',$request->id_paddle)
        ->select(
        DB::raw('SUM(packages.volume) As sum_volume')
        ,DB::raw('SUM(packages.starting_weight) As sum_starting_weight')
        )
        ->first();

       
        $paddle = Paddle::findOrFail($request->id_paddle);
        $paddle->dimension_width =  $consult_package_lumps->sum_width_weight;
        $paddle->dimension_length =  $consult_package_lumps->sum_length_weight;
        $paddle->dimension_high =  $consult_package_lumps->sum_high_weight;
        $paddle->volume = $consult_packages->sum_volume;
        $paddle->weight = $consult_packages->sum_starting_weight;

        $paddle->save();
    }
    public function validationStorePackage($package,$request){
       
        if($package->id_paddle == $request->id_paddle){
            return redirect('/paddles/create/'.$request->id_paddle.'')->withDanger('Ya se agrego el Paquete en la Paleta!');
        }

        if($package->id_paddle != null){
            return redirect('/paddles/create/'.$request->id_paddle.'')->withDanger('Ya se agrego el Paquete en otra Paleta!');
        }
        if($package->id_tula != null){
            return redirect('/paddles/create/'.$request->id_paddle.'')->withDanger('Ya se agrego el Paquete en la Tula '.$package->id_tula.'!');
        }

        return null;
    }


    public function update(Request $request, $id)
    {
        
        $paddle = Paddle::findOrFail($id);

       
        $paddle->id_office_agency = $request->id_office_agency;
        $paddle->id_agent = $request->id_agent;
        $paddle->id_destination_state = $request->id_destination_state;
        $paddle->dimension_width = str_replace(',', '.', str_replace('.', '', $request->dimension_width));
        $paddle->dimension_length = str_replace(',', '.', str_replace('.', '', $request->dimension_length));
        $paddle->dimension_high = str_replace(',', '.', str_replace('.', '', $request->dimension_high));
        $paddle->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $paddle->weight = str_replace(',', '.', str_replace('.', '', $request->weight));
        $paddle->loadable_weight = str_replace(',', '.', str_replace('.', '', $request->loadable_weight));
        $paddle->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $paddle->type_of_service = $request->type_of_service;
        $paddle->class = $request->class;
        $paddle->loose_packages = $request->loose_packages;
        $paddle->reference = $request->reference;
        $paddle->record = $request->record;
        $paddle->number_of_packages = str_replace(',', '.', str_replace('.', '', $request->number_of_packages));
        

        $paddle->save();

        return redirect('/paddles/create/'.$paddle->id.'')->withSuccess('Se ha actualizado exitosamente!');

    }

    public function destroy(Request $request)
    {
        $paddle = Paddle::find($request->id_paddle_modal); 

        if(isset($paddle)){
            
            $paddle->delete();
    
            return redirect('/paddles')->withSuccess('Se ha Eliminado Correctamente!!');
        }
    }
}
