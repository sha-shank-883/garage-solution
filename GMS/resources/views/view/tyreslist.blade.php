@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tyre Listings</h1>

    <!-- Filter Form -->
    <form id="filterForm" class="mb-4">
        <div class="row">
            <!-- Width -->
            <div class="col-md-3">
                <select name="width" id="width" class="form-control">
                    <option value="">Select Width</option>
                    @foreach ($widths as $width)
                        <option value="{{ $width }}">{{ $width }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Profile -->
            <div class="col-md-3">
                <select name="profile" id="profile" class="form-control" disabled>
                    <option value="">Select Profile</option>
                </select>
            </div>

            <!-- Diameter -->
            <div class="col-md-3">
                <select name="diameter" id="diameter" class="form-control" disabled>
                    <option value="">Select Diameter</option>
                </select>
            </div>

            <!-- Search Button -->
            <div class="col-md-3">
                <button type="button" id="searchButton" class="btn btn-primary btn-block" disabled>Search</button>
            </div>
        </div>
    </form>

    <!-- Tyre Listings -->
    <div id="tyreList">
        @include('view.tyre-cards', ['tyres' => $tyres])
    </div>

    <div id="paginationContainer">
        {{ $tyres->links() }}
    </div>

</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        // Handle Width Change
        $('#width').change(function () {
            const width = $(this).val();
            console.log('Selected Width:', width);
            $('#profile').prop('disabled', true).html('<option value="">Select Profile</option>');
            $('#diameter').prop('disabled', true).html('<option value="">Select Diameter</option>');
            $('#searchButton').prop('disabled', true);

            if (width) {
                $.ajax({
                    url: "{{ route('tyres.getProfiles') }}",
                    type: "GET",
                    data: { width: width },
                    success: function (data) {
                        $('#profile').prop('disabled', false).html(data);
                    },
                });
            }
        });

        // Handle Profile Change
        $('#profile').change(function () {
            const width = $('#width').val();
            const profile = $(this).val();
            $('#diameter').prop('disabled', true).html('<option value="">Select Diameter</option>');
            $('#searchButton').prop('disabled', true);

            if (profile) {
                $.ajax({
                    url: "{{ route('tyres.getDiameters') }}",
                    type: "GET",
                    data: { width: width, profile: profile },
                    success: function (data) {
                        $('#diameter').prop('disabled', false).html(data);
                    },
                });
            }
        });

        // Handle Diameter Change
        $('#diameter').change(function () {
            const diameter = $(this).val();
            if (diameter) {
                $('#searchButton').prop('disabled', false);
            } else {
                $('#searchButton').prop('disabled', true);
            }
        });

        // Handle Search
        $(document).ready(function () {
            // Handle Search Button Click
            $('#searchButton').click(function () {
                const width = $('#width').val();
                const profile = $('#profile').val();
                const diameter = $('#diameter').val();

                // Perform AJAX Request
                $.ajax({
                    url: "{{ route('tyres.filter') }}",
                    type: "GET",
                    data: {
                        width: width,
                        profile: profile,
                        diameter: diameter
                    },
                    success: function (response) {
                        console.log('Response:', response);
                        $('#tyreList').html(response.tyres);
                        $('#pagination').html(response.pagination);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });
        });

    });
</script>
<script>
    $(document).on('click', '#add-to-cart', function (e) {
        e.preventDefault();

        const tyreId = $(this).data('id'); // Product ID from button data attribute

        $.ajax({
            url: "{{ route('cart.add') }}", // Adjust route as per your setup
            type: "POST",
            data: {
                id: tyreId, // Pass product ID
                _token: "{{ csrf_token() }}" // Include CSRF token for Laravel
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Product added to cart!',
                        text: 'Do you want to add more items or go to checkout?',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Go to Checkout',
                        cancelButtonText: 'Add More',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('view.checkout') }}";
                        }
                    });
                } else {
                    alert(response.message || 'Failed to add the product.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>


@endsection