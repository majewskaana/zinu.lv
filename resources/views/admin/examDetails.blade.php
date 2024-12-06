@extends('layouts.app')

@section('title')
<title>Eksāmena detaļas</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Eksāmena detaļas: {{ $exam->macibuPrieksmets->name }}</h1> 
    <p><strong>Gads:</strong> {{ $exam->gads }}</p>
    <p><strong>Līmenis:</strong> {{ $exam->limenis }}</p>
    
    <h2>Uzdevumi</h2>
    @if ($exam->uzdevums->isEmpty())
        <p>Nav pievienoti uzdevumi.</p>
    @else
        <ul>
            @foreach ($exam->uzdevums as $task)
                <li>
                    {{ $task->text }}
                    <ul>
                        @foreach ($task->answers as $answer)
                            <li>{{ $answer->text }} @if ($answer->is_correct) <strong>(Pareizā)</strong> @endif</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('examList') }}" class="btn btn-secondary">Atpakaļ</a>
</div>
@endsection
