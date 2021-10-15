<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Punto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="shadow overflow-hidden border-b bg-white border-gray-200 sm:rounded-lg flex justify-center ">
                    <form class="w-6/12 mt-5" method="POST" action="{{ route('points.update', $point) }}">
                        @method('PUT')
                        @csrf
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Nombre</label>
                            <input
                                class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                type="text" placeholder="Regular input" id="forms-labelOverInputCode" name="name"
                                value="{{ old('name', $point->name) }}"/>
                        </div>
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Description</label>
                            <textarea
                                class="w-full h-16 px-3 py-2 text-base text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                name="description"
                            >{{ old('description', $point->description) }}</textarea>
                        </div>
                        <div class="text-gray-700 mb-3">
                            <label class="block mb-1" for="forms-labelOverInputCode">Puntos</label>
                            <input
                                class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                type="number" placeholder="Regular input" id="forms-labelOverInputCode" name="point"
                                value="{{ old('point', $point->point) }}"/>
                        </div>
                        <div class="w-12/12 text-right">
                            <button
                                type="submit"
                                class="mb-5 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 p-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
