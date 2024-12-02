<table class="table">
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item['desc'] }}</td>
                <td class="price">${{ $item['price'] }}</td> <!-- Add class "price" for later use -->
                <td>
                    <button class="btn btn-sm btn-danger update-cart" data-id="{{ $item['product_id'] }}"
                        data-action="decrease">-</button>
                    <span class="quantity">{{ $item['quantity'] }}</span> <!-- Add class "quantity" -->
                    <button class="btn btn-sm btn-success update-cart" data-id="{{ $item['product_id'] }}"
                        data-action="increase">+</button>
                </td>
                <td class="total">${{ $item['total'] }}</td> <!-- Add class "total" -->
                <td>
                    <button class="btn btn-sm btn-danger delete-item" data-id="{{ $item['product_id'] }}">Delete</button>
                </td>
            </tr>
            @php    $total += $item['total']; @endphp
        @endforeach
    </tbody>
</table>
<h3>Total: <span id="grand-total">${{ $total }}</span></h3>

<!-- Include jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Use event delegation to handle dynamically added buttons
    $(document).on('click', '.update-cart', function () {
        const id = $(this).data('id');
        const action = $(this).data('action');

        // Log debug information
        console.log('Update Cart Clicked:', { id, action });

        $.ajax({
            url: "{{ route('cart.update') }}", // Update action route
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                action: action
            },
            success: function (response) {
                if (response.success) {
                    // Find the row for the item and update the quantity and total
                    let row = $('button[data-id="' + id + '"]').closest('tr');
                    let quantityElement = row.find('.quantity');
                    let totalElement = row.find('.total');
                    let price = parseFloat(row.find('.price').text().replace('$', ''));

                    // Update quantity
                    let currentQuantity = parseInt(quantityElement.text());
                    if (action === 'increase') {
                        currentQuantity++;
                    } else if (action === 'decrease' && currentQuantity > 1) {
                        currentQuantity--;
                    }
                    quantityElement.text(currentQuantity);

                    // Update total price
                    let newTotal = (price * currentQuantity).toFixed(2);
                    totalElement.text('$' + newTotal);

                    // Update the grand total
                    let grandTotal = 0;
                    $('.total').each(function () {
                        grandTotal += parseFloat($(this).text().replace('$', ''));
                    });
                    $('#grand-total').text('$' + grandTotal.toFixed(2));
                } else {
                    console.error('Update Cart Failed:', response.message || 'Unknown error.');
                    alert(response.message || 'Failed to update the cart.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', { status, error, xhr });
            }
        });
    });

    $(document).on('click', '.delete-item', function () {
        const id = $(this).data('id');

        // Log debug information
        console.log('Delete Item Clicked:', { id });

        $.ajax({
            url: "{{ route('cart.delete') }}", // Delete action route
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                if (response.success) {
                    // Remove the row from the table
                    $('button[data-id="' + id + '"]').closest('tr').remove();

                    // Recalculate the grand total
                    let grandTotal = 0;
                    $('.total').each(function () {
                        grandTotal += parseFloat($(this).text().replace('$', ''));
                    });
                    $('#grand-total').text('$' + grandTotal.toFixed(2));
                } else {
                    console.error('Delete Item Failed:', response.message || 'Unknown error.');
                    alert(response.message || 'Failed to delete the item.');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', { status, error, xhr });
            }
        });
    });


</script>