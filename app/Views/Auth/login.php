<div class="alert alert-success w-50 mx-auto" role="alert" id="login_message">

</div>
<form class="w-25 mx-auto" action="/loginsubmit" method="post">
    <div class="form-group">
        <label for="Email2">Email address</label>
        <input type="text" class="form-control" id="Email2" aria-describedby="emailHelp"
               placeholder="Enter email" name="email" value="<?=session_get('old', 'email')?>">
        <small id="emailHelp" class="form-text text-danger"><?=session_get('errors', 'email')?></small>
    </div>
    <div class="form-group">
        <label for="Password2">Password</label>
        <input type="password" class="form-control" id="Password2" placeholder="Password" name="password"
               value="<?=session_get('old', 'password')?>">
        <small class="form-text text-danger"><?=session_get('errors', 'password')?></small>
    </div>
    <button type="submit" class="btn btn-info">Log In</button>
</form>