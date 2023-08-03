<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
        <li class="{{ request()->routeIs('products.*') ? 'active':''  }}"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="{{ request()->routeIs('options.*') ? 'active':''  }}"><a href="{{ route('options.index') }}">Options</a></li>
        </ul>
    </div>
</nav>