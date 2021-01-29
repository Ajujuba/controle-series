@extends('layout')

@section('cabecalho')
Séries
@endsection

@section('conteudo')
@if(!empty($mensagem))
<div class="alert alert-success">
    {{ $mensagem }}
</div>
@endif
<a href="/series/criar" class="btn btn-dark mb-2">Adicionar</a>
    <table class="table table-hover">
        <thead>
          <tr class="text-center">
           
          </tr>
        </thead>
        <tbody >
            @foreach($series as $serie)
                <td> 
                    {{ $serie->nome }}
                </td>
                {{-- <td class="text-center">
                   <!-- <i class="fas fa-trash-alt"></i>-->
                    <a href="" class="btn btn-info"> Editar </a>
                </td> --}}
                
                <td class="text-center">
                    <span class="d-flex">
                    <a href="/series/{{ $serie->id }}/temporadas" class="btn btn-info btn-sm mr-1">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    <form method="post" action="/series/remover/{{ $serie->id}}" onsubmit="return confirm('Tem certeza que deseja remover {{ addslashes( $serie->nome )}}?')">
                        @csrf
                        @method('delete') 
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>  
                    </span>
                </td>
            </tr> 
            @endforeach
        
        </tbody>
      </table>        
</ul>
@endsection