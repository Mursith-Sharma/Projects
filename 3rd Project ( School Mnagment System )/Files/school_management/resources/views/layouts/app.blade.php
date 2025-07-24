<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SchoolEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Content --}}
    <main class="p-4">
        @yield('content')
    </main>

</body>
</html>
