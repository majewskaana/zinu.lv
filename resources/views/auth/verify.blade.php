@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Apstiprināt e-pasta adresi</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                        Uz jūsu e-pasta adresi ir nosūtīta jauna pārbaudes saite.
                        </div>
                    @endif
                    Pirms turpināt, lūdzu, pārbaudiet, vai e-pasta ziņojumā nav pārbaudes saites.
                    Ja nesaņēmāt e-pasta ziņojumu,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">noklikšķiniet šeit, lai pieprasītu citu</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
