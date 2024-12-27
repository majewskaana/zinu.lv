@extends('layouts.app')

@section('title')
<title>Nokārtot eksāmens</title>
@endsection

@section('content')
<div class="container mt-5">
    <h1>{{ $exam->gads }} - {{ $exam->macibuPrieksmets->name }}</h1>
    <form action="{{ route('exams.submit', $exam->id) }}" method="POST">
        @csrf
        @foreach ($exam->tasks as $task)
            <div class="mb-4">
                <h5>{{ $loop->iteration }}. {{ $task->text }}</h5>
                <input type="hidden" name="tasks[{{ $task->id }}][id]" value="{{ $task->id }}">
                @foreach ($task->answers as $answer)
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="tasks[{{ $task->id }}][answer]" 
                            value="{{ $answer->id }}" 
                            id="answer-{{ $answer->id }}">
                        <label class="form-check-label" for="answer-{{ $answer->id }}">
                            {{ $answer->text }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="btn btn-success">Atbildēt</button>
    </form>
</div>
@endsection
