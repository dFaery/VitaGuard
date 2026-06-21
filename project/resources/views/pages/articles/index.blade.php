@extends('layouts.navbar.main')
@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <h4>Artikel Kesehatan Untuk Anda</h4>
        <!-- <button type="button" class="btn btn-outline-primary mr-2">Primary</button>
        <button type="button" class="btn btn-outline-secondary mr-2">Secondary</button> -->        
    </div>
    <div class="container">
        @foreach($articles as $article)
        <div class="card mb-3 border-0">
            <div class="row g-0 align-items-center">
                <div class="col-md-2">
                    <img src="{{ asset('assets/images/doctor.webp') }}" class="img rounded-start w-100" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <a href="{{ route('read-articles', $article->id) }}" class="text-decoration-none text-dark border-0">{{ $article->content}}</a>
                        <div class="d-flex">
                            <span class="badge badge-primary mr-2 align-items-center">{{ $article->topic->name}}</span>
                            <p class="card-text"><small class="text-body-secondary">Created at {{ $article->created_at }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endsection