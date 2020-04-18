<?php
namespace App\Http\Controllers;

class SeriesController extends Controller
{

    public function index() {
        $series = [
            'Grey\'s Anatomy',
            'Lost',
            'Agents of SHIELD'
        ];

        return view ('series.index', [
            'series' => $series
        ]);

        // return view ('series.index', compact('series')); função do php que retorna chaves e variaveis com o mesmo nome
    }

    public function create()
    {
        return view('series.create');
    }

}