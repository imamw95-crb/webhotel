<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #D4AF37;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            color: #1B2A4A;
            margin: 0;
        }
        .header .gold {
            color: #D4AF37;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        .invoice-title {
            text-align: right;
            font-size: 18px;
            color: #1B2A4A;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th, table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table th {
            background: #f8f8f8;
            font-weight: 600;
            color: #1B2A4A;
        }
        .label {
            color: #999;
            font-size: 10px;
            text-transform: uppercase;
        }
        .value {
            font-weight: 600;
            color: #1B2A4A;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .footer {
            text-align: center;
            color: #999;
            font-size: 10px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .total-box {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
        }
        .total-box .total-label {
            font-size: 14px;
            color: #666;
        }
        .total-box .total-value {
            font-size: 24px;
            font-weight: bold;
            color: #1B2A4A;
        }
        .payment-status {
            margin-top: 5px;
        }
        .paid { color: #28a745; }
        .unpaid { color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1><span class="gold">✦</span> {{ config('app.name', 'The Icon Hotel') }}</h1>
        <p>Kuningan, West Java, Indonesia</p>
        <p>Phone: (0232) 8951008 | Email: info@theicon.id</p>
    </div>

    <div class="invoice-title">INVOICE</div>

    <table>
        <tr>
            <td>
                <span class="label">Booking Code</span>
                <div class="value">{{ $booking->booking_code }}</div>
            </td>
            <td>
                <span class="label">Date</span>
                <div class="value">{{ $booking->created_at->format('d F Y') }}</div>
            </td>
            <td>
                <span class="label">Status</span>
                <div>
                    <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <h3>Guest Information</h3>
    <table>
        <tr><td width="30%"><span class="label">Name</span></td><td>{{ $booking->name }}</td></tr>
        <tr><td><span class="label">Email</span></td><td>{{ $booking->email }}</td></tr>
        <tr><td><span class="label">Phone</span></td><td>{{ $booking->phone }}</td></tr>
    </table>

    <h3>Booking Details</h3>
    <table>
        <tr>
            <th>Room Type</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Nights</th>
            <th>Guests</th>
        </tr>
        <tr>
            <td>{{ $booking->room_type ?? '—' }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}</td>
            <td>{{ $booking->guests }}</td>
        </tr>
    </table>

    @if($booking->notes)
        <h3>Special Requests</h3>
        <p style="background:#f8f8f8;padding:10px;border-radius:5px;">{{ $booking->notes }}</p>
    @endif

    <div class="total-box">
        <div class="total-label">Total Amount</div>
        <div class="total-value">Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}</div>
        <div class="payment-status">
            Payment:
            <span class="{{ $booking->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
                {{ $booking->payment_status === 'paid' ? '✓ Paid' : '✗ Unpaid' }}
            </span>
        </div>
    </div>

    <div class="footer">
        <p><strong>{{ config('app.name', 'The Icon Hotel') }}</strong> — A 4-Star Hotel in Kuningan</p>
        <p>Thank you for choosing us!</p>
    </div>
</body>
</html>
