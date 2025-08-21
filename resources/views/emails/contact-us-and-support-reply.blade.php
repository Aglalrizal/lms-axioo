<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Reply</title>
    <style>
        body {
            margin: 0;
            padding: 40px 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #ffffff;
            color: #202124;
            line-height: 1.5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            margin-bottom: 40px;
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        .content {
            font-size: 14px;
        }

        .greeting {
            margin-bottom: 20px;
            color: #202124;
        }

        .message {
            margin-bottom: 20px;
            color: #5f6368;
        }

        .info-box {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
        }

        .info-box h3 {
            margin: 0 0 12px 0;
            color: #202124;
            font-size: 16px;
            font-weight: 500;
        }

        .info-row {
            margin: 8px 0;
            color: #5f6368;
        }

        .info-row strong {
            color: #202124;
        }

        .reply-content {
            background-color: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
        }

        .reply-meta {
            color: #5f6368;
            font-size: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f3f4;
        }

        .reply-text {
            color: #202124;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .original-message {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
        }

        .original-message h4 {
            margin: 0 0 12px 0;
            color: #202124;
            font-size: 16px;
            font-weight: 500;
        }

        .original-message p {
            margin: 8px 0;
            color: #5f6368;
        }

        .footer {
            padding-top: 20px;
            border-top: 1px solid #f1f3f4;
            font-size: 12px;
            color: #5f6368;
        }

        .footer p {
            margin: 8px 0;
        }

        /* Simple responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 15px;
            }

            .info-box,
            .reply-content {
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://upmyskill.id/pluginfile.php/1/theme_edumy/headerlogo2/1745895302/logo%20upmyskill%20for%20white.png"
                alt="UpMySkill" class="logo">
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo {{ $inquiry->full_name }},
            </div>

            <div class="message">
                @if (isset($inquiry->title))
                    Terima kasih telah menghubungi tim support kami. Kami telah meninjau tiket support Anda dan
                    memberikan tanggapan berikut:
                @else
                    Terima kasih telah menghubungi kami. Kami telah meninjau pesan Anda dan memberikan tanggapan
                    berikut:
                @endif
            </div>

            <div class="info-box">
                <h3>{{ isset($inquiry->title) ? 'Informasi Tiket' : 'Informasi Pesan' }}</h3>
                <div class="info-row"><strong>Nomor {{ isset($inquiry->title) ? 'Tiket' : 'Pesan' }}:</strong>
                    #{{ $inquiry->id }}</div>

                @if (isset($inquiry->title))
                    <div class="info-row"><strong>Judul:</strong> {{ $inquiry->title }}</div>
                    <div class="info-row"><strong>Kategori:</strong> {{ $inquiry->subject }}</div>
                @else
                    <div class="info-row"><strong>Email:</strong> {{ $inquiry->email }}</div>
                @endif

                <div class="info-row"><strong>Tanggal:</strong> {{ $inquiry->created_at->format('j M Y') }}</div>
            </div>

            @if (isset($inquiry->title))
                <div class="original-message">
                    <h4>Pesan Asli Anda</h4>
                    <p>{{ $inquiry->description }}</p>
                </div>
            @else
                <div class="original-message">
                    <h4>Pesan Asli Anda</h4>
                    <p>{{ $inquiry->message }}</p>
                </div>
            @endif

            <div class="reply-content">
                <div class="reply-meta">
                    <strong>{{ $reply->admin_name }}</strong> • {{ $reply->created_at->format('j M Y, H:i') }}
                </div>
                <div class="reply-text">{{ $reply->message }}</div>
            </div>

            <div class="message">
                @if (isset($inquiry->title))
                    Jika Anda memiliki pertanyaan lebih lanjut, silakan buat tiket support baru.
                @else
                    Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami kembali.
                @endif
            </div>

            <div class="message">
                <p>Salam hormat,<br>
                    <strong>Tim UpMySkill</strong>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Butuh bantuan? <strong>Hubungi support</strong> atau kunjungi Pusat Bantuan kami. Mohon jangan
                balas email ini.</p>
            <p>Email ini dikirim untuk memberikan informasi dan pembaruan seputar akun UpMySkill Anda.</p>
        </div>
    </div>
</body>

</html>
