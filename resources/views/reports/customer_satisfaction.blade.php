<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Satisfaction Report</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
        .text-center { text-align: center; }
        .header { margin-bottom: 40px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .report-title { font-size: 24px; font-weight: bold; margin: 0; }
        .report-date { font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #2c3e50; color: white; padding: 12px; text-align: left; }
        td { border-bottom: 1px solid #eee; padding: 12px; vertical-align: top; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; color: white; }
        .bg-happy { background-color: #27ae60; }
        .bg-risk { background-color: #c0392b; }
        .bg-neutral { background-color: #7f8c8d; }
        .comment { font-style: italic; color: #555; font-size: 11px; }
    </style>
</head>
<body>

<div class="header text-center">
    <h1 class="report-title">Customer Satisfaction Report</h1>
    <p class="report-date">Generated on: {{ $generated_at }}</p>
</div>

<table>
    <thead>
    <tr>
        <th width="25%">Customer</th>
        <th width="15%">Avg. Rating</th>
        <th width="20%">Sentiment</th>
        <th width="40%">Latest Feedback</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $user)
        <tr>
            <td>
                <strong>{{ $user['name'] }}</strong><br>
                <small>{{ $user['email'] }}</small>
            </td>
            <td>{{ $user['average_rating'] }} / 5.0</td>
            <td>
                    <span class="badge {{ $user['sentiment'] == 'Very Happy' ? 'bg-happy' : ($user['sentiment'] == 'Unhappy' ? 'bg-risk' : 'bg-neutral') }}">
                        {{ strtoupper($user['sentiment']) }}
                    </span>
            </td>
            <td>
                <span class="comment">"{{ $user['last_feedback'] }}"</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
