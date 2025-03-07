<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
        <p class="mt-4 text-gray-700 text-lg">YOUR IN WRONG PAGE</p>
        <p class="mt-4 text-gray-700 text-lg">Redirecting to your dashboard...</p>
    </div>

    <script>
         setTimeout(() => {
        let redirectUrl = {!! json_encode(session('redirect_url', url('/'))) !!}; // Ensure proper parsing
        window.location.href = redirectUrl;
    }, 3000); // 3-second delay before redirect
    </script>
</body>
</html>
