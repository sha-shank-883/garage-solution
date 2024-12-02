<form action="{{ route('checkout.submit') }}" method="POST">
    @csrf

    <!-- Customer Details -->
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
            <label for="booking_date">Select a Booking Date:</label>
            <input type="text" class="form-control" id="booking_date" name="booking_date" readonly>
        </div>

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
    <!-- In your checkoutform.blade.php -->



    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Submit Order</button>
</form>