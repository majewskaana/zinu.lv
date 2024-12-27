@extends('layouts.app')

@section('title')
<title>Eksāmenu saraksts</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Eksāmenu saraksts</h1>

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
                        <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">Nokārtot eksāmenu</a>
                        </td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
