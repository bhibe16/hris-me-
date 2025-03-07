<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
        <p class="mt-4 text-gray-700 text-lg">You are in the wrong page...</p>
        <p class="mt-4 text-gray-700 text-lg">You are being logged out...</p>
    </div>

    <script>
        setTimeout(() => {
            fetch("{{ route('logout') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            }).then(() => {
                window.location.href = "{{ url('/') }}"; // Redirect after logout
            });
        }, 2000); // Logout after 2 seconds
    </script>
</body>
</html>
