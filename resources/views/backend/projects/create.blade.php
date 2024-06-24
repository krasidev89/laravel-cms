@extends('layouts.backend')

@section('title', __('Projects') . ' - ' . __('Create Project'))

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-transparent">{{ __('Create Project') }}</div>

    <div class="card-body">
        <form action="{{ route('backend.projects.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="slug" value="{{ old('slug') }}" id="slug" class="form-control @error('slug') is-invalid @enderror">

                        @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="url">{{ __('URL') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="url" value="{{ old('url') }}" id="url" class="form-control @error('url') is-invalid @enderror">

                        @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="image">{{ __('Image') }}:</label>

                        <label class="form-control h-auto text-center p-4 form-control @error('image') is-invalid @enderror">
                            <input type="file" name="image" id="image" class="d-none">

                            <img class="mw-100" alt="{{ __('Choose file') }}">
                        </label>

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="short_description">{{ __('Short Description') }}: <span class="text-danger">*</span></label>

                        <textarea name="short_description" id="short_description" class="tinymce form-control @error('short_description') is-invalid @enderror">{{ old('short_description') }}</textarea>

                        @error('short_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}: <span class="text-danger">*</span></label>

                        <textarea name="description" id="description" class="tinymce form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-bottom mb-3"></div>

            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@include('scripts.tinymce')
@endsection
