<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Categorías
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Formulario --}}
        <div class="mt-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-100 dark:ring-gray-700 p-7 sm:p-8">
            @if(isset($categoryToEdit))
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Editar Categoría</h3>
                <form action="{{ route('categorias.update', $categoryToEdit->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
            @else
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Nueva Categoría</h3>
                <form action="{{ route('categorias.store') }}" method="POST" class="space-y-6">
                    @csrf
            @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-sm transition">
                        {{ isset($categoryToEdit) ? 'Actualizar' : 'Guardar' }}
                    </button>
                    @if(isset($categoryToEdit))
                        <a href="{{ route('categorias') }}"
                            class="inline-flex items-center text-sm font-semibold px-5 py-2 rounded-lg transition"
                            style="background-color:#475569;color:#ffffff;"
                            onmouseover="this.style.backgroundColor='#334155'"
                            onmouseout="this.style.backgroundColor='#475569'">
                            Cancelar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-100 dark:ring-gray-700" style="margin-top:2.75rem;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Listado de Categorías</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Descripción</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-200 dark:hover:bg-slate-700/80 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $category->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-normal break-words">{{ $category->description ?? '—' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('categorias.edit', $category->id) }}"
                                        class="inline-flex items-center text-white text-xs font-semibold px-3 py-1.5 rounded-md transition"
                                        style="background-color:#d97706;"
                                        onmouseover="this.style.backgroundColor='#b45309'"
                                        onmouseout="this.style.backgroundColor='#d97706'">
                                        Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $category->id) }}" method="POST"
                                        data-confirm-delete="true"
                                        data-confirm-title="Eliminar categoria"
                                        data-confirm-text="¿Eliminar la categoria «{{ $category->name }}»? Esta accion no se puede deshacer.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">
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
