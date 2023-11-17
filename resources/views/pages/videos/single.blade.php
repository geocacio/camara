@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Posts</span>
    </li>
</ul>

<h3 class="title-sub-page main">Videos</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="container">
    <div class="row">
        <div class="col-md-8">
            {{-- {{ dd($video) }} --}}
            <div class="card">
                <div class="card-body content-video-box">
                    <h3 class="title">{{ $video->title }}</h3>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <span class="time-post-video"><i class="fa-solid fa-calendar fa-fw"></i> Segunda, 17 de Nov de 2023</span>
                    <div class="text-box">
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-list-sidebar">
                <div class="card-body">
                    <ul class="list-post list-video">
                        <h3>Videos mais vistos</h3>
                        <li>
                            <a href="#">
                                <iframe src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <iframe src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="list-post list-video">
                        <h3>Videos mais recentes</h3>
                        <li>
                            <a href="#">
                                <iframe src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <iframe src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <iframe src="https://www.youtube.com/embed/DAPZkDFY_B4?si=hHbb1CyB2MtgnjBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')

@endsection