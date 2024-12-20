@extends('layouts.app')

@section('title')
    <title>Privātskolotāji</title>
@endsection

@section('content')
<div class="container">
    <h1>Privātskolotāju saraksts</h1>

    <div class="mb-3">
        <a href="{{ route('teacherCreation.create') }}" class="btn btn-primary">Pievienot jaunu skolotāju</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if ($teachers->isEmpty())
        <p>Nav atrasti privātskolotāji.</p>
    @else
        <ul class="list-group">
            @foreach ($teachers as $teacher)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('teacher.profile', $teacher->id) }}" class="text-decoration-none">
                        <strong>{{ $teacher->name }} {{ $teacher->surname }}</strong>
                    </a>
                    <div class="btn-group" role="group">
                        <a href="{{ route('teacherEdit.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Rediģēt</a>

                        <form action="{{ route('teacherEdit.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties dzēst šo skolotāju?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Dzēst</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
