<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f0f0f0;
        }

        .card {
            background-color: #1e1e1e;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background-color: #2c2c2c;
            border: 1px solid #444;
            color: #e0e0e0;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .logo img {
            border-radius: 50%;
            border: 2px solid #007bff;
            padding: 5px;
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="w-100" style="max-width: 400px;">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4 logo">
                        SITOKU - LOGIN
                    </div>
                    <form method="POST" action="/login">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" autofocus autocomplete="username">
                            <div class="text-danger small mt-1">
                                <!-- Error messages for username -->
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password">
                            <div class="text-danger small mt-1">
                                <!-- Error messages for password -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between mt-4">

                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                            @endif


                            <button type="submit" class="btn btn-custom px-4 py-2">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>