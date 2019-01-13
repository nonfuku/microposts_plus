@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="media-object rounded img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            @include('users.navtabs', ['user' => $user])
            @foreach ($favorites as $favorite)
                <li class="media mb-3">
                    <img class="media-object rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                    <div class="media-body ml-3">
                        <div>
                            {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $favorite->created_at }}</span>
                        </div>
                        <div>
                            <p>{!! nl2br(e($favorite->content)) !!}</p>
                        </div>
                        <div>
                            @if (Auth::user()->is_favorites($favorite->id))
                                {!! Form::open(['route' => ['favorites.unfavorite', $favorite->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('unfavorite', ['class' => "btn btn-secondary"]) !!}
                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['route' => ['favorites.favorite', $favorite->id]]) !!}
                                    {!! Form::submit('favorite', ['class' => "btn btn-primary"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endsection