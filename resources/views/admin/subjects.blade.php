@extends('layouts.app')

@section('title')
<title>Visi mācību priekšmeti</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Visi mācību priekšmeti</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="m-0">Zemāk atrodami visi pievienotie mācību priekšmeti:</p>
    </div>
    @if ($subjects->isEmpty())
        <p class="text-muted">Pašlaik nav pievienoti mācību priekšmeti.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nosaukums</th>
                    <th>Klase</th>
                    <th>Tēmas</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $index => $subject)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->form }}</td>
                        <td>
                            @if ($subject->themes->isEmpty())
                                <span class="text-muted">Nav tēmu</span>
                            @else
                                <ul>
                                    @foreach ($subject->themes as $theme)
                                        <li>{{ $theme->text }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('subjectEdit.edit', $subject->id) }}" class="btn btn-warning btn-sm">Rediģēt</a>
                            <form action="{{ route('subjectEdit.destroy', $subject->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Vai tiešām vēlaties dzēst šo priekšmetu?')">Dzēst</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('subjectCreation.create') }}" class="btn btn-primary">Pievienot jaunu priekšmetu</a>
</div>
@endsection
