<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center p-4 text-slate-800">

    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-8 text-center border border-slate-200">
        <div class="mb-6 flex justify-center">
            <div class="h-20 w-20 bg-red-100 rounded-full flex items-center justify-center text-red-500">
                <span class="material-icons text-5xl">lock</span>
            </div>
        </div>

        <h1 class="text-4xl font-bold text-slate-800 mb-2">403</h1>
        <h2 class="text-xl font-semibold text-slate-600 mb-4">Access Denied</h2>

        <p class="text-slate-500 mb-8 leading-relaxed">
            {{ $exception->getMessage() ?: 'Unauthorized access. You do not have permission to view this page.' }}
        </p>

        <div class="space-y-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-red-500/30 flex items-center justify-center gap-2">
                    <span class="material-icons text-sm">logout</span>
                    Sign Out & Return to Login
                </button>
            </form>

            <a href="{{ url('/') }}"
                class="block w-full bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-3 px-6 rounded-xl transition-all flex items-center justify-center gap-2">
                <span class="material-icons text-sm">home</span>
                Go to Homepage
            </a>
        </div>
    </div>

</body>

</html>