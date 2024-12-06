@extends('layouts.app')

@section('title')
<title>Eksāmenu saraksts</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Eksāmenu saraksts</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('examCreation.create') }}" class="btn btn-primary mb-3">Pievienot jaunu eksāmenu</a>

    @if ($exams->isEmpty())
        <p class="text-muted">Eksāmeni nav pievienoti.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gads</th>
                    <th>Priekšmets</th>
                    <th>Līmenis</th>
                    <th>Darbības</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->gads }}</td>
                        <td>{{ $exam->macibuPrieksmets->name }}</td>
                        <td>{{ $exam->limenis }}</td>
                        <td>
                            @if (Auth::user()->usertype == 'admin')
                                <a href="{{ route('examDetails', $exam->id) }}" class="btn btn-info btn-sm">Skatīt</a>
                                <a href="{{ route('examEdit.edit', $exam->id) }}" class="btn btn-warning btn-sm">Rediģēt</a>
                                <form action="{{ route('examEdit.destroy', $exam->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Vai tiešām vēlaties dzēst šo eksāmenu?')">Dzēst</button>
                                </form>
                            @else
                                <span>{{ $exam->gads }} - {{ $exam->subject->name }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
