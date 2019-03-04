<form class="w-50 mx-auto" action="/registersubmit" method="post">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control type-text" id="firstName"
               placeholder="Enter First Name" name="first_name" value="<?=session_get('old', 'first_name')?>">
        <small class="form-text text-danger"><?=session_get('errors', 'first_name')?></small>
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control type-text" id="lastName" placeholder="Enter Last Name" name="last_name"
               value="<?=session_get('old', 'last_name')?>">
        <small id="emailHelp" class="form-text text-danger"><?=session_get('errors', 'last_name')?></small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
               placeholder="Enter email" name="email" value="<?=session_get('old', 'email')?>">
        <small class="form-text text-danger"><?=session_get('errors', 'email')?></small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password"
               value="<?=session_get('old', 'password')?>">
        <small class="form-text text-danger"><?=session_get('errors', 'password')?></small>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password"
               name="confirm_password" value="<?=session_get('old', 'confirm_password')?>">
        <small class="form-text text-danger"><?=session_get('errors', 'confirm_password')?></small>
    </div>
    <button type="submit" class="btn btn-info mt-3" id="register">Register</button>
</form>