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

            <tr class="item" data-id="<?=$user['id']?>">
                <?php foreach ($requests as $request): ?>
                    <?php (isset($request['user_to']) && $request['user_to'] === $user['id']) ? $user_id = $request['user_to'] : null ?>
                    <?php (isset($request['user_to']) && $request['user_to'] === session_get('user_details', 'id')) ? $user_iq = $request['user_from'] : null ?>
                <?php endforeach; ?>
                <?php foreach ($friends as $friend): ?>
                    <?php (isset($friend['user_to']) && $friend['user_to'] === $user['id']) ? $friend_id = $friend['user_to'] : null ?>
                <?php endforeach; ?>

                <?php if (isset($friend_id) && $user['id'] === $friend_id) { ?>
                <td>
                    <a class="forModal" href="/usershow?<?=$user['id']?>">
                        <img alt="avatar" class="usersThumbnail" src="/public/uploads/<?=$imgName?>">
                    </a>
                </td>
                <td>
                    <a class="forModal" href="/usershow?<?=$user['id']?>">
                        <?=$user['first_name'] . ' ' . $user['last_name']?>
                    </a>
                </td>
                <?php } else { ?>
                    <td><a class="forModal"><img alt="avatar" class="usersThumbnail" src="/public/uploads/<?=$imgName?>"></a></td>
                    <td><a class="forModal"><?=$user['first_name'] . ' ' . $user['last_name']?></a></td>
                <?php } ?>
                <td class="actions">
                    <?php if (isset($user_id) && $user_id === $user['id']){ ?>
                        <button type="button" class="btn btn-secondary disabled">
                            Request sent<i class="fas fa-user-plus ml-2"></i>
                        </button>
                    <?php } else if (isset($friend_id) && $friend_id === $user['id']){ ?>
                        <button type="button" class="btn btn-info disabled">
                            Friend<i class="fas fa-user-friends ml-2"></i>
                        </button>
                    <?php } else if (isset($user_iq) && $user_iq === $user['id']) { ?>
                        <button type="button" class="btn btn-secondary addFriend userSanded" data-action="<?=$user['id']?>">
                            User sanded Request<i class="fas fa-exclamation-circle ml-2"></i>
                        </button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-success addFriend" data-action="<?=$user['id']?>">
                            Add friend<i class="fas fa-user-plus ml-2"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>