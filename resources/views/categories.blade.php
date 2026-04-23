<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Categorías
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Mensajes de error de validación --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            @if(isset($categoryToEdit))
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Editar Categoría</h3>
                <form action="{{ route('categorias.update', $categoryToEdit->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            @else
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Nueva Categoría</h3>
                <form action="{{ route('categorias.store') }}" method="POST" class="space-y-4">
                    @csrf
            @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="name"
                            value="{{ old('name', $categoryToEdit->name ?? '') }}"
                            required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Descripción</label>
                        <input type="text" name="description"
                            value="{{ old('description', $categoryToEdit->description ?? '') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                        {{ isset($categoryToEdit) ? 'Actualizar' : 'Guardar' }}
                    </button>
                    @if(isset($categoryToEdit))
                        <a href="{{ route('categorias') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-5 py-2 rounded-lg transition">
                            Cancelar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Listado de Categorías</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Nombre</th>
                            <th class="px-6 py-3 text-left">Descripción</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-6 py-3 text-gray-500 dark:text-gray-400">{{ $category->id }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-600 dark:text-gray-300">{{ $category->description ?? '—' }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('categorias.edit', $category->id) }}"
                                        class="bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium px-3 py-1.5 rounded-md transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar la categoría «{{ $category->name }}»? Los productos la recordarán por nombre.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium px-3 py-1.5 rounded-md transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-400 dark:text-gray-500">
                                No hay categorías registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
