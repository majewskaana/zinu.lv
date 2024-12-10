@extends('layouts.app')
@section('title')
    <title>Pievienot eksāmenu</title>
@endsection('title')

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    function updateThemes(selectSubject, targetThemeSelect) {
        var subjectId = selectSubject.val();
        if (subjectId) {
            $.ajax({
                url: '/get-themes',
                type: 'GET',
                data: { subject_id: subjectId },
                success: function(response) {
                    targetThemeSelect.empty();
                    targetThemeSelect.append('<option value="">Izvēlēties...</option>');
                    $.each(response.themes, function(index, theme) {
                        targetThemeSelect.append('<option value="' + theme.id + '">' + theme.text + '</option>');
                    });
                },
                error: function() {
                    alert('Kļūda: neizdevās ielādēt tēmas.');
                }
            });
        } else {
            targetThemeSelect.empty().append('<option value="">Izvēlēties...</option>');
        }
    }

    $('#add_task').on('click', function() {
        var taskIndex = $('.task-block').length;
        var newTask = `
            <div class="task-block mb-4 border p-3">
                <h4>Uzdevums ${taskIndex + 1}</h4>
                <div class="form-group">
                    <label for="subject_id_${taskIndex}">Mācību priekšmets</label>
                    <select class="form-control subject-select" id="subject_id_${taskIndex}" name="tasks[${taskIndex}][subject_id]" required>
                        <option value="">Izvēlēties...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tema_id_${taskIndex}">Uzdevuma tēma</label>
                    <select class="form-control theme-select" id="tema_id_${taskIndex}" name="tasks[${taskIndex}][tema_id]" required>
                        <option value="">Izvēlēties...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="uzdevums_${taskIndex}">Uzdevums</label>
                    <textarea class="form-control" id="uzdevums_${taskIndex}" name="tasks[${taskIndex}][text]" rows="2" required></textarea>
                </div>
                <label>Atbildes:</label>
                <div id="variants_${taskIndex}" class="variants">
                    <div class="variant-group mb-2">
                        <input type="text" class="form-control mb-1" name="tasks[${taskIndex}][variants][]" placeholder="Atbilde">
                        <input type="radio" name="tasks[${taskIndex}][correct_variant]" value="0"> Pareizā
                    </div>
                </div>
                <button type="button" class="btn btn-secondary add-variant" data-task-index="${taskIndex}">Pievienot variantu</button>
            </div>
        `;
        $('#tasks_container').append(newTask);
    });

    $(document).on('change', '.subject-select', function() {
        var subjectSelect = $(this);
        var themeSelect = subjectSelect.closest('.task-block').find('.theme-select');
        updateThemes(subjectSelect, themeSelect);
    });

    $(document).on('click', '.add-variant', function() {
        var taskIndex = $(this).data('task-index');
        var variantsDiv = $(`#variants_${taskIndex}`);
        var variantIndex = variantsDiv.children().length;
        var newVariant = `
            <div class="variant-group mb-2">
                <input type="text" class="form-control mb-1" name="tasks[${taskIndex}][variants][]" placeholder="Atbilde">
                <input type="radio" name="tasks[${taskIndex}][correct_variant]" value="${variantIndex}"> Pareizā
            </div>
        `;
        variantsDiv.append(newVariant);
    });
});



    
</script>

@endsection('script')



@section('content')
<div class="container">
    <h1>Pievienot jaunu eksāmenu</h1>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        
    <form action="{{ route('examCreation.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="gads">Gads</label>
            <input type="number" class="form-control @error('gads') is-invalid @enderror" id="gads" name="gads" value="{{ old('gads') }}" required>
            @error('gads')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="limenis">Līmenis</label>
            <input type="text" class="form-control @error('limenis') is-invalid @enderror" id="limenis" name="limenis" value="{{ old('limenis') }}" required>
            @error('limenis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gads">Mācību priekšmets</label>
            <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                <option value="">Izvēlēties...</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>@error('subject_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="tasks_container">
            
        </div>
        <button type="button" class="btn btn-primary mb-3" id="add_task">Pievienot jaunu uzdevumu</button>
        <button type="submit" class="btn btn-primary">Pievienot</button>
    </form>
</div>


@endsection
