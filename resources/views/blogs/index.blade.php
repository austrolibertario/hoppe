@extends('layouts.default')

@section('title')
   Lista de Blogs @parent
@stop

@section('content')
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Blogs
            <a class="btn btn-success pull-right" href="{{ route('blogs.create') }}"><i class="glyphicon glyphicon-plus"></i> Criar</a>
        </h1>

    </div>
    <div class="row">
        <div class="col-md-12">
            @if($blogs->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Url</th>
                            <th>Descrição</th>
                            <th>Capa</th>
                            <th>Id do Usuário</th>
                            <th>Artigos</th>
                            <th>Inscritos</th>
                            <th>Recomendado?</th>
                            <th>Bloqueado?</th>
                            <th class="text-right">Opções</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{$blog->id}}</td>
                                <td>{{$blog->name}}</td>
                                <td>{{$blog->slug}}</td>
                                <td>{{$blog->description}}</td>
                                <td>{{$blog->cover}}</td>
                                <td>{{$blog->user_id}}</td>
                                <td>{{$blog->article_count}}</td>
                                <td>{{$blog->subscriber_count}}</td>
                                <td>{{$blog->is_recommended}}</td>
                                <td>{{$blog->is_blocked}}</td>
                                <td class="text-right">
                                    <a class="btn btn-xs btn-primary" href="{{ route('blogs.show', $blog->id) }}"><i class="glyphicon glyphicon-eye-open"></i> Visualizar</a>
                                    <a class="btn btn-xs btn-warning" href="{{ route('blogs.edit', $blog->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Quer deletar? Tem certeza disso?')) { return true } else {return false };">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Deletar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $blogs->render() !!}
            @else
                <h3 class="text-center alert alert-info">Vazio!</h3>
            @endif

        </div>
    </div>

@endsection