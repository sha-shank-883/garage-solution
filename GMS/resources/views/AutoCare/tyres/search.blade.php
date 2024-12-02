@extends('samples') 
@section('content')

@section('content')
<div class="container">
    <h1>Search Tyres</h1>
    <!-- Search Form -->
    <form action="{{ route('AutoCare.tyres.search') }}" method="GET">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="width">Width:</label>
                    <input type="text" name="width" id="width" class="form-control" value="{{ request('width') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="profile">Profile:</label>
                    <input type="text" name="profile" id="profile" class="form-control"
                        value="{{ request('profile') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="diameter">Diameter:</label>
                    <input type="text" name="diameter" id="diameter" class="form-control"
                        value="{{ request('diameter') }}">
                </div>
            </div>
        </div>


        <!-- New Search Fields -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sku">SKU:</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="{{ request('sku') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <select name="brand" id="brand" class="form-control">
                        <option value="">Select Brand</option>
                        <option value="1" {{ request('brand') == 1 ? 'selected' : '' }}>Brand 1</option>
                        <option value="2" {{ request('brand') == 2 ? 'selected' : '' }}>Brand 2</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="price_min">Price Range:</label>
                    <div class="d-flex">
                        <input type="number" name="price_min" id="price_min" class="form-control" placeholder="Min"
                            value="{{ request('price_min') }}">
                        <input type="number" name="price_max" id="price_max" class="form-control" placeholder="Max"
                            value="{{ request('price_max') }}">
                    </div>
                </div>
            </div>
        </div>




        <button type="submit" class="btn btn-primary">Search</button>
    </form>


    <!-- Tyres Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Model</th>
                <th>Width</th>
                <th>Profile</th>
                <th>Diameter</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tyres as $tyre)
                <tr>
                    <td>{{ $tyre->sku }}</td>
                    <td>{{ $tyre->manufacturer_id }}</td> <!-- Replace with the actual brand name if available -->
                    <td>{{ $tyre->price }}</td>
                    <td>{{ $tyre->model }}</td>
                    <td>{{ $tyre->tyre_width }}</td>
                    <td>{{ $tyre->tyre_profile }}</td>
                    <td>{{ $tyre->tyre_diameter }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('AutoCare.tyres.edit', $tyre->product_id) }}"
                            class="btn btn-sm btn-warning">Edit</a>

                        <!-- Delete Button -->
                        <form action="{{ route('AutoCare.tyres.delete', $tyre->product_id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No tyres found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div>
        {{ $tyres->links() }}
    </div>
</div>
@endsection