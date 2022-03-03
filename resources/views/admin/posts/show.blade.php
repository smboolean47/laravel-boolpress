@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{$post->title}}</h2>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        @if ($post->image)
                            <img src="{{asset("storage/{$post->image}")}}" alt="{{$post->title}}">
                        @endif
                    </div>
                    <div class="mb-3">
                        <a href="{{route("posts.edit", $post->id)}}"><button type="button" class="btn btn-warning">Modifica</button></a>
                        <form action="{{route("posts.destroy", $post->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                    <div class="mb-3">
                        <strong>Stato:</strong>
                        @if ($post->published)
                            <span class="badge badge-success">Pubblicato</span>
                        @else
                            <span class="badge badge-secondary">Bozza</span>
                        @endif
                    </div>
                    @if ($post->category)
                        <div class="mb-3">
                            <strong>Categoria:</strong> 
                            {{$post->category->name}}
                        </div>
                    @endif

                    @if (count($post->tags) > 0)
                        <div class="mb-3">
                            <strong>Tags:</strong> 
                            @foreach ($post->tags as $tag)
                            <span class="badge badge-primary">{{$tag->name}}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div>
                        {!!$post->content!!}
                    </div>

                    @if (count($post->comments) > 0)
                    <div class="mt-3" id="comments">
                        <h3>Commenti</h3>
                        <table class="table">
                            <tbody>
                                @foreach ($post->comments as $comment)
                                <tr>
                                    <td>{{$comment->content}}</td>
                                    <td>
                                        @if(!$comment->approved)
                                            <form action="{{route('comments.update', $comment->id)}}" method="POST">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" class="btn btn-success">Approva</button>
                                            </form>
                                        @else
                                            Approvato
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route("comments.destroy", $comment->id)}}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection