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
                            <td>{{ $user->city ?? 'Nav apzīmēta' }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Rediģēt profilu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
