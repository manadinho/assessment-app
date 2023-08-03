@extends('master')

@section('content')
    <h3>Products</h3> 
    <a class="btn btn-primary" href="{{route('products.create')}}">+ Add</a>

    <div class="mt-5 table-responsive">
        <table class="table table-hover table-striped col-sm-12 table-condensed cf">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                        <td><a class="fa fa-edit" href="{{ route('products.edit', $product->id) }}"></a>
                            <a class="fa fa-trash text-danger" href="{{ route('products.delete', $product->id) }}"></a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
@endsection