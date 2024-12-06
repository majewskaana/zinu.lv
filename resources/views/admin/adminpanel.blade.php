@extends('layouts.app')
@section('title')
<title>Admin panel</title>
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 row gy-4">
        <div class="card">
            <div class="card-header">Privātskolotāji</div>
            <div class="card-body p-6">
                <div class="flex items-center">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="{{ route('teacherCreation.create') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Pievienot privātskolotājus</a>
                    </div>
                </div>
                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        Mūsu vietne piedāvā plašu privātskolotāju klāstu, lai Tu varētu veiksmīgi sagatavoties savam centralizētam eksāmenam.
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Eksāmeni</div>
            <div class="card-body p-6">
                <div class="flex items-center">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="{{ route('examCreation.create') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Jauns eksāmens</a>
                    </div>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    Izveidot jaunu eksāmenu
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Mācību priekšmeti</div>
            <div class="card-body p-6">
                <div class="flex items-center">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Visi mācību priekšmeti</a>
                    </div>
                </div>
                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        Izveidot jaunu mācību priekšmetu.
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection