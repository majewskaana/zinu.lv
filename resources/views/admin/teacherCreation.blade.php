@extends('layouts.app')
@section('title')
    <title>Pievienot privātskolotāju</title>
@endsection('title')

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let selectedSubjects = [];
    const selectedSubjectsContainer = document.getElementById('selected-subjects');
    const subjectList = document.getElementById('subject-list');
    const addSubjectButton = document.getElementById('add-subject-btn');
    const form = document.querySelector('form');  

    addSubjectButton.addEventListener('click', function () {
        showSubjectList();
    });

function updateSubjectIds() {
    const existingInputs = document.querySelectorAll('.subject-id-input');
    existingInputs.forEach(input => input.remove());

    selectedSubjects.forEach(subjectId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'subject_id[]';  
        input.value = subjectId;      
        input.classList.add('subject-id-input');
        form.appendChild(input); 
    });

}

    function showSubjectList() {
        subjectList.style.display = 'block';
    }

    subjectList.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('subject-option')) {
            const subjectId = e.target.getAttribute('data-id');
            const subjectName = e.target.getAttribute('data-name');

            if (!selectedSubjects.includes(subjectId)) {
                selectedSubjects.push(subjectId);
                const selectedSubjectDiv = document.createElement('div');
                selectedSubjectDiv.classList.add('selected-subject');
                selectedSubjectDiv.setAttribute('data-id', subjectId);
                selectedSubjectDiv.innerHTML = `${subjectName} <button class="remove-subject-btn">X</button>`;
                selectedSubjectsContainer.appendChild(selectedSubjectDiv);

                updateSubjectIds(); 
                subjectList.style.display = 'none';  
            }
        }
    });

    selectedSubjectsContainer.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-subject-btn')) {
            const selectedSubjectDiv = e.target.closest('.selected-subject');
            const subjectId = selectedSubjectDiv.getAttribute('data-id');
            selectedSubjects = selectedSubjects.filter(id => id !== subjectId);
            selectedSubjectsContainer.removeChild(selectedSubjectDiv);
            updateSubjectIds(); 
        }
    });

    form.addEventListener('submit', function (event) {
        updateSubjectIds(); 

        if (selectedSubjects.length === 0) {
            alert("Lūdzu izvēlieties vismaz vienu mācību priekšmetu.");
            event.preventDefault();  
        }
    });
});

</script>
@endsection('script')






@section('content')
<div class="container">
    <h1>Pievienot jaunu privātskolotāju</h1>
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


<form action="{{ route('teacherCreation.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Vārds</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="surname">Uzvārds</label>
        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}" required>
        @error('surname')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="subject_id">Mācību priekšmeti</label>
        <div id="selected-subjects"></div>
        <button type="button" id="add-subject-btn" class="btn btn-secondary mt-2">Pievienot priekšmetu</button>

        <div id="subject-list" style="display:none;">
            @foreach($subjects as $subject)
                <div class="subject-option" 
                     data-id="{{ $subject->id }}" 
                     data-name="{{ $subject->name }}" 
                     style="cursor: pointer; padding: 10px; border: 1px solid #ddd; margin-bottom: 5px; border-radius: 4px; transition: background-color 0.3s;">
                    {{ $subject->name }}
                </div>
            @endforeach
        </div>
    </div>

        <div class="form-group">
        <label for="contact_info">Kontaktinformācija</label>
            <textarea class="form-control @error('uzdevums') is-invalid @enderror" id="contact_info" name="contact_info" rows="4" required>{{ old('contact_info') }}</textarea>
            @error('contact_info')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="city">Pilsēta</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="material_style">Materiāla pasniegšanas stils</label>
            <input type="text" class="form-control @error('material_style') is-invalid @enderror" id="material_style" name="material_style" value="{{ old('material_style') }}" required>
            @error('material_style')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
        <label for="about_private_teacher">Apraksts</label>
            <textarea class="form-control @error('uzdevums') is-invalid @enderror" id="about_private_teacher" name="about_private_teacher" rows="4" required>{{ old('about_private_teacher') }}</textarea>
            @error('about_private_teacher')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Attēls</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Pievienot</button>
    </form>
</div>



@endsection
