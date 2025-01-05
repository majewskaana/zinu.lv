@extends('layouts.app')
@section('title')
    <title>Pievienot eksāmenu</title>
@endsection('title')

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Function to update themes based on selected subject
function updateThemes(selectSubject, targetThemeSelect) {
    var subjectId = selectSubject.val(); // Get the selected subject ID
    if (subjectId) {
        $.ajax({
            url: '/get-themes', // URL to fetch themes based on the selected subject
            type: 'GET',
            data: { subject_id: subjectId }, // Send the selected subject ID to the server
            success: function(response) {
                targetThemeSelect.empty(); // Clear the current themes in the select box
                targetThemeSelect.append('<option value="">Izvēlēties...</option>');
                // Loop through the returned themes and populate the theme select dropdown
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
    var taskIndex = $('.task-block').length;  // Get the current number of tasks (used for unique task IDs)
    var selectedSubjectId = $('#main_subject_id').val();  // Get the currently selected subject ID
    var subjectOptions = $('#main_subject_id').html();  // Get the options of subjects in the dropdown

    var newTask = `
        <div class="task-block mb-4 border p-3" id="task_block_${taskIndex}">
            <h4>Uzdevums ${taskIndex + 1}</h4><button type="button" class="btn btn-danger btn-sm float-right delete-task" data-task-index="${taskIndex}">Dzēst uzdevumu</button>
            <div class="form-group">
                <label for="subject_id_${taskIndex}">Mācību priekšmets</label>
                <select class="form-control subject-select" id="subject_id_${taskIndex}" name="tasks[${taskIndex}][subject_id]" required>
                    ${subjectOptions}
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
                    <button type="button" class="btn btn-danger btn-sm delete-variant">Dzēst</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary add-variant" data-task-index="${taskIndex}">Pievienot variantu</button>
        </div>
    `;
    $('#tasks_container').append(newTask);
    $(`#subject_id_${taskIndex}`).val(selectedSubjectId).trigger('change');
});

$(document).on('click', '.delete-task', function() {
    var taskIndex = $(this).data('task-index');
    $(`#task_block_${taskIndex}`).remove();
});

$(document).on('click', '.delete-variant', function() {
    $(this).closest('.variant-group').remove();
});

// When the subject is changed, update the themes for that task
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
            <button type="button" class="btn btn-danger btn-sm delete-variant">Dzēst</button>
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
            <label for="main_subject_id">Mācību priekšmets</label>
            <select class="form-control @error('main_subject_id') is-invalid @enderror" id="main_subject_id" name="main_subject_id" required>
                <option value="">Izvēlēties...</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('main_subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>@error('main_subject_id')
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
