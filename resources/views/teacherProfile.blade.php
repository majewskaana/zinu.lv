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

        <div class="mt-5">
    <h2>Atsauksmes</h2>

    @forelse ($teacher->feedbacks as $feedback)
        <div class="card mb-3">
            <div class="card-body">
                <p>{{ $feedback->text }}</p>                
                @if(Auth::check() && (Auth::id() === $feedback->lietotajs->id || Auth::user()->usertype === 'admin'))
                    <form action="{{ route('feedback.destroy', $feedback) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Vai tiešām vēlaties dzēst šo atsauksmi?')">
                            Dzēst
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>Šim pasniedzējam vēl nav atsauksmju.</p>
    @endforelse
</div>
@if(Auth::check())
    <div class="mt-4">
        <h3>Pievienot atsauksmi</h3>
        <form action="{{ route('feedback.store', $teacher) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="text" class="form-control" rows="3" placeholder="Ierakstiet savu atsauksmi..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Pievienot</button>
        </form>
    </div>
@endif

    </div>
</div>
@endsection
