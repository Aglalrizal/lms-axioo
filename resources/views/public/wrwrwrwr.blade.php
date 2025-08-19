<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* biar ga double scroll */
        }

        .layout {
            display: flex;
            height: 100vh;
            /* full layar */
        }

        .sidebar {
            width: 280px;
            background: #f8f9fa;
            border-right: 1px solid #ddd;
            padding: 1rem;
            height: 100vh;
            overflow-y: auto;
            /* scroll khusus sidebar */
        }

        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            /* scroll khusus konten kanan */
            height: 100vh;
        }
    </style>
</head>

<body>

    <!-- Header optional -->


</body>

</html>
