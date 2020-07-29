<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImagesImport;

class ImageController extends Controller
{
    
	public function index(){

		return view('image-upload');

	}

    public function upload(Request $request){

    	Excel::import(new ImagesImport, $request->file('import_file'), null, \Maatwebsite\Excel\Excel::CSV);
        
        return back()->with('success', 'Las imágenes se subieron correctamente');

    }
}
