<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Car Performance Report</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
        .text-center { text-align: center; }
        .header { margin-bottom: 40px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .report-title { font-size: 24px; font-weight: bold; margin: 0; }
        .report-date { font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #2c3e50; color: white; padding: 12px; text-align: left; }
        td { border-bottom: 1px solid #eee; padding: 12px; vertical-align: top; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<div class="header text-center">
    <h1 class="report-title">Car Performance Report</h1>
    <p class="report-date">Period: {{ $period }}</p>
    <p class="report-date">Generated on: {{ now()->format('d.m.Y H:i') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Brand</th>
        <th>Type</th>
        <th class="text-right">Total Bookings</th>
        <th class="text-right">Total Revenue</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $car)
        <tr>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->type }}</td>
            <td class="text-right">{{ $car->total_bookings }}</td>
            <td class="text-right">${{ number_format($car->total_revenue, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
