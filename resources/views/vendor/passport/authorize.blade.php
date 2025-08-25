<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-lg w-full">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Authorize Application</h1>
        <p class="mb-6 text-gray-700 dark:text-gray-300">
            <strong>{{ $client->name }}</strong> is requesting permission to access your account.
        </p>
        @if (count($scopes) > 0)
            <div class="mb-6">
                <p class="mb-2 text-gray-700 dark:text-gray-300">This application will be able to:</p>
                <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                    @foreach ($scopes as $scope)
                        <li>{{ $scope->description }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('passport.authorizations.approve') }}">
            @csrf
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">Authorize</button>
        </form>
        <form method="post" action="{{ route('passport.authorizations.deny') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button type="submit" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
        </form>
    </div>
</body>
</html>
