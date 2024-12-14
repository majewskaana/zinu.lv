@extends('layouts.app')
@section('title')
<title>Zinu!</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 row gy-4">
            <div class="card">
                <div class="card-header">Privātskolotāji</div>

                <div class="card-body">
                    <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="{{ route('privatskolotaji') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Privātskolotāju saraksts</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Mūsu vietne piedāvā plašu privātskolotāju klāstu, la Tu varētu veiksmīgi sagatavoties savam centralizētam eksāmenam.
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Uzsākt eksāmenu</div>

                <div class="card-body">
                    <div class="p-6">
                            <div class="flex items-center">
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="{{ route('examList') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Nokārtot eksāmenu</a></div>
                            </div>

                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Reģistrētiem lietotājiem ir iespēja nokārtot eksāmenu testa veidā, lai uzzinātu kādas tēmas vēl jāapgūst un tiks piedāvāti privātskolotāji, kas ir gatavi strādāt ar Tevi!
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card">
                <div class="card-header">Profils</div>

                <div class="card-body">
                    <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="{{ route('profile.show') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Apskatīt savu profilu</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Tu vari arī pievienot savu pilsētu.
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
