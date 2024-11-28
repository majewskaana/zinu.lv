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
            <label for="uzdevums">Jauns uzdevums</label>
            <textarea class="form-control @error('uzdevums') is-invalid @enderror" id="uzdevums" name="uzdevums" rows="4" required>{{ old('uzdevums') }}</textarea>
            @error('uzdevums')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label for="tema_id">Uzdevuma tēma</label>
            <select class="form-control @error('tema_id') is-invalid @enderror" id="tema_id" name="tema_id" required>
                <option value="">Tēma</option>
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

<script>
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
</script>

@endsection
