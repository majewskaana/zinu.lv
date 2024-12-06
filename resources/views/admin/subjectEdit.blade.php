@extends('layouts.app')
@section('title')
<title>Rediģēt mācību priekšmetu</title>
@endsection

@section('script')
<script>
    function addTheme() {
        const container = document.getElementById('themes-container');
        const themeGroup = document.createElement('div');
        themeGroup.className = 'mb-3 theme-group';

        themeGroup.innerHTML = `
            <label for="theme_name[]" class="form-label">Tēma</label>
            <input type="text" name="theme_name[]" class="form-control" required>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-theme" onclick="removeTheme(this)">Noņemt</button>
        `;

        container.appendChild(themeGroup);
    }

    function removeTheme(button) {
        button.parentElement.remove();
    }
</script>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Rediģēt mācību priekšmetu</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('subjectEdit.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="subject_name" class="form-label">Mācību priekšmeta nosaukums</label>
            <input type="text" name="subject_name" id="subject_name" class="form-control" value="{{ $subject->name }}" required>
            @error('subject_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subject_form" class="form-label">Klase</label>
            <input type="text" name="subject_form" id="subject_form" class="form-control" value="{{ $subject->form }}" required>
            @error('subject_form')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <h2>Rediģēt tēmas</h2>
        <div id="themes-container">
            @foreach ($subject->themes as $theme)
                <div class="mb-3 theme-group">
                    <label for="theme_name[]" class="form-label">Tēma</label>
                    <input type="text" name="theme_name[]" class="form-control" value="{{ $theme->text }}" required>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-theme" onclick="removeTheme(this)">Noņemt</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary mb-3" onclick="addTheme()">Pievienot vēl vienu tēmu</button>

        <button type="submit" class="btn btn-primary">Atjaunināt</button>
    </form>
</div>
@endsection
