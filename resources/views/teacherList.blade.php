@extends('layouts.app')

@section('title')
    <title>Privātskolotāji</title>
@endsection

@section('content')
<div class="container">
    <h1>Privātskolotāju saraksts</h1>

    <form action="{{ route('teacherList') }}" method="GET">
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="city">Pilsēta</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ request('city') }}">
        </div>

        <div class="col-md-4">
            <label for="subject">Priekšmets</label>
            <select class="form-control" id="subject" name="subject">
                <option value="">Izvēlieties priekšmetu</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="form">Klasē</label>
            <select class="form-control" id="form" name="form">
                <option value="">Izvēlieties klasi</option>
                @foreach ($subjects->pluck('form')->unique() as $form)
                    <option value="{{ $form }}" {{ request('form') == $form ? 'selected' : '' }}>
                        {{ $form }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Filtrēt</button>
</form>

    <hr>

    @if ($teachers->isEmpty())
        <p>Nav atrasti privātskolotāji, kas atbilst jūsu kritērijiem.</p>
    @else
        <ul class="list-group">
            @foreach ($teachers as $teacher)
                <li class="list-group-item">
                    <a href="{{ route('teacher.profile', $teacher->id) }}" class="text-decoration-none">
                        <strong>{{ $teacher->name }} {{ $teacher->surname }}</strong>
                    </a>
                    <p><strong>Par skolotāju:</strong> {{ Str::limit($teacher->about_private_teacher, 100) }}</p>
                    <p><strong>Pilsēta:</strong> {{ $teacher->city }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
