<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Pamuruyan')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-4 mt-8">
        <p>Desa Pamuruyan {{ date('Y') }}</p>
    </footer>
</body>

</html>
