@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Booking Calendar</h2>
    <!-- Include the calendar blade file -->
    @include('view.calendar', ['events' => $events])
    <div id="errorContainer" class="alert alert-danger" style="display: none;"></div>

    <h2>Your Cart</h2>
    <!-- Check if the cart is empty -->
    @if(isset($message) && $message)
        <div class="alert alert-warning">
            {{ $message }}
        </div>
    @else
        <!-- Include the cart blade file and pass the cart data -->
        @include('view.cart', ['cartItems' => $cartItems, 'total' => $total])
    @endif

    <h2>Checkout</h2>
    <!-- Checkout form to submit -->
    <form action="{{ route('checkout.submit') }}" method="POST" id="orderForm">
        @csrf

        <!-- Customer Details Section -->
        <h4>Customer Details</h4>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="first_name">First Name *</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="last_name">Last Name *</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="phone_number">Phone Number *</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" required>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3 form-group">
                <label for="reg_number">Registration Number *</label>
                <input type="text" id="reg_number" name="reg_number" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="postcode">Post Code *</label>
                <input type="text" id="postcode" name="postcode" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="company">Company</label>
                <input type="text" id="company" name="company" class="form-control">
            </div>

            <div class="col-md-3 form-group">
                <label for="address">Address *</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <label for="city">City *</label>
                <input type="text" id="city" name="city" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="county">County</label>
                <input type="text" id="county" name="county" class="form-control">
            </div>

            <div class="col-md-3 form-group">
                <label for="country">Country *</label>
                <input type="text" id="country" name="country" class="form-control" required>
            </div>

            <div class="col-md-3 form-group">
                <label for="comment">Comment/Notes</label>
                <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <!-- Payment Options -->
        <h4>Payment Method</h4>
        <div class="col-md-3 form-group">
            <label>
                <input type="radio" name="payment_method" value="pay_at_fitting_center" required> Pay at Fitting Center
            </label>
        </div>

        <div class="col-md-3 form-group">
            <label>
                <input type="radio" name="payment_method" value="paypal" required> PayPal
            </label>
        </div>

        <div class="col-md-3 form-group">
            <label>
                <input type="radio" name="payment_method" value="credit_debit" required> Credit/Debit Card
            </label>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Hidden Fields for Calendar and Cart -->
        <!-- <input type="hidden" id="calendar_details" name="calendar_details">
        <input type="hidden" id="cart_items" name="cart_items">
        <input type="hidden" id="customer_details" name="customer_details"> -->
        <input type="hidden" id="selected_slot_details" name="selected_slot_details">

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit Order</button>
    </form>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Form script initialized");

            const form = document.querySelector('form');

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default submission

                try {
                    // Get selected calendar slot
                    const selectedSlot = collectSelectedCalendarSlot();

                    // Validate customer details
                    const customerDetails = collectCustomerDetails();

                    // Set hidden fields
                    document.getElementById('selected_slot_details').value = JSON.stringify(selectedSlot);

                    // Submit the form if all validations pass
                    form.submit();
                } catch (error) {
                    displayErrorMessage(error.message); // Show error to the user
                }
            });

            /**
             * Collect calendar details from FullCalendar events.
             */
            const collectSelectedCalendarSlot = () => {
                const selectedSlotElement = document.getElementById('selectedSlot');
                if (!selectedSlotElement || !selectedSlotElement.textContent.trim()) {
                    throw new Error('Please select a booking slot from the calendar.');
                }

                return { slot: selectedSlotElement.textContent.trim() };
            };

            /**
             * Collect customer details from form fields.
             */
            const collectCustomerDetails = () => {
                const customerDetails = {
                    first_name: document.getElementById('first_name')?.value.trim() || '',
                    email: document.getElementById('email')?.value.trim() || '',
                    phone_number: document.getElementById('phone_number')?.value.trim() || '',
                    address: document.getElementById('address')?.value.trim() || '',
                };

                if (!customerDetails.first_name || !customerDetails.email || !customerDetails.phone_number || !customerDetails.address) {
                    throw new Error('All customer fields (Name, Email, Phone, Address) are required.');
                }

                return customerDetails;
            };

            /**
             * Display error message to the user.
             */
            const displayErrorMessage = (message) => {
                const errorContainer = document.getElementById('errorContainer');
                if (errorContainer) {
                    errorContainer.textContent = message;
                    errorContainer.style.display = 'block';
                } else {
                    alert(message); // Fallback for showing error
                }
            };
        });

    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formFields = document.querySelectorAll('#orderForm input, #orderForm textarea');

            // Save form data to session on blur
            formFields.forEach(field => {
                field.addEventListener('blur', function () {
                    const fieldName = this.name;
                    const fieldValue = this.value;

                    // Send data to update session
                    fetch('{{ route('checkout.storeInSession') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ fieldName, fieldValue }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Session updated:', data);
                            if (data.success) {
                                // Trigger saving customer to database when session is updated
                                saveCustomerToDatabase();
                            }
                        })
                        .catch(error => console.error('Error updating session:', error));
                });
            });

            // Save customer data to database
            const saveCustomerToDatabase = () => {
                fetch('{{ route('checkout.autoSaveCustomer') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({}),
                })
                    .then(response => response.text())  // Use .text() to log raw response
                    .then(data => {
                        // console.log('Raw Response from saving customer:', data);
                        try {
                            const jsonData = JSON.parse(data);  // Try parsing JSON
                            if (jsonData.success) {
                                console.log('Customer saved successfully:');
                            } else {
                                console.error('Error saving customer:', jsonData.error);
                            }
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                        }
                    })
                    .catch(error => console.error('Error saving customer to database:', error));
            };
        });


    </script>
@endpush