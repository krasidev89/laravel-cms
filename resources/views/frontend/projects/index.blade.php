@extends('layouts.frontend')

@section('title', __('Projects'))

@section('content')
@if ($projects->isEmpty())
<div class="alert alert-secondary text-center text-danger shadow-sm p-4" role="alert">
    {{ __('No Projects Uploaded') }}
</div>
@else
<div class="row column-count mb-n3 mb-sm-n4">
    @foreach ($projects as $project)
    <div class="col-12">
        <div class="card flex-row flex-wrap shadow-sm mb-3 mb-sm-4">
            @if ($project->imagePathWithTimestamp)
            <a href="{{ route('frontend.projects.show', ['project' => $project->slug]) }}" target="_blank" class="card-link">
                <img src="{{ asset($project->imagePathWithTimestamp) }}" class="card-img-top border-bottom" />
            </a>
            @endif

            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('frontend.projects.show', ['project' => $project->slug]) }}" target="_blank" class="card-link">{{ $project->name }}</a>
                </h5>
                <div class="card-text">{!! $project->short_description !!}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
    $('.column-count').columnCount({
        lg: 3,
        md: 2
    });
</script>
@endsection
