@extends('samples')

@section('content')
<div class="container">
    <h1>Edit Tyre Product</h1>
    <form action="{{ route('AutoCare.tyres.edit', $tyre->product_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" name="sku" id="sku" class="form-control" value="{{ $tyre->sku }}" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand:</label>
            <select name="brand" id="brand" class="form-control">
                <option value="">Select Brand</option>
                <!-- Replace with dynamic brand options if needed -->
                <option value="1" {{ $tyre->manufacturer_id == 1 ? 'selected' : '' }}>Brand 1</option>
                <option value="2" {{ $tyre->manufacturer_id == 2 ? 'selected' : '' }}>Brand 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ $tyre->price }}" required>
        </div>

        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ $tyre->model }}" required>
        </div>

        <div class="form-group">
            <label for="tyre_width">Width:</label>
            <input type="text" name="tyre_width" id="tyre_width" class="form-control" value="{{ $tyre->tyre_width }}"
                required>
        </div>

        <div class="form-group">
            <label for="tyre_profile">Profile:</label>
            <input type="text" name="tyre_profile" id="tyre_profile" class="form-control"
                value="{{ $tyre->tyre_profile }}" required>
        </div>

        <div class="form-group">
            <label for="tyre_diameter">Diameter:</label>
            <input type="text" name="tyre_diameter" id="tyre_diameter" class="form-control"
                value="{{ $tyre->tyre_diameter }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Tyre</button>
    </form>
</div>
@endsection