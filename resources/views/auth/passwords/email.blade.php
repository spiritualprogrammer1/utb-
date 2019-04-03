@extends('layouts.app')

@section('content')
    <section class="m-b-lg">
        <header class="wrapper text-center">
            <strong>Réinitialiser le mot de passe</strong>
        </header>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
        <div class="list-group">
            <div class="list-group-item {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" placeholder="Adresse e-mail" name="email" class="form-control no-border" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Envoyer un lien de réinitialisation</button>
        </form>
        <div class="text-center m-t m-b"><a href="{{route('login') }}"><small>Se connecter</small></a></div>
    </section>
@endsection
