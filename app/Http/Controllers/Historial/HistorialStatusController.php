<?php

namespace App\Http\Controllers\Historial;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailController;
use App\Models\Historial\HistorialStatus;
use App\Models\Package\Package;
use Illuminate\Http\Request;

class HistorialStatusController extends Controller
{
    public function viewPackage($id_package)
    {
        $historial_status = HistorialStatus::where('id_package',$id_package)->get();

      
        return view('admin.historial_status.index',compact('historial_status','id_package'));
    }

    public function store(Request $request)
    {
      
        $historial_status = new HistorialStatus();

        $historial_status->id_package = $request->id_package;
        $historial_status->status = $request->status;
        $historial_status->description_status = $request->description_status;
        $historial_status->number_guide_transport = $request->number_guide_transport;
        
        $historial_status->save();

        $package = Package::findOrFail($historial_status->id_package);

        $package->status = $historial_status->status;

        
        $package->save();

       /* $mail_controller = new MailController();

        $mail_controller->sendEmail($request,$package);*/
       

        return redirect('historial_status/viewPackage/'.$request->id_package.'')->withSuccess('Se ha registrado el historial exitosamente!');
    }

    public function edit($id){

        $historia = HistorialStatus::find($id);

        $historial_status = HistorialStatus::where('id_package',$historia->id_package)->get();

        $id_package = $historia->id_package;

        return view('admin.historial_status.index',compact('historia','historial_status','id_package'));
    }

    public function update(Request $request, $id)
    {
       
        $historial_status = HistorialStatus::findOrFail($id);

        $historial_status->status = $request->status;
        $historial_status->description_status = $request->description_status;
        $historial_status->number_guide_transport = $request->number_guide_transport;
        
        $historial_status->save();

        return redirect('historial_status/viewPackage/'.$request->id_package.'')->withSuccess('Se ha actualizado exitosamente!');

    }

    public function destroy(Request $request)
    {
       
         $historial_status = HistorialStatus::find($request->id_historial_statu_modal); 
 
         if(isset($historial_status)){
             
             $historial_status->delete();
     
             return redirect('historial_status/viewPackage/'.$request->id_package_modal.'')->withSuccess('Se ha Eliminado Correctamente!!');
         }
    }
}
