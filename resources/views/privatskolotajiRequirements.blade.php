@extends('layouts.app')

@section('title')
    <title>Kā kļūst par privātskolotāju? | Zinu!</title>
@endsection

@section('content')
<div class="bg-indigo-50 py-12 sm:py-16 lg:py-24">
    <div class="max-w-6xl mx-auto px-6 sm:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-indigo-700">Kā kļūst par privātskolotāju?</h1>
            <p class="mt-4 text-lg text-gray-600">
                Sāciet savu ceļu uz privātskolotāja profesiju! Lūdzu, sniedziet nepieciešamo informāciju, lai mēs varētu ar jums sazināties.
                <br>
                Nosūtiet šo informāciju uz <a href="mailto:info@gmail.com" class="text-indigo-500 underline">info@gmail.com</a>.
            </p>
        </div>
        <div class="bg-white shadow-xl rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lai kļūtu par privātskolotāju, norādiet šādu informāciju:</h2>
            <ul class="space-y-6 text-lg text-gray-700">
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">1</span>
                    <strong class="text-indigo-700">Vārds un uzvārds:</strong> Jūsu pilns vārds un uzvārds.
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">2</span>
                    <strong class="text-indigo-700">Priekšmeti, ko pasniedzat:</strong> Saraksts ar priekšmetiem, ko varat mācīt.
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">3</span>
                    <strong class="text-indigo-700">Kontaktinformācija:</strong> E-pasts vai tālruņa numurs.
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">4</span>
                    <strong class="text-indigo-700">Pilsēta (pēc izvēles):</strong> Norādiet pilsētu, kur strādājat.
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">5</span>
                    <strong class="text-indigo-700">Materiālu mācīšanas stils:</strong> Kā jūs pasniedzat materiālu (tiešsaistē, klātienē utt.).
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">6</span>
                    <strong class="text-indigo-700">Īss apraksts par sevi:</strong> Īss apraksts par jūsu pieredzi.
                </li>
                <li class="flex items-center bg-indigo-100 p-4 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-300">
                    <span class="inline-flex items-center justify-center w-10 h-10 text-white bg-indigo-600 rounded-full mr-4">7</span>
                    <strong class="text-indigo-700">Fotogrāfija:</strong> Pievienojiet augstas kvalitātes attēlu.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
