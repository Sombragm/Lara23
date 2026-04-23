<x-app-layout>
    
    <x-slot name="header">
        
        <h1 class="mt-1 text-sm text-gray-600 dark:text-gray-100">Detalle del Registro {{ $res['id'] }} </h1>
    </x-slot>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400"><strong> ID: </strong> {{ $res['id'] }} </p>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400"><strong> Nombre: </strong> {{ $res['name'] }} </p>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400"><strong> Imagen: </strong> </p> <img src="{{ $res['image'] }}"> 
 

            <a href="{{ route('vistadatos') }}">
                <button>Regresar</button>
            </a>

</x-app-layout>