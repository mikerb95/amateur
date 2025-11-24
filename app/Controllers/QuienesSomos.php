<?php
namespace App\Controllers;

class QuienesSomos extends BaseController
{
    public function index()
    {
        return view('inicio/quienes_somos');
    }
}
