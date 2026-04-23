<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

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
            @if(isset($productToEdit))
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Editar Producto</h3>
                <form action="{{ route('productos.update', $productToEdit->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            @else
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Nuevo Producto</h3>
                <form action="{{ route('productos.store') }}" method="POST" class="space-y-4">
                    @csrf
            @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="name"
                            value="{{ old('name', $productToEdit->name ?? '') }}"
                            required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Precio</label>
                        <input type="number" step="0.01" min="0" name="price"
                            value="{{ old('price', $productToEdit->price ?? '') }}"
                            required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Descripción corta</label>
                        <input type="text" name="description"
                            value="{{ old('description', $productToEdit->description ?? '') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Categoría</label>
                        <select name="category_id"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="">-- Sin categoría --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ (old('category_id', $productToEdit->category_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Descripción larga</label>
                        <textarea name="descriptionLong" rows="3"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('descriptionLong', $productToEdit->descriptionLong ?? '') }}</textarea>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                        {{ isset($productToEdit) ? 'Actualizar' : 'Guardar' }}
                    </button>
                    @if(isset($productToEdit))
                        <a href="{{ route('productos') }}"
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
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Listado de Productos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Nombre</th>
                            <th class="px-6 py-3 text-left">Descripción</th>
                            <th class="px-6 py-3 text-right">Precio</th>
                            <th class="px-6 py-3 text-left">Categoría</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-6 py-3 text-gray-500 dark:text-gray-400">{{ $product->id }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-3 text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $product->description ?? '—' }}</td>
                            <td class="px-6 py-3 text-right text-gray-700 dark:text-gray-200 font-mono">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-3">
                                @if($product->category)
                                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                        {{ $product->category->name }}
                                    </span>
                                @elseif($product->category_name)
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full"
                                          title="Categoría eliminada">
                                        {{ $product->category_name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-xs">Sin categoría</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('productos.edit', $product->id) }}"
                                        class="bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium px-3 py-1.5 rounded-md transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('productos.destroy', $product->id) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar el producto «{{ $product->name }}»?')">
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
                            <td colspan="6" class="px-6 py-6 text-center text-gray-400 dark:text-gray-500">
                                No hay productos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
