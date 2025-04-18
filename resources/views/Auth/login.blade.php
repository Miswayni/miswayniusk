<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-100">

    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-xl rounded-2xl transition duration-300">
        <h2 class="text-3xl font-bold text-center text-blue-600">Welcome Back</h2>
        <p class="text-center text-blue-400">Login to continue</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-blue-600">Email</label>
                <div class="relative">
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full px-4 py-2 pl-10 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300"
                        placeholder="you@example.com">
                    <svg class="absolute w-5 h-5 text-blue-300 left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-blue-600">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 pl-10 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300"
                        placeholder="••••••••">
                    <svg class="absolute w-5 h-5 text-blue-300 left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 15v2m0-6v2m-6 4h12a2 2 0 002-2V9a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="text-blue-400 form-checkbox rounded">
                    <span class="ml-2 text-blue-600">Remember me</span>
                </label>
                <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
            </div>

            <button type="submit"
                class="w-full py-2 font-semibold text-white bg-blue-400 hover:bg-blue-500 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                Login
            </button>
        </form>

        <p class="text-sm text-center text-blue-600">Don't have an account?
            <a href="#" class="text-blue-500 hover:underline">Sign up</a>
        </p>
    </div>

</body>
</html>
