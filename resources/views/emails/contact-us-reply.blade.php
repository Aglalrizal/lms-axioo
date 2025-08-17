<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply to Contact Message</title>
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

        .message-info {
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

        .original-message {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 3px solid #6c757d;
            margin: 15px 0;
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Contact Message Reply</h1>
        </div>

        <div class="content">
            <p>Hello {{ $contactUs->full_name }},</p>

            <p>Thank you for contacting us through our website. We have received your message and our team has responded
                to your inquiry.</p>

            <div class="message-info">
                <h3>Your Message Information:</h3>
                <p><strong>Message ID:</strong> #{{ $contactUs->id }}</p>
                <p><strong>Email:</strong> {{ $contactUs->email }}</p>
                <p><strong>Status:</strong> <span class="status-badge">{{ ucfirst($contactUs->status) }}</span></p>
                <p><strong>Submitted:</strong> {{ $contactUs->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="original-message">
                <strong>Your Original Message:</strong><br>
                {!! nl2br(e($contactUs->message)) !!}
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

            @if ($contactUs->status === 'replied')
                <div
                    style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <strong>✓ Message Status: Replied</strong>
                    <p>Your message has been replied. If you have any additional questions, please feel free to contact
                        us again.</p>
                </div>
            @endif

            <p>If you have any further questions or concerns, please don't hesitate to contact us.</p>

            <p>Best regards,<br>
                <strong>LMS Axioo Team</strong>
            </p>
        </div>

        <div class="footer">
            <p>This is an automated message from our contact system. Please do not reply directly to this email.</p>
            <p>&copy; {{ date('Y') }} LMS Axioo. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
