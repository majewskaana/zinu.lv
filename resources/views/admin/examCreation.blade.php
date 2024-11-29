@extends('layouts.app')
@section('title')
    <title>Pievienot eksāmenu</title>
@endsection('title')

@section('content')
<div class="container">
    <h1>Pievienot jaunu eksāmenu</h1>

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

        <div class="form-group">
            <label for="uzdevums">Jauns uzdevums</label>
            <textarea class="form-control @error('uzdevums') is-invalid @enderror" id="uzdevums" name="uzdevums" rows="4" required>{{ old('uzdevums') }}</textarea>
            @error('uzdevums')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="tema_id">Uzdevuma tēma</label>
            <select class="form-control @error('tema_id') is-invalid @enderror" id="tema_id" name="tema_id" required>
                <option value="">Izvēlēties...</option>
                @foreach($temas as $tema)
                    <option value="{{ $tema->id }}" {{ old('tema_id') == $tema->id ? 'selected' : '' }}>{{ $tema->text }}</option>
                @endforeach
            </select>
            @error('tema_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="variants">Atbildes:</label>
            <div id="variants">
                <div class="variant-group mb-3">
                    <input type="text" class="form-control mb-2" name="variants[]" placeholder="Atbilde">
                    <input type="radio" name="correct_variant" value="0"> Pareizā
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add_variant">Pievienot jaunu variantu</button>
        </div>
        <button type="submit" class="btn btn-primary">Pievienot</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

    $('#subject_id').change(function() {
        var subjectId = $(this).val();
        if (subjectId) {
            $.ajax({
                url: '/get-themes',
                type: 'GET',
                data: { subject_id: subjectId },
                success: function(response) {
                    $('#tema_id').empty();

                    $('#tema_id').append('<option value="">Izvēlēties...</option>');

                    $.each(response.themes, function(index, theme) {
                        $('#tema_id').append('<option value="' + theme.id + '">' + theme.text + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error); 
                    alert('Nesanāca atrast tēmas!');
                }
            });
        } else {
            $('#tema_id').empty().append('<option value="">Izvēlēties...</option>');
        }
    });


document.getElementById('add_variant').addEventListener('click', function() {
        const variantsDiv = document.getElementById('variants');
        const newVariantGroup = document.createElement('div');
        newVariantGroup.classList.add('variant-group', 'mb-3');
        newVariantGroup.innerHTML = `
            <input type="text" class="form-control mb-2" name="variants[]" placeholder="Atbilde">
            <input type="radio" name="correct_variant" value="${variantsDiv.children.length}"> Pareizā
        `;
        variantsDiv.appendChild(newVariantGroup);
    });



});


    
</script>

@endsection
