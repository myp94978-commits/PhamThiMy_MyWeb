<h1>Danh sách Product</h1>
<ul>
    @foreach($products as $product)
        <li>{{ $product }}</li>
    @endforeach
</ul>
