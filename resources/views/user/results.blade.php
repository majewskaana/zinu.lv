@extends('layouts.app')

@section('title')
<title>Rezultāti</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Eksāmena rezultāti: {{ $exam->gads }} - {{ $exam->macibuPrieksmets->name }}</h1>
    <p>Jūsu rezultāts: {{ $score }} no {{ count($results) }}</p>

    <h3>Atbildes:</h3>
    <ul>
        @foreach ($results as $result)
            <li>
                <strong>Jautājums:</strong> {{ $result['task'] }}<br>
                <strong>Jūsu atbilde:</strong> {{ $result['yourAnswer']}}<br>
                <strong>Pareizs:</strong> {{ $result['correctAnswer'] }}<br>
                <strong>Jautājuma tēma:</strong> {{ $result['theme'] }}<br>
                @if (!$result['isCorrect'])
                    <span class="text-danger">Kļūda</span>
                @else
                    <span class="text-success">Pareizi</span>
                @endif
            </li>
        @endforeach
    </ul>

    @if ($topicsToReview->isNotEmpty())
        <h3>Tēmas atkārtošanai:</h3>
        <ul>
            @foreach ($topicsToReview as $topic)
                <li>{{ $topic }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('examList') }}" class="btn btn-primary">Atgriezties</a>
</div>
@endsection
