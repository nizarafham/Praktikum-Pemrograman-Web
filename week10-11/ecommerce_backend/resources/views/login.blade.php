<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Login Test</h5>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>

                        <div class="mt-3">
                            <strong>Response:</strong>
                            <pre id="response" style="background: #f8f9fa; padding: 10px; margin-top: 10px;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            const data = {
                email: $('#email').val(),
                password: $('#password').val()
            };

            console.log('Sending data:', data);

            $.ajax({
                url: 'http://127.0.0.1:8000/api/login',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    $('#response').html(JSON.stringify(response, null, 2));

                    if(response.data && response.data.token) {
                        localStorage.setItem('token', response.data.token);
                        console.log('Token saved:', response.data.token);
                    }
                },
                error: function(xhr) {
                    $('#response').html(JSON.stringify(xhr.responseJSON, null, 2));
                }
            });
        });
    </script>
</body>
</html>
