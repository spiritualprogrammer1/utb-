@extends('layouts.app')

@section('content')
    <section class="m-b-lg">
        <header class="wrapper text-center" style="margin-top: 40px">
            <strong class="text-info" style="color:#095696" size="70%" >Connectez-vous a votre compte</strong>
        </header>
        <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
            {{ csrf_field() }}
            <div class="list-group">
                <div class="list-group-item {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" placeholder="Adresse e-mail" name="email" class="form-control no-border">
                    @if ($errors->has('email'))
                        <span class="help-block">
                           <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="list-group-item {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" placeholder="Mot de passe" name="password" class="form-control no-border">
                    @if ($errors->has('password'))
                        <span class="help-block">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="checkbox i-checks">
                    <label>
                        <input type="checkbox" {{ old('remember') ? 'checked' : '' }}><i></i>&nbsp;Rester connecter
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Se connecter</button>
        </form>
        <div class="text-center m-t m-b"><a href="{{route('password.request') }}" style="color: black"><small>Mot de passe oublié?</small></a></div>
        <div class="line line-dashed"></div>
        {{--@if(App\User::count() == 0)--}}
            {{--<p class="text-muted text-center"><small>Aucun compte trouvvé!</small></p>--}}
            {{--<a href="{{route('register') }}" class="btn btn-lg btn-default btn-block">Créer un compte</a>--}}
        {{--@endif--}}
    </section>
@endsection
