@extends('layouts.app')

@section('title')
    <title>Mans profils</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mans profils</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Vārds</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Uzvārds</th>
                            <td>{{ $user->surname }}</td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Pilsēta</th>
                            <td>{{ $user->city ?? 'Nav atzīmēta' }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Rediģēt profilu</a>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Izpildītie eksāmeni</div>

                <div class="card-body">
                    @if ($completedExams->isEmpty())
                        <p>Jūs vēl neesat pabeidzis nevienu eksāmenu.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Eksāmens</th>
                                    <th>Iegūtais / Maksimālais punktu skaits</th>
                                    <th>Datums</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completedExams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->gads }} - {{ $exam->macibuPrieksmets->name }}</td>
                                        <td>{{ $exam->pivot->score }} / {{ $exam->pivot->max_score }}</td>
                                        <td>{{ \Carbon\Carbon::parse($exam->pivot->completed_at)->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
