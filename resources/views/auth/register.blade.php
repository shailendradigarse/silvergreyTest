<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        /* Header Styles */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="date"],
        form textarea,
        form select {
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        form textarea {
            resize: vertical;
            height: 100px;
        }

        form button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
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
        <h1>Register</h1>
        <form id="registerForm" action="{{ url('/api/signup') }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="********" required>

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********" required>

            <button type="submit">Register</button>
        </form>
        <p class="text-center">Already have account ? <a href="{{ route('login.page') }}">Log in</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // jQuery Validation
            $('#registerForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: '#password'
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter your name.',
                        minlength: 'Name must be at least 2 characters long.'
                    },
                    email: {
                        required: 'Please enter your email address.',
                        email: 'Please enter a valid email address.'
                    },
                    phone_number: {
                        required: 'Please enter your phone number.',
                        digits: 'Please enter a valid phone number.',
                        minlength: 'Phone number must be at least 10 digits long.'
                    },
                    password: {
                        required: 'Please provide a password.',
                        minlength: 'Your password must be at least 8 characters long.'
                    },
                    password_confirmation: {
                        required: 'Please confirm your password.',
                        minlength: 'Your confirmation password must be at least 8 characters long.',
                        equalTo: 'Password confirmation does not match.'
                    }
                },
                submitHandler: function(form) {
                    const formData = $(form).serialize();

                    $.ajax({
                        url: $(form).attr('action'),
                        method: 'POST',
                        data: formData,
                        success: function(data) {
                            if (data.success) {
                                toastr.success('Registration successful!');
                                setTimeout(() => {
                                    window.location.href = '{{ route('login.page') }}';
                                }, 1000);
                            } else {
                                toastr.error(data.message || 'Registration failed.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            toastr.error('An error occurred. Please try again.');
                        }
                    });
                }
            });

            // Toastr Configuration
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "tapToDismiss": true,
                "preventDuplicates": true
            };
        });
    </script>
</body>
