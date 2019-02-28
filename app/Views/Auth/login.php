<form class="w-25 mx-auto" action="/login-submit" method="post">
    <div class="form-group">
        <label for="Email1">Email address</label>
        <input type="text" class="form-control" id="Email1" aria-describedby="emailHelp"
               placeholder="Enter email" name="email2" value="">
        <small id="emailHelp" class="form-text text-danger"></small>
    </div>
    <div class="form-group">
        <label for="Password1">Password</label>
        <input type="password" class="form-control" id="Password1" placeholder="Password" name="password2"
               value="">
        <small class="form-text text-danger"></small>
    </div>
    <button type="submit" class="btn btn-info">Log In</button>
</form>