@extends('layouts.app')

@section('title')
<title>Rediģēt Eksāmenu un Uzdevumus</title>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let taskCount = {{ $exam->tasks->count() }}; 
        let newAnswerCounter = 0;

        $(document).on('click', '.add_answer', function() {
            const taskId = $(this).data('task');
            const answersDiv = $(`#answers-${taskId}`);
            const newAnswer = `
                <div class="form-group ml-3">
                    <label>Atbilde:</label>
                    <input type="text" name="new_answers[${taskId}][${newAnswerCounter}][text]" class="form-control" placeholder="Jauna atbilde" required>
                    <div class="form-check">
                        <input type="checkbox" name="new_answers[${taskId}][${newAnswerCounter}][is_correct]" class="form-check-input">
                        <label class="form-check-label">Pareizā atbilde</label>
                    </div>
                </div>
            `;
            answersDiv.append(newAnswer);
            newAnswerCounter++;
        });

        $('#add_task').click(function() {
            const newTask = `
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Jauns Uzdevums</h5>
                        <div class="form-group">
                            <label>Uzdevuma teksts:</label>
                            <input type="text" name="new_tasks[${taskCount}][text]" class="form-control" placeholder="Jauns uzdevums" required>
                        </div>
                        <h6>Atbildes:</h6>
                        <div id="answers-new-${taskCount}">
                            <div class="form-group ml-3">
                                <label>Atbilde:</label>
                                <input type="text" name="new_tasks[${taskCount}][answers][0][text]" class="form-control" placeholder="Jauna atbilde" required>
                                <div class="form-check">
                                    <input type="checkbox" name="new_tasks[${taskCount}][answers][0][is_correct]" class="form-check-input">
                                    <label class="form-check-label">Pareizā atbilde</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary add_answer" data-task="new-${taskCount}">Pievienot atbildi</button>
                    </div>
                </div>
            `;
            $('#tasks-container').append(newTask);
            taskCount++;
        });
    });
</script>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Rediģēt Eksāmenu un Uzdevumus</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('examEdit.update', $exam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="gads">Gads:</label>
            <input type="text" name="gads" id="gads" class="form-control" value="{{ old('gads', $exam->gads) }}" required>
        </div>

        <div class="form-group">
            <label for="limenis">Līmenis:</label>
            <input type="text" name="limenis" id="limenis" class="form-control" value="{{ old('limenis', $exam->limenis) }}" required>
        </div>

        <div class="form-group">
            <label for="macibu_prieksmets_id">Priekšmets:</label>
            <select name="macibu_prieksmets_id" id="macibu_prieksmets_id" class="form-control" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $exam->macibu_prieksmets_id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr>

        <h2>Uzdevumi</h2>
        <div id="tasks-container">
            @foreach ($exam->tasks as $index => $task)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Uzdevums {{ $index + 1 }}</h5>
                        <div class="form-group">
                            <label>Uzdevuma teksts:</label>
                            <input type="text" name="tasks[{{ $task->id }}][text]" class="form-control" value="{{ old('tasks.' . $task->id . '.text', $task->text) }}" required>
                        </div>

                        <h6>Atbildes:</h6>
                        <div id="answers-{{ $task->id }}">
                            @foreach ($task->answers as $answer)
                                <div class="form-group ml-3">
                                    <label>Atbilde:</label>
                                    <input type="text" name="answers[{{ $answer->id }}][text]" class="form-control" value="{{ old('answers.' . $answer->id . '.text', $answer->text) }}" required>
                                    <div class="form-check">
                                        <input type="checkbox" name="answers[{{ $answer->id }}][is_correct]" class="form-check-input" {{ $answer->is_correct ? 'checked' : '' }}>
                                        <label class="form-check-label">Pareizā atbilde</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary add_answer" data-task="{{ $task->id }}">Pievienot atbildi</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary mb-3" id="add_task">Pievienot uzdevumu</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Saglabāt Izmaiņas</button>
            <a href="{{ route('examList') }}" class="btn btn-secondary">Atcelt</a>
        </div>
    </form>
</div>
@endsection
