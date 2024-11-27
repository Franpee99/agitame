<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear departamento
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('empleados.store') }}" class="max-w-sm mx-auto">
                @csrf
                <div class="mb-5">
                    <x-input-label for="numero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Número
                    </x-input-label>
                    <x-text-input name="numero" type="text" id="numero" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('numero')" />
                    <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre
                    </x-input-label>
                    <x-text-input name="nombre" type="text" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('nombre')" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Apellidos
                    </x-input-label>
                    <x-text-input name="apellidos" type="text" id="apellidos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('apellidos')" />
                    <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="departamento_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Departamento
                    </x-input-label>
                    <select name="departamento_id" id="departamento_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Seleccione un Departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->denominacion }} <!-- Aquí puedes mostrar el nombre del departamento -->
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Crear
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
