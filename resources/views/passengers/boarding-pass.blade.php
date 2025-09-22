<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Boarding Pass</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .boarding-pass { border: 2px solid #333; padding: 20px; width: 600px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .info { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .info div { width: 48%; }
        .qr { text-align: center; margin-top: 20px; }
        .qr img { width: 150px; height: 150px; }
        .footer { text-align: center; margin-top: 10px; font-size: 12px; color: #555; }
        .seat { font-size: 22px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="boarding-pass">
        <div class="header">
            <h1>Kavumu Airport</h1>
            <h3>Boarding Pass</h3>
        </div>

        <div class="info">
            <div>
                <p><strong>Passenger:</strong> {{ $passenger->name }}</p>
                <p><strong>Email:</strong> {{ $passenger->email }}</p>
                <p><strong>Flight:</strong> {{ $passenger->flight->flight_number }}</p>
                <p><strong>Origin:</strong> {{ $passenger->flight->origin }}</p>
                <p><strong>Destination:</strong> {{ $passenger->flight->destination }}</p>
            </div>
            <div>
                <p><strong>Seat:</strong> <span class="seat">{{ $passenger->seat_number ?? 'Auto Assigned' }}</span></p>
                <p><strong>Boarding Time:</strong> {{ \Carbon\Carbon::parse($passenger->flight->departure_time)->subMinutes(45)->format('h:i A') }}</p>
                <p><strong>Gate:</strong> {{ $passenger->flight->gate ?? 'TBD' }}</p>
                <p><strong>Status:</strong> {{ $passenger->status }}</p>
            </div>
        </div>

        <div class="qr">
            <img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
            <p>Scan at boarding gate</p>
        </div>

        <div class="footer">
            Kavumu Airport - Safe travels!
        </div>
    </div>
</body>
</html>
