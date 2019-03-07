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
            <?php if (session_get('user_details', 'id') !== $user['id']): ?>
            <?php foreach ($images as $image): ?>
                <?php if ($user['id'] === $image['user_id']) {$imgName = $image['name'];} ?>
            <?php endforeach; ?>
            <tr>
                <td><img alt="avatar" class="usersThumbnail" src="/public/uploads/<?=$imgName?>"></td>
                <td><?=$user['first_name'] . ' ' . $user['last_name']?></td>
                <td>
                    <button type="button" class="btn btn-success" id="addFriend"
                            onclick="project.sendFriendRequest(<?=$user['id']?>, <?=session_get('user_details', 'id')?>)">
                        Add friend<i class="fas fa-user-plus ml-2"></i>
                    </button>
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>