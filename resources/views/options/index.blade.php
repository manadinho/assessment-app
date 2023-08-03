@extends('master')

@section('content')
    <h3>Options</h3>
    <a class="btn btn-primary" href="{{route('options.create')}}">+ Add</a>

    <div class="mt-5 table-responsive">
        <table class="table table-hover table-striped col-sm-12 table-condensed cf">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($options as $option)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $option->name }}</td>
                        <td>{{ $option->price }}</td>
                        <td>{{ $option->created_at }}</td>
                        <td>{{ $option->updated_at }}</td>
                        <td><a class="fa fa-edit" href="{{ route('options.edit', $option->id) }}"></a>
                            <a class="fa fa-trash text-danger" href="{{ route('options.delete', $option->id) }}"></a></td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
@endsection