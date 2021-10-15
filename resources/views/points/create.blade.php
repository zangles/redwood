<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Punto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p class="font-bold">Por favor corrige los errores:</p>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="shadow overflow-hidden border-b bg-white border-gray-200 sm:rounded-lg flex justify-center ">
                    <form class="w-6/12 mt-5" method="POST" action="{{ route('points.store') }}">
                        @csrf
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Nombre</label>
                            <input
                                class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                type="text" id="forms-labelOverInputCode" name="name"
                                value="{{ old('name') }}"/>
                        </div>
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Description</label>
                            <textarea
                                class="w-full h-16 px-3 py-2 text-base text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                name="description"
                            >{{ old('description') }}</textarea>
                        </div>
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Puntos</label>
                            <input
                                class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                type="number" id="forms-labelOverInputCode" name="point"
                                value="{{ old('point') }}"/>
                        </div>
                        <div class="w-12/12 text-right">
                            <button
                                type="submit"
                                class="mb-5 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 p-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
