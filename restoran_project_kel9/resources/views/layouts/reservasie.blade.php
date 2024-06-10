<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation</title>
    <meta name="description" content="Reserve your table at our restaurant easily and quickly. Choose your preferred day and time, and provide your contact details.">
    <link rel="stylesheet" href="frontend/reservasi/stylee.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <section class="banner">
        <img src="frontend/assets/img/about.jpg" alt="Background Image" class="bg-img">
        <div class="overlay">
            <h2>BOOK YOUR TABLE NOW</h2>
            <div class="card-container">
                <div class="card-content">
                    <h1>Reservation</h1>
                    <form id="reservationForm" action="{{ route('midtrans.checkout') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <label for="date">Select Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <label for="time_slot">Select Time Slot</label>
                            <select name="time_slot" id="time_slot" class="form-control" required>
                                <option value="">Select Time Slot</option>
                                <option value="10:00-12:00">10:00 - 12:00</option>
                                <option value="13:00-14:00">13:00 - 14:00</option>
                                <option value="15:30-18:00">15:30 - 18:00</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Full Name" class="form-control" required>
                            <input type="tel" name="phone" placeholder="Phone Number" class="form-control" required>
                            <input type="number" name="qty" placeholder="Quantity" class="form-control" min="1" required>
                        </div>
                        <div class="form-row">
                            <label for="available_tables">Available Tables</label>
                            <div id="available_tables" class="form-control">Loading...</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Reserve Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('reservationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            form.submit();
        });

        // Fetch available tables when date or time slot changes
        document.getElementById('date').addEventListener('change', fetchAvailableTables);
        document.getElementById('time_slot').addEventListener('change', fetchAvailableTables);

        function fetchAvailableTables() {
            var date = document.getElementById('date').value;
            var timeSlot = document.getElementById('time_slot').value;
            if (date && timeSlot) {
                fetch(`/api/available-tables?date=${date}&time_slot=${timeSlot}`)
                    .then(response => response.json())
                    .then(data => {
                        var availableTablesDiv = document.getElementById('available_tables');
                        if (data.tables && data.tables.length > 0) {
                            availableTablesDiv.innerHTML = data.tables.join(', ');
                        } else {
                            availableTablesDiv.innerHTML = 'No tables available';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching available tables:', error);
                        document.getElementById('available_tables').innerHTML = 'Error loading tables';
                    });
            }
        }
    </script>
</body>
</html>
