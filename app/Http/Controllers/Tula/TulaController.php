<?php

namespace App\Http\Controllers\Tula;

use App\Http\Controllers\Controller;
use App\Models\Administration\Agency;
use App\Models\Administration\Agent;
use App\Models\Administration\Countries\State;
use App\Models\Administration\Wharehouse;
use App\Models\Package\Package;
use App\Models\Tula\Tula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
      
        $tulas = Tula::orderBy('id','desc')->get();
       
        return view('admin.tulas.index',compact('tulas'));
    
    }

    public function create($id = null)
    {
        if(isset($id)){
            $tula = Tula::findOrFail($id);
            $packages = Package::where('id_tula',$id)->get();
        }else{
            $tula = null;
            $packages = null;
        }
      
        $agencies = Agency::orderBy('id','desc')->get();

        $agents = Agent::orderBy('id','desc')->get();

        $states = State::orderBy('id','desc')->get();
        
        $wharehouses = Wharehouse::all();
       
        return view('admin.tulas.create',compact('wharehouses','tula','agencies','agents','states','packages'));
    
    }

    public function store(Request $request)
    {
       
        $tula = new Tula();

        $tula->id_wharehouse_origin = $request->id_wharehouse_origin;
        $tula->id_wharehouse_destiny = $request->id_wharehouse_destiny;
        $tula->id_destination_state = $request->id_destination_state;
        $tula->cubic_foot = str_replace(',', '.', str_replace('.', '', $request->cubic_foot));
        $tula->dimension_width = str_replace(',', '.', str_replace('.', '', $request->dimension_width));
        $tula->dimension_length = str_replace(',', '.', str_replace('.', '', $request->dimension_length));
        $tula->dimension_high = str_replace(',', '.', str_replace('.', '', $request->dimension_high));
        $tula->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $tula->weight = str_replace(',', '.', str_replace('.', '', $request->weight));
        $tula->loadable_weight = str_replace(',', '.', str_replace('.', '', $request->loadable_weight));
        $tula->type_of_service = "Aéreo";
        $tula->class = $request->class;
        $tula->loose_packages = $request->loose_packages;
        $tula->reference = $request->reference;
        $tula->record = $request->record;
        $tula->number_of_packages = str_replace(',', '.', str_replace('.', '', $request->number_of_packages));
        
        $tula->save();

        return redirect('/tulas/create/'.$tula->id.'')->withSuccess('Se ha registrado exitosamente!');
       
    }

    public function storePackage(Request $request)
    {
       try{
      
        $package = Package::findOrFail($request->package_reference);

        $return = $this->validationStorePackage($package,$request);
            
        if($return != null){
            return $return;
        }
        
        $package->id_tula = $request->id_tula;
        $package->save();

       $this->updateTula($request);

        return redirect('/tulas/create/'.$request->id_tula.'')->withSuccess('Se ha registrado exitosamente el Paquete!');
        
        }catch(Exception $e){
            return redirect('/tulas/create/'.$request->id_tula.'')->withDanger('No se ha encontrado el Paquete!');
        }

    }

    public function updateTula($request){
        
        $consult_package_lumps = Package::leftJoin('package_lumps','package_lumps.id_package','packages.id')
        ->where('packages.id_tula',$request->id_tula)
        ->select(
         DB::raw('SUM(package_lumps.length_weight) As sum_length_weight')
        ,DB::raw('SUM(package_lumps.width_weight) As sum_width_weight')
        ,DB::raw('SUM(package_lumps.high_weight) As sum_high_weight')
        )
        ->first();

        $consult_packages = Package::
        where('packages.id_tula',$request->id_tula)
        ->select(
        DB::raw('SUM(packages.volume) As sum_volume')
        ,DB::raw('SUM(packages.starting_weight) As sum_starting_weight')
        ,DB::raw('SUM(packages.cubic_foot) As sum_cubic_foot')
        )
        ->first();

       
        $tula = Tula::findOrFail($request->id_tula);
        $tula->cubic_foot = $consult_packages->sum_cubic_foot;
        $tula->dimension_width =  $consult_package_lumps->sum_width_weight;
        $tula->dimension_length =  $consult_package_lumps->sum_length_weight;
        $tula->dimension_high =  $consult_package_lumps->sum_high_weight;
        $tula->volume = $consult_packages->sum_volume;
        $tula->weight = $consult_packages->sum_starting_weight;

        $tula->save();
    }

    public function validationStorePackage($package,$request){
       
        if($package->id_tula == $request->id_tula){
            return redirect('/tulas/create/'.$request->id_tula.'')->withDanger('Ya se agrego el Paquete en la Tula!');
        }

        if($package->id_tula != null){
            return redirect('/tulas/create/'.$request->id_tula.'')->withDanger('Ya se agrego el Paquete en otra Tula!');
        }
        if($package->id_paddle != null){
            return redirect('/tulas/create/'.$request->id_tula.'')->withDanger('Ya se agrego el Paquete en la Paleta '.$package->id_paddle.'!');
        }
        return null;
    }

    public function update(Request $request, $id)
    {
        
        $tula = Tula::findOrFail($id);

       
        $tula->id_office_agency = $request->id_office_agency;
        $tula->id_agent = $request->id_agent;
        $tula->id_destination_state = $request->id_destination_state;
        $tula->cubic_foot = str_replace(',', '.', str_replace('.', '', $request->cubic_foot));
        $tula->dimension_width = str_replace(',', '.', str_replace('.', '', $request->dimension_width));
        $tula->dimension_length = str_replace(',', '.', str_replace('.', '', $request->dimension_length));
        $tula->dimension_high = str_replace(',', '.', str_replace('.', '', $request->dimension_high));
        $tula->volume = str_replace(',', '.', str_replace('.', '', $request->volume));
        $tula->weight = str_replace(',', '.', str_replace('.', '', $request->weight));
        $tula->loadable_weight = str_replace(',', '.', str_replace('.', '', $request->loadable_weight));
        $tula->type_of_service = $request->type_of_service;
        $tula->class = $request->class;
        $tula->loose_packages = $request->loose_packages;
        $tula->reference = $request->reference;
        $tula->record = $request->record;
        $tula->number_of_packages = str_replace(',', '.', str_replace('.', '', $request->number_of_packages));
        

        $tula->save();

        return redirect('/tulas/create/'.$tula->id.'')->withSuccess('Se ha actualizado exitosamente!');

    }

    public function destroy(Request $request)
    {
        $tula = Tula::find($request->id_tula_modal); 

        if(isset($tula)){
            
            $tula->delete();
    
            return redirect('/tulas')->withSuccess('Se ha Eliminado Correctamente!!');
        }
    }

}
