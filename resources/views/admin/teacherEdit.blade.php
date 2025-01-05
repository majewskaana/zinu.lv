@extends('layouts.app')

@section('title')
    <title>Rediģēt Skolotāju</title>
@endsection

@section('script')
<script>
window.onload = function () {
    // Fetch the list of selected subject IDs from the backend and store them as an array
    let selectedSubjects = @json($teacher->macibuPrieksmeti->pluck('id')->toArray());
    const selectedSubjectsContainer = document.getElementById('selected-subjects');
    const subjectList = document.getElementById('subject-list');
    const addSubjectButton = document.getElementById('add-subject-btn');
    const form = document.getElementById('teacher-form');

    function addSubjectToContainer(subjectId, subjectName) {
        // Check if the subject is already added
        if (document.querySelector(`.selected-subject[data-id='${subjectId}']`)) return;

        const selectedSubjectDiv = document.createElement('div');
        selectedSubjectDiv.classList.add('selected-subject', 'd-flex', 'justify-content-between', 'align-items-center');
        selectedSubjectDiv.setAttribute('data-id', subjectId);

        selectedSubjectDiv.innerHTML = `
            <span>${subjectName}</span>
            <button type="button" class="remove-subject-btn btn btn-danger btn-sm">X</button>
        `;
        selectedSubjectsContainer.appendChild(selectedSubjectDiv);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'subjects[]';
        hiddenInput.value = subjectId;
        form.appendChild(hiddenInput);
    }

    function initializeSubjects() {
        selectedSubjects.forEach(subjectId => {
            // Find the corresponding subject option by its ID
            const subjectOption = document.querySelector(`.subject-option[data-id='${subjectId}']`);
            if (subjectOption) {
                const subjectName = subjectOption.getAttribute('data-name');
                addSubjectToContainer(subjectId, subjectName);
            }
        });
    }

    addSubjectButton.addEventListener('click', function () {
        subjectList.style.display = 'block';  
    });

    // Event listener to add a subject when a subject option is clicked from the list
    subjectList.addEventListener('click', function (e) {
        if (e.target.classList.contains('subject-option')) {
            const subjectId = e.target.getAttribute('data-id');
            const subjectName = e.target.getAttribute('data-name');
            addSubjectToContainer(subjectId, subjectName);
            subjectList.style.display = 'none';
        }
    });

    selectedSubjectsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-subject-btn')) {
            const subjectDiv = e.target.closest('.selected-subject');
            const subjectId = parseInt(subjectDiv.getAttribute('data-id'));
            subjectDiv.remove();

            const hiddenInput = form.querySelector(`input[name="subjects[]"][value="${subjectId}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }
        }
    });
    initializeSubjects();
};
</script>
@endsection


@section('content')
<div class="container">
    <h1>Rediģēt Skolotāju</h1>

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

    <form id="teacher-form" action="{{ route('teacherEdit.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Vārds</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $teacher->name) }}" required>
        </div>

        <div class="form-group">
            <label for="surname">Uzvārds</label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', $teacher->surname) }}" required>
        </div>

        <div class="form-group">
            <label for="subjects">Izvēlēties priekšmetus</label>
            <div id="selected-subjects"></div>
            <button type="button" id="add-subject-btn" class="btn btn-secondary mt-2">Pievienot priekšmetu</button>

            <div id="subject-list" style="display:none; margin-top: 10px;">
                @foreach ($subjects as $subject)
                    <div class="subject-option" 
                         data-id="{{ $subject->id }}" 
                         data-name="{{ $subject->name }}" 
                         style="cursor: pointer; padding: 10px; border: 1px solid #ddd; margin-bottom: 5px; border-radius: 4px;">
                        {{ $subject->name }}
                    </div>
                @endforeach
            </div>

        <div class="form-group">
            <label for="contact_info">Kontaktinformācija</label>
            <textarea class="form-control" id="contact_info" name="contact_info" rows="3" required>{{ old('contact_info', $teacher->contact_info) }}</textarea>
        </div>

        <div class="form-group">
            <label for="city">Pilsēta</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $teacher->city) }}" required>
        </div>

        <div class="form-group">
            <label for="material_style">Materiāla pasniegšanas stils</label>
            <input type="text" class="form-control" id="material_style" name="material_style" value="{{ old('material_style', $teacher->material_style) }}" required>
        </div>

        <div class="form-group">
            <label for="about_private_teacher">Par skolotāju</label>
            <textarea class="form-control" id="about_private_teacher" name="about_private_teacher" rows="4" required>{{ old('about_private_teacher', $teacher->about_private_teacher) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Augšupielādēt jaunu attēlu</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            @if ($teacher->image_path)
                <div class="mt-2">
                    <p>Esošais attēls:</p>
                    <img src="{{ asset('storage/' .$teacher->image_path) }}" alt="Teacher Image" class="img-fluid" style="max-width: 200px; border: 1px solid #ddd;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Saglabāt izmaiņas</button>
    </form>
</div>
@endsection
