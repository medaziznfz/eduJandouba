@extends('layouts.app')

@section('content')
    <h2 class="text-success">Bienvenue {{ auth()->user()->prenom }} !</h2>
    <p class="lead">Vous êtes connecté en tant que <strong>{{ auth()->user()->role }}</strong>.</p>
@endsection
