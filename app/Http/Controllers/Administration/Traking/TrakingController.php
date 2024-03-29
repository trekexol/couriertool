<?php

namespace App\Http\Controllers\Administration\Traking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Package\PackageController;
use App\Models\Administration\PackageStatus;
use App\Models\Package\Package;
use App\Models\Package\PackageCharge;
use App\Models\Package\PackageLump;
use Illuminate\Http\Request;

class TrakingController extends Controller
{
    public function index()
    {
        $package_trackings = Package::groupBy('tracking','id')->select('tracking','id')->get();
       
        return view('admin.trackings.index',compact('package_trackings'));
    
    }

    public function packageWithTracking(Request $request){

        $package_controller = new PackageController();

        return $package_controller->createByTracking($request->tracking);
    }

   
}
