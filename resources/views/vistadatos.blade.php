<h1>Holissss ITIS23</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category ID</th>
    </tr>
    @foreach($pro as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->price }}</td>
        <td>{{ $p->category_id}}</td>
    </tr>
    @endforeach