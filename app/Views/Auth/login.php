<?php if(cookie_get('username')) : ?>
<div class="alert alert-success w-50 mx-auto" role="alert">
    <?= $_COOKIE['username'] . " please verify your email before log in" ?>
</div>
<?php endif; ?>

<?php if(cookie_get('must_verify')) : ?>
    <div class="alert alert-danger w-50 mx-auto" role="alert">
        <?= "Your email is not verified" ?>
    </div>
<?php endif; ?>

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