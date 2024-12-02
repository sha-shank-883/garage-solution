<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
    /* Optional: Add custom styling for modal */
    #bookingModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
<h1>Booking Calendar</h1>
<div id="calendar"></div>
<!-- <p id="selectedSlot" style="color: green; font-weight: bold;">Selected Slot</p> -->
{{-- Check if there's session data and display the booking slot --}}
@if(!empty($bookingDetails))
    @php
        $start = \Carbon\Carbon::parse($bookingDetails['start']);
        $end = \Carbon\Carbon::parse($bookingDetails['end']);
    @endphp
    <p id="selectedSlot" style="color: green; font-weight: bold;">
        Selected Slot: {{ $start->format('jS M Y, h:i A') }} - {{ $end->format('h:i A') }}
    </p>
@else
    <p id="selectedSlot" style="color: red; font-weight: bold;">No booking details available.</p>
@endif



<input type="hidden" id="selected_slot_details" name="selected_slot_details">




<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        // const selectedSlotDisplay = document.getElementById('selectedSlot');
        // const selectedSlotInput = document.getElementById('selected_slot_details');
        var sessionBooking = @json($bookingDetails);  // Inject session booking details into JavaScript
        var events = [];

        if (sessionBooking) {
            // Parse the booking details to create an event
            var startTime = new Date(sessionBooking.start);
            var endTime = new Date(sessionBooking.end);

            events.push({
                title: 'Booked Slot',
                start: startTime,
                end: endTime,
                backgroundColor: '#6aeb53', // Set a color to visually mark the booked slot
                borderColor: '#6aeb53'
            });
        }
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            allDaySlot: false,
            slotDuration: '00:40:00',
            slotMinTime: '08:00:00',
            slotMaxTime: '18:00:00',
            initialDate: new Date(), // Set the calendar to start from today's date
            validRange: {
                start: new Date().toISOString().split('T')[0] // Restrict past dates
            },
            weekends: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek'
            },
            // eventClick: function (info) {
            //     alert('Event: ' + info.event.title);
            // },
            events: events,
            select: function (info) {
                var startTime = new Date(info.start);
                var endTime = new Date(info.end);
                var timeDifference = (endTime - startTime) / (1000 * 60); // Convert milliseconds to minutes
                if (timeDifference > 40) {
                    alert('You can only select one slot of 40 minutes at a time.');
                    calendar.unselect();
                    return;
                }

                var calendarEl = document.getElementsByClassName('fc-highlight');
                // for (var i = 0; i < calendarEl.length; i++) {
                //     calendarEl[i].style.backgroundColor = '#6aeb53';
                // }
                var options = { hour: 'numeric', minute: 'numeric', hour12: true };
                var formattedTime = startTime.toLocaleTimeString('en-US', options);
                var cellContent = document.createElement('div');
                // cellContent.innerHTML = `
                // <p style="color: black; font-size: 12px; text-align: center;">
                //     Selected - ${formattedTime}
                // </p>`;
                for (var i = 0; i < calendarEl.length; i++) {
                    calendarEl[i].appendChild(cellContent.cloneNode(true));
                }
            },
            unselect: function (info) {
                var highlighted = document.getElementsByClassName('fc-highlight');
                for (var i = 0; i < highlighted.length; i++) {
                    highlighted[i].style.backgroundColor = '';
                    highlighted[i].innerHTML = '';
                }
            },
            selectAllow: function (info) {
                // Restrict selection to weekdays only (Monday to Friday)
                var dayOfWeek = info.start.getDay(); // Get the day of the week (0 = Sunday, 6 = Saturday)
                return dayOfWeek >= 1 && dayOfWeek <= 5; // Allow selection only for Monday to Friday
            },
            firstDay: new Date().getDay(),
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: '08:00',
                endTime: '18:00',
            },
            selectable: true,
            dateClick: function (info) {
                var clickedDateTime = new Date(info.dateStr);
                var now = new Date();
                var hours = clickedDateTime.getHours();
                if (hours < 8 || hours >= 18) {
                    alert('Bookings are allowed only between 08:00 and 18:00.');
                    return;
                }

                if (clickedDateTime < now) {
                    alert('Please select slot greater then current date and time');
                    calendar.unselect();
                    return;
                }

                var endDateTime = new Date(clickedDateTime.getTime() + 40 * 60 * 1000);

                var startTime = clickedDateTime.toISOString().slice(0, 16);
                var endTime = endDateTime.toISOString().slice(0, 16);
                var startLocal = clickedDateTime.toLocaleString('sv-SE', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                }).replace(' ', 'T');

                var endLocal = endDateTime.toLocaleString('sv-SE', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                }).replace(' ', 'T');


                function getOrdinalSuffix(day) {
                    if (day > 3 && day < 21) return 'th'; // Covers 4th-20th
                    switch (day % 10) {
                        case 1: return 'st';
                        case 2: return 'nd';
                        case 3: return 'rd';
                        default: return 'th';
                    }
                }

                // Format the start date and time
                var day = clickedDateTime.getDate();
                var month = clickedDateTime.toLocaleString('en-US', { month: 'short' }); // e.g., 'Dec'
                var year = clickedDateTime.getFullYear();
                var time = clickedDateTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

                // Combine everything into the desired format
                var formattedSlot = `${day}${getOrdinalSuffix(day)}, ${month} ${year}, ${time}`;

                // Update the selectedSlot display
                var options = { day: 'numeric', month: 'short', hour: 'numeric', minute: 'numeric', hour12: true };

                // var formattedSlots = clickedDateTime.toLocaleDateString('en-US', options);
                document.getElementById('selected_slot_details').value = JSON.stringify(clickedDateTime.toLocaleString());

                // Save booking details via AJAX
                fetch('{{ route('save.booking') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        start: startLocal,
                        end: endLocal,
                        _token: '{{ csrf_token() }}',
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Booking saved successfully:', data.message);

                            // Format the start and end times for display
                            var formattedStart = new Date(startLocal).toLocaleString('en-US', {
                                day: 'numeric', month: 'short', year: 'numeric',
                                hour: '2-digit', minute: '2-digit', hour12: true
                            });
                            var formattedEnd = new Date(endLocal).toLocaleString('en-US', {
                                hour: '2-digit', minute: '2-digit', hour12: true
                            });

                            // Update the frontend to display the newly booked slot
                            document.getElementById('selectedSlot').textContent =
                                `Selected Slot: ${formattedStart} - ${formattedEnd}`;

                            // Update the calendar with the booked slot
                            calendar.getEvents().forEach(event => event.remove()); // Clear old events
                            calendar.addEvent({
                                title: 'Booked Slot',
                                start: new Date(startLocal),
                                end: new Date(endLocal),
                                backgroundColor: '#6aeb53',
                                borderColor: '#6aeb53',
                            });
                        } else {
                            console.error('Error saving booking:', data.message);
                            alert('Failed to save booking. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Unexpected error:', error);
                        alert('Unexpected error occurred. Please try again.');
                    });
            },
        });

        calendar.render();

    });
</script>