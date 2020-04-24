<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request) {
        $series = serie::query()->orderBy('nome') ->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series' , 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required|min:3'
        ]);

        $serie = Serie::create($request->all());
        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} criada com sucesso {$serie->nome}"
            );
        //echo "Série com id {$serie->id} criada: {$serie->nome}";
        return redirect()->route('listar_series');
    }

    public function destroy (Request $request)
    {

        Serie::destroy($request->id);
        $request->session()
        ->flash(
            'mensagem',
            "Série removida com sucesso!"
        );
        return redirect()->route('listar_series');
    }
}
