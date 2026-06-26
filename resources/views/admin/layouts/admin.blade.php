<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
        .admin-page {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 240px;
            background-color: #212529;
            color: #ffffff;
            padding: 20px 16px;
            box-sizing: border-box;
        }
        .admin-sidebar .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .admin-sidebar .brand i {
            font-size: 1.3rem;
        }
        .admin-sidebar .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .admin-sidebar .nav-list li {
            margin-bottom: 10px;
        }
        .admin-sidebar .nav-list a {
            display: block;
            color: #c5c7cb;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .admin-sidebar .nav-list a:hover,
        .admin-sidebar .nav-list a.active {
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
        }
        .admin-sidebar .nav-list a i {
            margin-right: 8px;
        }
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #f0f2f5;
        }
        .admin-header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-header .user-actions a {
            color: #495057;
            text-decoration: none;
            margin-left: 20px;
        }
        .admin-header .user-actions a:hover {
            text-decoration: underline;
        }
        .admin-content {
            padding: 24px;
            flex: 1;
        }
        .admin-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        }
        .admin-footer {
            background-color: #212529;
            color: #ffffff;
            text-align: center;
            padding: 16px 24px;
            font-size: 0.95rem;
        }
        .admin-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: #ffffff;
            background-color: #0d6efd;
            border: 1px solid transparent;
            transition: background-color 0.15s ease;
        }
        .admin-button.secondary {
            background-color: #6c757d;
        }
        .admin-button:hover {
            background-color: #0b5ed7;
        }
        .admin-button.secondary:hover {
            background-color: #5c636a;
        }
    </style>
</head>
<body>
    <div class="admin-page">
        @include('admin._partials.sidebar')

        <div class="admin-main">
            @include('admin._partials.header')

            <main class="admin-content">
                @yield('content')
            </main>

            @include('admin._partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
