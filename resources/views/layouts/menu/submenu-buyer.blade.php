<ul class="nav justify-content-center col-12">
    <li><a class="nav-link text-categories-nav" href="{{route('products-associates')}}">Categorias</a></li>
    @foreach (\App\Models\Category::get() as $category)
        <li class="nav-item">
            <a class="nav-link text-categories-nav" href="#{{$category->id}}">{{$category->name}}</a>
        </li>
    @endforeach
</ul>
