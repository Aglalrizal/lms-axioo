<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply to Support Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .ticket-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }

        .reply-content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Support Ticket Reply</h1>
        </div>

        <div class="content">
            <p>Hello {{ $ticket->full_name }},</p>

            <p>Thank you for contacting our support team. We have received your ticket and our team has responded to
                your inquiry.</p>

            <div class="ticket-info">
                <h3>Ticket Information:</h3>
                <p><strong>Ticket ID:</strong> #{{ $ticket->id }}</p>
                <p><strong>Subject:</strong> {{ $ticket->title }}</p>
                <p><strong>Status:</strong> <span class="status-badge">{{ ucfirst($ticket->status) }}</span></p>
                <p><strong>Submitted:</strong> {{ $ticket->created_at->format('d M Y, H:i') }}</p>
            </div>

            <h3>Our Response:</h3>
            <div class="reply-content">
                <p><strong>From:</strong> {{ $reply->admin_name }}</p>
                <p><strong>Date:</strong> {{ $reply->created_at->format('d M Y, H:i') }}</p>
                <hr>
                <div style="margin-top: 15px;">
                    {!! nl2br(e($reply->message)) !!}
                </div>
            </div>

            @if ($ticket->status === 'resolved')
                <div
                    style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <strong>✓ Ticket Status: Resolved</strong>
                    <p>Your ticket has been marked as resolved. If you need further assistance or have additional
                        questions, please feel free to create a new support ticket.</p>
                </div>
            @endif

            <p>If you have any further questions or concerns, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>
                <strong>LMS Axioo Support Team</strong>
            </p>
        </div>

        <div class="footer">
            <p>This is an automated message from our support system. Please do not reply directly to this email.</p>
            <p>&copy; {{ date('Y') }} LMS Axioo. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
