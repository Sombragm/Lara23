<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ctrlDatos extends Controller
{
    public function AccesoDatosVista(){
        $pro = Product::all();
        return view('vistadatos')->with(compact('pro'));
    }

    public function AccesoDatosVistaLink(){
        $response = Http::get('https://pruebavillarreal.netlify.app/recipes.json');
        $res = $response->json();
        return view('vistadatoslink')->with(compact('res'));
    }

    public function AccesoDatosVistaLinkC(){
        $response = Http::get('https://holisss.mundoiti.com/');
        $res = $response->json();
        return view('vistadatoslinkC')->with(compact('res'));
    }

    public function Detalles($id){
        $response = Http::get("https://pruebavillarreal.netlify.app/recipes.json");
        $res = $response->json();
        $res = collect($res)->firstWhere('id', $id);
        return view('vistadatosdetalle')->with(compact('res'));
    }
}
