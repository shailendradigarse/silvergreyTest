<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Optional: Include your CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            font-size: 18px;
            color: #333;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #007bff;
        }

        #profileInfo {
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        .logout-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }

        .logout-link button {
            all: unset;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            background-color: #dc3545;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-link button:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div id="profileInfo">
            <!-- Profile data will be injected here by JavaScript -->
        </div>
        <form id="logout-form" action="{{ route('logout.api') }}" method="POST" style="display: none;">
            @csrf
            @method('POST')
        </form>
        <a href="javascript:void(0);" class="logout-link" onclick="logout()">Logout</a>
    </div>

    <script>
        // Function to handle logout
        function logout() {
            fetch('{{ route('logout.api') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': `Bearer ${localStorage.getItem('token')}` // Include the token
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('token');
                    window.location.href = '{{ route('login.page') }}';
                } else {
                    alert('Error logging out.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    
        // Fetch profile data
        fetch('{{ route('profile.api') }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}` // Include the token
            },
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Unauthorized');
            }
        })
        .then(data => {
            if (data.success) {
                document.getElementById('profileInfo').innerHTML = `
                    <p><strong>Name:</strong> ${data.data.user.name}</p>
                    <p><strong>Email:</strong> ${data.data.user.email}</p>
                    <p><strong>Mobile:</strong> ${data.data.user.phone_number}</p>
                `;
            } else {
                document.getElementById('profileInfo').textContent = 'Error loading profile.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('profileInfo').textContent = 'Please log in to view your profile.';
            setTimeout(() => {
                window.location.href = '{{ route('login.page') }}';
            }, 2000);
        });
    </script>
</body>
</html>
