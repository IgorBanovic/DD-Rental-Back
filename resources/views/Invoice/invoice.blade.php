<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .invoice-box { border: 1px solid #eee; padding: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #eee; text-align: left; }
    </style>
    <title></title>
</head>
<body>
<div class="invoice-box">
    <h2>INVOICE: {{ $invoice_no }}</h2>
    <p>Customer: {{ $reservation->user->name }}</p>
    <table>
        <tr><th>Car</th><td>{{ $reservation->car->brand }} {{ $reservation->car->type
      }}</td></tr>
        <tr><th>Period</th><td>{{ $reservation->start_date }} to {{ $reservation->end_date
      }}</td></tr>
        <tr><th>Total</th><td><strong>€{{ $reservation->price }}</strong></td></tr>
    </table>
</div>
</body>
</html>
