@extends('layouts.frontend')

@section('url', $project->url)

@section('title', $project->name)

@if ($project->imagePathWithTimestamp)
@section('image', asset($project->imagePathWithTimestamp))
@endif

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            @if ($project->imagePathWithTimestamp)
            <div class="col">
                <a href="{{ $project->url }}" class="card-link">
                    <img src="{{ asset($project->imagePathWithTimestamp) }}" class="img-thumbnail" />
                </a>
            </div>
            @endif

            <div class="col-12 col-md-8 col-xl-9 pt-3 pt-md-0">
                <h5 class="card-title">
                    <a href="{{ $project->url }}" class="card-link">{{ $project->name }}</a>
                </h5>
                <div class="card-text">{!! $project->description !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
