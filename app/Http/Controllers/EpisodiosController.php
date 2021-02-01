<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Temporada;
use Illuminate\Http\Request;

class EpisodiosController extends Controller
{
    public function index(Temporada $temporada, Request $request)
    {
        return view('episodios.index', [
            'episodios' => $temporada->episodios,
            'temporadaId' => $temporada->id,
            'mensagem' => $request->session()->get('mensagem')
         ]);
    }

    /*Estamos recebendo um número inteiro pela URL, mas podemos, no método do nosso Controller, 
    indicar que queremos um objeto - por exemplo, Temporada $temporada. Dessa forma, o Laravel vai, 
    a partir do valor recebido, criar uma temporada chamando o find(). Para que isso funcione, os parâmetros 
    na URL e no método precisam ter o mesmo nome. Portanto, no arquivo de rotas, mudaremos temporadaId 
    para temporada.*/

    public function assistir(Temporada $temporada, Request $request)
    {
        $episodiosAssistidos = $request->episodios;
        $temporada->episodios->each(function (Episodio $episodio)
        use ($episodiosAssistidos)
        {
            $episodio->assistido = in_array(
                $episodio->id,
                $episodiosAssistidos
            );
        });

        $temporada->push();
        $request->session()->flash('mensagem', 'Episódios marcados como assistidos');
        return redirect()->back(); //manda de volta pra ultima pagina
    }

}
