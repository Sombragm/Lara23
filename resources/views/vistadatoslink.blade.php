<h1>Lista de Datos de la API</h1>

@foreach ($res as $r)
    <div style="border: 1px solid black; padding: 10px; margin-bottom: 10px;">
        <h3>{{ $r['name'] }}</h3>
            <a href="{{ route('detalles', ['id' => $r['id']]) }}">
                <button>Ver Detalles</button>
            </a>

    </div>
@endforeach