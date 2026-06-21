@extends('layouts.main')
@section('content')
<h1>{{ $article->content }}</h1>
<h1>{{ $article->creator_username }}</h1>
@endsection