<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }
        h1 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background-color: #0056b3;
        }
        #loginMessage {
            margin-top: 15px;
            color: #d9534f;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 12px;
        }
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form id="loginForm">
            @csrf
            <div>
                <label for="login">Email or Username:</label>
                <input type="text" id="login" name="email" placeholder="Emain" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>
            <button type="submit">Login</button>
            <div id="loginMessage"></div>
            <p class="text-center">New User ? <a href="{{ route('register.page') }}">Create a account</a></p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // jQuery Validation
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter your email or username.',
                        email: 'Please enter a valid email address.'
                    },
                    password: {
                        required: 'Please provide a password.',
                        minlength: 'Your password must be at least 8 characters long.'
                    }
                },
                submitHandler: function(form) {
                    const formData = $(form).serialize();

                    $.ajax({
                        url: '{{ route('login.api') }}',
                        method: 'POST',
                        data: formData,
                        success: function(data) {
                            if (data.success) {
                                localStorage.setItem('authToken', data.token);
                                toastr.success('Login successful!');
                                setTimeout(() => {
                                    window.location.href = '{{ route('profile.page') }}';
                                }, 1000);
                            } else {
                                toastr.error(data.message || 'You have entered an invalid username or password');
                            }
                        },
                        error: function(xhr, status, error) {
                            // console.error('Error:', error);
                            toastr.error('You have entered an invalid username or password');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
