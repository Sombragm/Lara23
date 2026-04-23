<h1>Lista de Datos de Mundo ITI</h1>

@foreach ($res as $r)
    <div style="border: 1px solid black; padding: 10px; margin-bottom: 10px;">
        <h3>{{ $r['title'] }}</h3>
        <p>{{ $r['body'] }}</p>
    </div>
@endforeach