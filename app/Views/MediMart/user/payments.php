<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - MediMart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f4f8;
        }
        .payment-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            margin: 0 auto 2rem;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 5px solid #4CAF50;
            border-radius: 10px;
        }
        .countdown {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        .confirm-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .confirm-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Scan QR Code to Pay</h2>
        <div class="qr-code">
            <!-- Replace this with an actual QR code image or dynamic generation -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=MediMartPayment" alt="Payment QR Code">
        </div>
        <div class="countdown" id="countdown">05:00</div>
        <button id="confirmBtn" class="confirm-btn" onclick="confirmPayment()">Confirm Payment</button>
    </div>

    <script>
        //    get order it from session


        const order_id = sessionStorage.getItem('order_id');
        console.log(order_id);
        

        // Countdown Timer function
        function startCountdown(duration, display) {
            let timer = duration, minutes, seconds;
            let countdownInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    display.textContent = "Time's up!";
                    document.getElementById('confirmBtn').disabled = true;
                }
            }, 1000);
        }

        window.onload = function () {
            let fiveMinutes = 60 * 5,
                display = document.querySelector('#countdown');
            startCountdown(fiveMinutes, display);
        };

        // Function to confirm payment and redirect
        function confirmPayment() {
            fetch('/MediMart/payments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_id: order_id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Payment created successfully') {
                    alert("Payment confirmed! Thank you for your purchase.");
                    // Redirect to the dashboard or confirmation page
                    window.location.href = '/MediMart/user/dashboard';  // Adjust this to the correct URL for your dashboard
                } else {
                    alert("Payment failed. Please try again.");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("An error occurred. Please try again.");
            });
        }
    </script>
</body>
</html>
