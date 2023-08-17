<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php asset('css/styles.css'); ?>" />
    <title>Admin Login</title>
</head>

<body class="full-page-wrapper">
<div class="form-container container">
    <h1 style="text-align: center">Welcome Back !</h1>
    <form method="POST" action="/admin/login">
        <input type="hidden" name="_method" value="POST">
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required />
        </div>
        <div>
            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                required
            />
        </div>
        <input type="submit" value="Login" />
    </form>
</div>
</body>
</html>
