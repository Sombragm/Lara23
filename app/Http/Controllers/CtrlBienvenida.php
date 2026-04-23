<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtrlBienvenida extends Controller
{
    public function Bienvenidos(){
        return view('welcome');
    }

    public function Suma(){
        return (3+3);
    }

    public function Suma2($n1, $n2){
        return ('El resultado de la suma es: '.($n1+$n2));  
    }

    public function Suma3($n1, $n2){
        $datos = $n1 + $n2;
        $resultado = 'El resultado de la suma es: '.$datos;
        return view('welcome', compact('resultado'));
    }
}
