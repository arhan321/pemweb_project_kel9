<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Order Confirmation</h2>
            </div>
            <div class="card-body" id="orderDetails">
                <h4 class="card-title">Thank you for your payment, {{ $order->name }}!</h4>
                <p class="card-text">Your order details are as follows:</p>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Order ID:</strong> {{ $order->id }}</li>
                    <li class="list-group-item"><strong>Date:</strong> {{ $order->days }}</li>
                    <li class="list-group-item"><strong>Start Time:</strong> {{ $order->start_time }}</li>
                    <li class="list-group-item"><strong>End Time:</strong> {{ $order->end_time }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $order->phone }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $order->customer_email }}</li>
                    <li class="list-group-item"><strong>Number of People:</strong> {{ $order->qty }}</li>
                    <li class="list-group-item"><strong>Total Price:</strong> Rp {{ number_format($order->total_price, 2) }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $order->status }}</li>
                </ul>
                <div class="mt-4 text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                    <button onclick="downloadPDF()" class="btn btn-success">Download PDF</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const orderDetails = document.getElementById('orderDetails').innerText;
            const splitDetails = orderDetails.split('\n');

            let y = 10;
            splitDetails.forEach(detail => {
                doc.text(detail, 10, y);
                y += 10;
            });

            doc.save('order-confirmation.pdf');
        }
    </script>
</body>
</html>
