<?php

namespace App\Http\Controllers\ViewController;


use App\tblitems;
use App\Workshop;
use App\Customer;
use App\TyresProduct;
use Carbon\Carbon;
use DB;
use App\Booking;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get the cart items from the session
        $cart = session('cart', []);

        $cartItems = [];
        $total = 0;
        $message = null;

        // Check if the cart is empty
        if (empty($cart)) {
            $message = 'No items added to the cart.';
        } else {
            // If cart has items, process each item
            foreach ($cart as $item) {
                if (is_array($item) && isset($item['id'], $item['quantity'])) {
                    $product = TyresProduct::find($item['id']);
                    if ($product) {
                        $cartItems[] = [
                            'product_id' => $product->product_id,
                            'desc' => $product->description,
                            'price' => $product->price,
                            'quantity' => $item['quantity'],
                            'total' => $product->price * $item['quantity'],
                        ];
                        $total += $product->price * $item['quantity'];
                    }
                }
            }
        }

        // Example events data
        $events = Booking::all()->map(function ($booking) {
            return [
                'title' => $booking->title,
                'start' => $booking->start ? $booking->start->format('Y-m-d\TH:i:s') : null,
                'end' => $booking->end ? $booking->end->format('Y-m-d\TH:i:s') : null,
            ];
        })->filter(function ($event) {
            return $event['start'] && $event['end']; // Exclude events with invalid dates
        });

        $bookingDetails = session('booking_details', []);



        // Pass all data to the view
        return view('view.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'message' => $message,
            'events' => json_encode($events),
            'bookingDetails' => $bookingDetails, // Pass events as JSON
        ]);
    }


    public function autoSaveCustomer(Request $request)
    {
        // Retrieve customer session data
        $customerData = Session::get('customer');

        if (!$customerData) {
            return response()->json(['success' => false, 'error' => 'No customer data found in session.'], 400);
        }

        try {
            $customer = Customer::where('customer_email', $customerData['email'])->first();

            if ($customer) {
                $customer->update([
                    'customer_name' => $customerData['first_name'] ?? $customer->customer_name,
                    'customer_contact_number' => $customerData['phone_number'] ?? $customer->customer_contact_number,
                    'customer_address' => $customerData['address'] ?? $customer->customer_address,
                ]);
            } else {
                $customer = Customer::create([
                    'customer_name' => $customerData['first_name'],
                    'customer_email' => $customerData['email'],
                    'customer_contact_number' => $customerData['phone_number'],
                    'customer_address' => $customerData['address'],
                ]);
            }

            // Store customer ID in session
            Session::put('customer_id', $customer->id);

            return response()->json(['success' => true, 'customer_id' => $customer->id], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }






    // Method to handle the form submission
    // public function submitOrder(Request $request)
    // {
    //     // Retrieve data from session
    //     $customerData = Session::get('customer');
    //     $cartData = Session::get('cart');
    //     $paymentMethod = $request->input('payment_method'); // Received from the form

    //     if (!$customerData || !$cartData) {
    //         return back()->with('error', 'Missing customer or cart data in session.');
    //     }

    //     // Save customer data to the database
    //     $customer = Customer::create([
    //         'customer_name' => $customerData['first_name'],
    //         'customer_email' => $customerData['email'],
    //         'customer_contact_number' => $customerData['phone_number'],
    //         'customer_address' => $customerData['address'],
    //         // 'city' => $customerData['city'],
    //         // 'postcode' => $customerData['postcode'],
    //         // 'reg_number' => $customerData['reg_number'],
    //         // 'comment' => $customerData['comment'],
    //     ]);

    //     // Save workshop data to the database
    //     // Workshop::create([
    //     //     'customer_id' => $customer->id,
    //     //     'cart_details' => json_encode($cartData),
    //     //     'payment_method' => $paymentMethod,
    //     // ]);

    //     // Clear session after saving
    //     Session::forget('customer');
    //     // Session::forget('cart');

    //     return redirect()->route('checkout.success')->with('success', 'Order submitted successfully!');
    // }
    public function storeInSession(Request $request)
    {
        $fieldName = $request->input('fieldName');
        $fieldValue = $request->input('fieldValue');

        // Retrieve or create the customer session
        $customerData = Session::get('customer', []);
        $customerData[$fieldName] = $fieldValue;

        // Save updated data in the session
        Session::put('customer', $customerData);

        // Debugging: Check if session data is correct
        Log::info('Updated customer session data:', $customerData);

        // Return response with success
        return response()->json(['success' => true, 'session_data' => $customerData]);
    }

    public function submit(Request $request)
    {
        $rules = [
            // Calendar and Cart data
            // 'start' => 'required|json',
            // 'end' => 'required|json',
            // 'selected_slot_details' => 'nullable|json',
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            // 'cart_items' => 'nullable|json',
            'customer_details' => 'nullable|json',

            // Workshop data
            'customer_id' => 'nullable|integer',
            'is_workshop' => 'nullable|boolean',
            'name' => 'nullable|string|max:255',
            'reference' => 'nullable|string',
            'company' => 'nullable|string',
            'gst_no' => 'nullable|string',
            'mobile' => 'nullable|string',
            'landline' => 'nullable|string',
            // 'email' => 'nullable|email',
            // 'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'pin' => 'nullable|string',
            'vehicle_reg_number' => 'nullable|string',
            'model_year' => 'nullable|integer',
            'company_name' => 'nullable|string',
            'model_number' => 'nullable|string',
            'brand' => 'nullable|string',
            'vin' => 'nullable|string',
            'reg_number' => 'nullable|string',
            'odometer_reading' => 'nullable|integer',
            'color' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'engine_number' => 'nullable|string',
            'key_number' => 'nullable|string',
            'due_in' => 'nullable|date',
            'due_out' => 'nullable|date',
            'status' => 'nullable|string',
            'is_complete' => 'nullable|boolean',
            'advisor' => 'nullable|string',
            'notes' => 'nullable|string',
            'paid_price' => 'nullable|numeric',
            'installmentPayment' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'balance_price' => 'nullable|numeric',
            'grandTotal' => 'nullable|numeric',
            'serviceGST' => 'nullable|numeric',
            'submited_part' => 'nullable|string',
            'others_submited_part' => 'nullable|string',
        ];

        // Create the Validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Dump the validation errors if there are any
            // return back()->withErrors('Please select a booking slot.');
            dd($validator->errors()->all());
        }

        // If validation passes, get the validated data
        $validated = $validator->validated();
        Log::info('Request validated:', $validated);

        // Decode JSON inputs
        // $slotDetails = json_decode($request->selected_slot_details, true);

        // Merge default values with validated workshop details
        $workshopDefaults = [
            'is_workshop' => 1,
            // 'name' => 'Unnamed Workshop',
            'status' => 'Pending',
            'is_complete' => false,
            'paid_price' => 0,
            'installmentPayment' => 0,
            'discount_price' => 0,
            'balance_price' => 0,
            'grandTotal' => 0,
            'serviceGST' => 0,
        ];
        $workshopData = array_merge($workshopDefaults);

        try {
            DB::beginTransaction();

            // Log validated input
            Log::info('Validated Data:', $validated);

            // Save customer

            $customerId = Session::get('customer_id'); // Retrieve customer_id from session
            $customer = Session::get('customer', []); // Provide default empty array
            $customer_name = $customer['first_name'] ?? null;
            $customer_contact_number = $customer['phone_number'] ?? null;
            $customer_email = $customer['email'] ?? null;
            $customer_address = $customer['address'] ?? null;
            $reg_number = $customer['reg_number'] ?? null;
            // dd($customer_name);
            if (!$customerId) {
                // If not in session, fetch by email or create a new customer
                $customer = Customer::where('customer_email', $validated['email'])->first();
                if ($customer) {
                    $customer->update([
                        'customer_name' => $validated['first_name'] ?? $customer->customer_name,
                        'customer_contact_number' => $validated['phone_number'] ?? $customer->customer_contact_number,
                        'customer_address' => $validated['address'] ?? $customer->customer_address,
                    ]);
                    $customerId = $customer->id;
                } else {
                    $customer = Customer::create([
                        'customer_name' => $validated['first_name'],
                        'customer_email' => $validated['email'],
                        'customer_contact_number' => $validated['phone_number'],
                        'customer_address' => $validated['address'],
                    ]);
                    $customerId = $customer->id;
                    $customer_name = $customer->customer_name;
                }

                // Store customer_id in session for future use
                Session::put('customer_id', $customerId);
            }
            Log::info('Customer saved:', ['id' => $customerId]);

            // Save workshop
            $workshopData['customer_id'] = $customerId;
            $workshopData['name'] = $customer_name;
            $workshopData['email'] = $customer_email;
            $workshopData['address'] = $customer_address;
            $workshopData['mobile'] = $customer_contact_number;
            $workshopData['vehicle_reg_number'] = $reg_number;
            Log::info('Saving Workshop:', $workshopData);
            $workshop = Workshop::create($workshopData);
            Log::info('Workshop saved:', ['id' => $workshop->id]);

            // Save cart items
            $cartItems = Session::get('cart', []);
            foreach ($cartItems as $item) {
                Log::info('Saving Cart Item:', $item);
                // dd($item);
                tblitems::create([
                    'workshop_id' => $workshop->id,
                    'item_ean' => $item['ean'],
                    'item_sku' => $item['sku'],
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'description' => $item['desc'],
                    'price' => $item['price'],
                ]);
            }
            Log::info('Cart items saved.');

            // Save calendar details
            // foreach ($slotDetails as $booking) {
            $slotDetails = Session::get('booking_details', []);
            Log::info('Saving Calendar Booking:', $slotDetails);
            Booking::create([
                'workshop_id' => $workshop->id,
                'title' => $customer_name,
                'start' => Carbon::parse($slotDetails['start'])->format('Y-m-d H:i:s'),
                'end' => Carbon::parse($slotDetails['end'])->format('Y-m-d H:i:s'),
            ]);
            // }
            Log::info('Calendar details saved.');

            DB::commit();
            Session::flush();
            return redirect()->route('checkout.ordersuccess')->with('message', 'Order submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during submission:', ['error' => $e->getMessage()]);
            return back()->withErrors('Error processing request: ' . $e->getMessage());
        }
    }





    // public function submitCheckout(Request $request)
    // {
    //     // Validate form data
    //     $validated = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'customer_contact_number' => 'required|string|max:15',
    //         'customer_alt_number' => 'nullable|string|max:15',
    //         'customer_email' => 'required|email|max:255',
    //         'customer_address' => 'required|string|max:500',
    //         'customer_gstin' => 'nullable|string|max:20',
    //     ]);

    //     // Combine first name and last name
    //     $validated['customer_name'] = $request->first_name . ' ' . $request->last_name;

    //     // Add created_by and default status
    //     $validated['created_by'] = auth()->id() ?? 1; // Replace with the authenticated user ID or default ID
    //     $validated['status'] = 'active';

    //     // Store customer data
    //     Customer::create($validated);

    //     return redirect()->route('checkout.success')->with('success', 'Customer data saved successfully!');
    // }


    // public function submitWorkshop(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validated = $request->validate([
    //         'customer_id' => 'required|integer',
    //         'is_workshop' => 'required|boolean',
    //         'name' => 'required|string|max:255',
    //         'reference' => 'nullable|string',
    //         'company' => 'nullable|string',
    //         'gst_no' => 'nullable|string',
    //         'mobile' => 'nullable|string',
    //         'landline' => 'nullable|string',
    //         'email' => 'nullable|email',
    //         'address' => 'nullable|string',
    //         'city' => 'nullable|string',
    //         'state' => 'nullable|string',
    //         'pin' => 'nullable|string',
    //         'vehicle_reg_number' => 'nullable|string',
    //         'model_year' => 'nullable|integer',
    //         'company_name' => 'nullable|string',
    //         'model_number' => 'nullable|string',
    //         'brand' => 'nullable|string',
    //         'vin' => 'nullable|string',
    //         'reg_number' => 'nullable|string',
    //         'odometer_reading' => 'nullable|integer',
    //         'color' => 'nullable|string',
    //         'fuel_type' => 'nullable|string',
    //         'engine_number' => 'nullable|string',
    //         'key_number' => 'nullable|string',
    //         'due_in' => 'nullable|date',
    //         'due_out' => 'nullable|date',
    //         'status' => 'nullable|string',
    //         'is_complete' => 'nullable|boolean',
    //         'advisor' => 'nullable|string',
    //         'notes' => 'nullable|string',
    //         'paid_price' => 'nullable|numeric',
    //         'installmentPayment' => 'nullable|numeric',
    //         'discount_price' => 'nullable|numeric',
    //         'balance_price' => 'nullable|numeric',
    //         'grandTotal' => 'nullable|numeric',
    //         'serviceGST' => 'nullable|numeric',
    //         'submited_part' => 'nullable|string',
    //         'others_submited_part' => 'nullable|string',
    //         'workshop_date' => 'required|date',
    //     ]);

    //     // Create the workshop record
    //     $workshop = Workshop::create([
    //         'customer_id' => $validated['customer_id'],
    //         'is_workshop' => $validated['is_workshop'],
    //         'name' => $validated['name'],
    //         'reference' => $validated['reference'],
    //         'company' => $validated['company'],
    //         'gst_no' => $validated['gst_no'],
    //         'mobile' => $validated['mobile'],
    //         'landline' => $validated['landline'],
    //         'email' => $validated['email'],
    //         'address' => $validated['address'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         'pin' => $validated['pin'],
    //         'vehicle_reg_number' => $validated['vehicle_reg_number'],
    //         'model_year' => $validated['model_year'],
    //         'company_name' => $validated['company_name'],
    //         'model_number' => $validated['model_number'],
    //         'brand' => $validated['brand'],
    //         'vin' => $validated['vin'],
    //         'reg_number' => $validated['reg_number'],
    //         'odometer_reading' => $validated['odometer_reading'],
    //         'color' => $validated['color'],
    //         'fuel_type' => $validated['fuel_type'],
    //         'engine_number' => $validated['engine_number'],
    //         'key_number' => $validated['key_number'],
    //         'due_in' => $validated['due_in'],
    //         'due_out' => $validated['due_out'],
    //         'status' => $validated['status'],
    //         'is_complete' => $validated['is_complete'],
    //         'advisor' => $validated['advisor'],
    //         'notes' => $validated['notes'],
    //         'paid_price' => $validated['paid_price'],
    //         'installmentPayment' => $validated['installmentPayment'],
    //         'discount_price' => $validated['discount_price'],
    //         'balance_price' => $validated['balance_price'],
    //         'grandTotal' => $validated['grandTotal'],
    //         'serviceGST' => $validated['serviceGST'],
    //         'submited_part' => $validated['submited_part'],
    //         'others_submited_part' => $validated['others_submited_part'],
    //         'workshop_date' => $validated['workshop_date'],
    //     ]);

    //     // Return a response (success page or redirect)
    //     return redirect()->route('order.success', ['order' => $workshop->id])
    //         ->with('success', 'Order submitted successfully!');
    // }
}
