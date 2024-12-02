@extends('layouts.app')
@section('title')
    <title>Pievienot privātskolotāju</title>
@endsection('title')

@section('content')
<div class="container">
    <h1>Pievienot jaunu privātskolotāju</h1>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
            <label for="gads">Mācību priekšmets</label>
            <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
            <option value="">Izvēlēties...</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
            {{ $subject->name }}
            </option>
             @endforeach
            </select>
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
