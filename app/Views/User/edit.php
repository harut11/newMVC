<form class="form form-image-upload editForm w-50 mx-auto" action="/editSubmit" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="editAvatar">Avatar</label>
        <input type="file" id="editAvatar" name="avatar" class="form-control-file">
        <small class="form-text text-danger"><?=session_get('errors', 'avatar')?></small>
        <img src="public/uploads/<?=$avatar[0]['name']?>" height="200" alt="Image preview..." id="forShow" class="mt-3">
    </div>
    <div class="form-group">
        <label for="editFirstName">First Name</label>
        <input type="text" class="form-control type-text" id="editFirstName"
               placeholder="Enter First Name" name="first_name" value="<?=$user[0]['first_name']?>">
        <small class="form-text text-danger"><?=session_get('errors', 'first_name')?></small>
    </div>
    <div class="form-group">
        <label for="editLastName">Last Name</label>
        <input type="text" class="form-control type-text" id="editLastName" placeholder="Enter Last Name" name="last_name"
               value="<?=$user[0]['last_name']?>">
        <small id="emailHelp" class="form-text text-danger"><?=session_get('errors', 'last_name')?></small>
    </div>
    <div class="form-group">
        <label for="editEmail">Email address</label>
        <input type="text" class="form-control" id="editEmail" aria-describedby="emailHelp"
               placeholder="Enter email" name="email" value="<?=$user[0]['email']?>">
        <small class="form-text text-danger"><?=session_get('errors', 'email')?></small>
    </div>
    <button type="submit" class="btn btn-info mt-3" id="edit">Edit</button>
</form>