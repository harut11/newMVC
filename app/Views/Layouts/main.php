<!DOCTYPE html>
<html>
<head>
    <title>@title</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">
</head>

<body>
<!-- Navbar Section Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">New MVC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if(isAuth()) :?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/allusers">Users</a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if(!isAuth()) : ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if(isAuth()): ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications
                        <span class="badge badge-pill badge-success" id="notcount"></span>
                    </a>
                    <div class="dropdown-menu" id="notifications" aria-labelledby="navbarDropdown"></div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/details">Details</a>
                        <a class="dropdown-item" href="/friends">Friends</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item small text-danger" href="/deleteaccount">Delete account!</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>
<!-- Navbar Section End -->
<!-- Content Section Start -->
<div class="container mt-5">
    @yield
</div>
<!-- Content Section End -->
<!-- Scripts -->
<script type="text/javascript" src="/public/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/js/main.js"></script>
</body>
</html>