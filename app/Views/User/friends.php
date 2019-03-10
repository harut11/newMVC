<table class="table w-50 mx-auto">
    <thead class="thead-light">
    <tr>
        <th scope="col">Avatar</th>
        <th scope="col">User</th>
        <th scope="col">Friend Request</th>
    </tr>
    </thead>
    <tbody id="friends">
        <?php foreach ($friends as $friend): ?>
            <?php foreach ($images as $image): ?>
                <?php if ($friend['id'] === $image['user_id']) {$imgName = $image['name'];} ?>
            <?php endforeach; ?>
            <tr class="item" data-id="<?=$friend['id']?>">
                <td>
                    <a class="forModal" href="/usershow?<?=$friend['id']?>">
                        <img alt="avatar" class="usersThumbnail" src="/public/uploads/<?=$imgName?>">
                    </a>
                </td>
                <td>
                    <a class="forModal" href="/usershow?<?=$friend['id']?>">
                        <?=$friend['first_name'] . ' ' . $friend['last_name']?>
                    </a>
                </td>
                <td>
                    <button type="button" class="btn btn-danger deleteFriend">Delete friend
                        <i class="fas fa-user-minus ml-2"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="alert alert-danger d-none w-50 mx-auto" role="alert" id="friendAlert">
    You do not have any friends
</div>