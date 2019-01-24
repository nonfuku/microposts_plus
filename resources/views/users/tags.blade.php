@extends('layouts.app')

@section('content')
    @include('users.navtabs', ['user' => $user])

    <div class="row">
        {!! Form::open(['route' => 'signup.post']) !!}
            <div class="form-group">
                {!! Form::label('keywords', 'Keywords') !!}
                {!! Form::text('searchKey', 'input #tagsName', ['class' => 'form-control']) !!}
            </div>

            {!! Form::submit('Search', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
    </div>