@extends('layouts.app')

@section('title')
<title>Rediģēt eksāmenu</title>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize task count and answer counter
    let taskCount = {{ $exam->tasks->count() }}; 
    let newAnswerCounter = 0;

    $(document).on('change', 'input[type="radio"].form-check-input', function() {
        const taskId = $(this).closest('.card').data('task');
        toggleCorrectAnswer(this, taskId);// Call function to ensure only one correct answer is selected
    });

    function toggleCorrectAnswer(checkbox, taskId) {
        // Uncheck all radio buttons within the current task's answer section
        $(`#answers-${taskId}`).find('input[type="radio"]').each(function() {
            $(this).prop('checked', false); 
        });

        $(checkbox).prop('checked', true);
    }

    $(document).on('click', '.add_answer', function() {
        const taskId = $(this).data('task');
        const answersDiv = $(`#answers-${taskId}`);
        const newAnswer = `
            <div class="form-group ml-3" style="position: relative;" data-answer="${newAnswerCounter}">
                <label>Atbilde:</label>
                <input type="text" name="new_answers[${taskId}][${newAnswerCounter}][text]" class="form-control" placeholder="Jauna atbilde" required style="width: 70%; display: inline-block;">
                <div class="form-check">
                    <input type="radio" name="tasks[${taskId}][correct_answer]" value="${newAnswerCounter}" class="form-check-input">
                    <label class="form-check-label">Pareizā atbilde</label>
                </div>
                <span class="delete-answer" data-task="${taskId}" data-answer="${newAnswerCounter}" style="cursor:pointer; color:red; font-size: 20px; position: absolute; right: 5px; top: 25%;">&times;</span>
            </div>
        `;
        answersDiv.append(newAnswer);
        newAnswerCounter++;
    });

    $(document).on('click', '.delete_task', function() {
        const taskId = $(this).data('task');
        const taskElement = $(`div[data-task="${taskId}"]`);

        if (confirm('Vai tiešām vēlaties dzēst šo uzdevumu?')) {
            // Make an AJAX request to delete the task on the server
            $.ajax({
                url: '/admin/exam/delete-task/' + taskId,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "task_id": taskId
                },
                success: function(response) {
                    taskElement.remove();
                },
                error: function() {
                    alert('Radās kļūda, dzēšot uzdevumu.');
                }
            });
        }
    });

    $(document).on('click', '.delete-answer', function() {
        const taskId = $(this).data('task');
        const answerId = $(this).data('answer');
        const answerElement = $(`#answers-${taskId}`).find(`.form-group[data-answer="${answerId}"]`);

        if (confirm('Vai tiešām vēlaties dzēst šo atbildi?')) {
            if (!answerId) {
                answerElement.remove();
                return;
            }

            $.ajax({
                url: '/admin/exam/delete-answer/' + answerId, 
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "answer_id": answerId
                },
                success: function(response) {
                    answerElement.remove();
                },
                error: function() {
                    alert('Radās kļūda, dzēšot atbildi.');
                }
            });
        }
    });
});

</script>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Rediģēt eksāmenu</h1>

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
            <p class="form-control-plaintext"></p>{{ $exam->macibuPrieksmets->name }}</p>
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
                                <div class="form-group ml-3" style="position: relative;">
                                    <label>Atbilde:</label>
                                    <input type="text" name="answers[{{ $answer->id }}][text]" class="form-control" value="{{ old('answers.' . $answer->id . '.text', $answer->text) }}" required style="width: 70%; display: inline-block;">
                                    <div class="form-check">
                                    <input type="radio" name="tasks[{{ $task->id }}][correct_answer]" value="{{ $answer->id }}" class="form-check-input" {{ $answer->is_correct ? 'checked' : '' }}>
                                    <label class="form-check-label">Pareizā atbilde</label>
                                    </div>
                                    <span class="delete-answer" data-task="{{ $task->id }}" data-answer="{{ $answer->id }}" style="cursor:pointer; color:red; font-size: 20px; position: absolute; right: 5px; top: 25%;">&times;</span>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-secondary add_answer" data-task="{{ $task->id }}">Pievienot atbildi</button>
                        <button type="button" class="btn btn-danger delete_task" data-task="{{ $task->id }}">Dzēst uzdevumu</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Saglabāt Izmaiņas</button>
            <a href="{{ route('examList') }}" class="btn btn-secondary">Atcelt</a>
        </div>
    </form>
</div>
@endsection
