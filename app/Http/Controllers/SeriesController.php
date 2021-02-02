<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Temporada;
use Illuminate\Http\Request;

class SeriesController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     /*Dessa forma, todos os métodos desse Controller terão que passar pelo middleware() 
    //     que foi passado na instanciação.*/
    // }

    public function index(Request $request) {
        $series = serie::query()->orderBy('nome') ->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series' , 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request, CriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie(
            $request->nome, 
            $request->qtd_temporadas, 
            $request->ep_por_temporada
        );

        $request->validate([
            'nome' => 'required|min:3'
        ]);

       
        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id}, suas temporadas e episódios foram criados com sucesso: {$serie->nome}"
            );
    
        return redirect()->route('listar_series');
        

    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
    
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect()->route('listar_series');

        /*Assim, estamos recebendo o id na requisição e buscando uma $serie a partir dele. Com ela, buscamos as temporadas e,
         para cada $temporada, executamos uma função que irá removê-la. Porém, antes disso, excluiremos cada 
         $episodio, executando a mesma função. Quando os episódios são removidos, podemos remover a temporada; 
        e quando as temporadas são removidas, podemos finalmente remover a série com sucesso.

        Repare que, como temos a variável $serie, antes de realizarmos a remoção, podemos pegar $nomeSerie = $serie->nome,
        passando esse nome para a mensagem que é exibida na tela.*/
    }

    public function editaNome(int $id, Request $request)
    {
        $serie = Serie::find($id);
        $novoNome = $request->nome;
        $serie->nome = $novoNome;
        $serie->save();
    }
}
