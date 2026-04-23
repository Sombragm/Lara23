<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Formulario --}}
        <div class="mt-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-100 dark:ring-gray-700 p-7 sm:p-8">
            @if(isset($productToEdit))
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Editar Producto</h3>
                <form action="{{ route('productos.update', $productToEdit->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
            @else
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-6">Nuevo Producto</h3>
                <form action="{{ route('productos.store') }}" method="POST" class="space-y-6">
                    @csrf
            @endif

                <input type="hidden" name="page" value="{{ request('page', $products->currentPage()) }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-sm transition">
                        {{ isset($productToEdit) ? 'Actualizar' : 'Guardar' }}
                    </button>
                    @if(isset($productToEdit))
                        <a href="{{ route('productos', ['page' => request('page', $products->currentPage())]) }}"
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
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Listado de Productos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Descripción</th>
                            <th class="px-6 py-4 text-right">Precio</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($products as $product)
                        <tr class="hover:bg-slate-200 dark:hover:bg-slate-700/80 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $product->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 max-w-md whitespace-normal break-words">{{ $product->description ?? '—' }}</td>
                            <td class="px-6 py-4 text-right text-gray-700 dark:text-gray-200 font-mono whitespace-nowrap">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('productos.edit', ['id' => $product->id, 'page' => $products->currentPage()]) }}"
                                        class="inline-flex items-center text-white text-xs font-semibold px-3 py-1.5 rounded-md transition"
                                        style="background-color:#d97706;"
                                        onmouseover="this.style.backgroundColor='#b45309'"
                                        onmouseout="this.style.backgroundColor='#d97706'">
                                        Editar
                                    </a>
                                    <form action="{{ route('productos.destroy', $product->id) }}" method="POST"
                                        data-confirm-delete="true"
                                        data-confirm-title="Eliminar producto"
                                        data-confirm-text="¿Eliminar el producto «{{ $product->name }}»? Esta accion no se puede deshacer.">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ $products->currentPage() }}">
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
                            <td colspan="6" class="px-6 py-6 text-center text-gray-400 dark:text-gray-500">
                                No hay productos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
