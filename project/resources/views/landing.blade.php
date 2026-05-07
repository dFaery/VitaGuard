@extends('layouts.main')
@section('content')
<div id="carouselExampleIndicators" class="carousel slide carousel-custom" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <picture>
                <source srcset="/assets/images/hero-bg.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">
                <h5>Template Nav admin bisa diakses dengan login</h5>
                <p>username: reza_h | password: RezaPwd99!</p>
            </div>
        </div>

        <div class="carousel-item">
            <picture>
                <source srcset="/assets/images/hero-bg.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">
                <h5>Template Nav admin bisa diakses dengan login</h5>
                <p>username: reza_h | password: RezaPwd99!</p>
            </div>
        </div>

        <div class="carousel-item">
            <picture>
                <source srcset="/assets/images/doctor.webp" type="image/webp">
                <img class="d-block w-100" src="/assets/images/hero-bg.jpg">
            </picture>

            <div class="carousel-caption d-none d-md-block">                
                <h5>Template Nav admin bisa diakses dengan login</h5>
                <p>username: reza_h | password: RezaPwd99!</p>                
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <h4>Artikel Kesehatan Untuk Anda</h4>
        <!-- <button type="button" class="btn btn-outline-primary mr-2">Primary</button>
        <button type="button" class="btn btn-outline-secondary mr-2">Secondary</button> -->
        <a href="{{ route('articles') }}" class="text-primary">
            Lihat semua artikel &raquo;
        </a>
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