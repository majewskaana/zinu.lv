@extends('layouts.app')

@section('title')
    <title>Privātskolotāja profils</title>
@endsection

@section('content')
<div class="container">
    <h1>{{ $teacher->name }} {{ $teacher->surname }}</h1>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Materiāla pasniegšanas stils:</strong> {{ $teacher->material_style }}</p>
            <p><strong>Apraksts:</strong> {{ $teacher->about_private_teacher }}</p>
            <strong>Kontaktinformācija:</strong>
            @if (Auth::check())
                <p> {{ $teacher->contact_info }}</p>
            @else
                <div class="alert alert-info">
                    Šī informācija ir pieejama tikai reģistrētiem lietotājiem.
                </div>
                <a href="{{ route('login', ['redirect_to' => route('teacher.profile', $teacher->id)]) }}" 
                class="btn btn-primary">Pierakstīties</a>
                <a href="{{ route('register', ['redirect_to' => route('teacher.profile', $teacher->id)]) }}"
                 class="btn btn-secondary">Reģistrēties</a>

            @endif
        </div>

        <div class="col-md-6">
            <p><strong>Pilsēta:</strong> {{ $teacher->city }}</p>
            @if($teacher->image_path)
                <img src="{{ $teacher->image_path }}" alt="Teacher Image" class="img-fluid" style="max-width: 100%; height: auto;">
            @endif
            <p><strong>Klase, kurai pasniegs:</strong> {{ $teacher->city }}</p>
            <p><strong>Līmenis:</strong> {{ $teacher->city }}</p>
        </div>
    </div>
</div>
@endsection
