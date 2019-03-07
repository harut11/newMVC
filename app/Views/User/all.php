<table class="table w-50 mx-auto">
    <thead class="thead-light">
        <tr>
            <th scope="col">Avatar</th>
            <th scope="col">User</th>
            <th scope="col">Friend Request</th>
        </tr>
    </thead>
    <tbody id="users">
        <?php foreach ($users as $user): ?>
            <?php foreach ($images as $image): ?>
                <?php if ($user['id'] === $image['user_id']) {$imgName = $image['name'];} ?>
            <?php endforeach; ?>
            <tr>
                <td><img class="usersThumbnail" src="/public/uploads/<?=$imgName?>"></td>
                <td><?=$user['first_name'] . ' ' . $user['last_name']?></td>
                <td>
                    <button type="button" class="btn btn-success">Add friend
                        <i class="fas fa-user-plus ml-2"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>