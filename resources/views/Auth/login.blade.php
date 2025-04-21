<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-blue-100">

    <div class="w-full max-w-sm p-6 bg-white border border-blue-200 rounded-lg">
        <h2 class="text-2xl font-semibold text-center text-blue-600 mb-4">Login</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm text-blue-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required autofocus
                    class="w-full px-3 py-2 border border-blue-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-300" />
            </div>

            <div>
                <label for="password" class="block text-sm text-blue-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border border-blue-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-300" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-blue-600">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="#" class="text-blue-500 hover:underline">Forgot?</a>
            </div>

            <button type="submit"
                class="w-full py-2 text-white bg-blue-400 hover:bg-blue-500 rounded">
                Login
            </button>
        </form>

        <p class="text-sm text-center text-blue-700 mt-4">Don't have an account?
            <a href="#" class="text-blue-500 hover:underline">Sign up</a>
        </p>
  
    </div>
</body>
</html>
