let project = {
    notiTable: $('#notifications'),
    friendsTable: $('#friends'),
    notiCount: null,

    sendFriendRequest: (user_to, button) => {
        $.ajax({
            url: '/friendrequest',
            method: "get",
            data: {to: user_to, send_request: 'true'},
            success: (data) => {
                if (data === 'false') {
                    alert('This user are sanded to you friend request, Please replace it!');
                    return false;
                } else {
                    button.removeClass('btn-success').addClass('btn-secondary').addClass('disabled');
                    button.removeAttr('data-action').html('Request sent<i class="fas fa-user-plus ml-2"></i>');
                }
            }
        })
    },

    showNotifications: () => {
        $.ajax({
            url: '/notifications',
            method: 'get',
            success: (response) => {
                if (response) {
                    let requester = JSON.parse(response)['users'],
                        html = '';

                    project.notiCount = requester.length;

                    $.each(requester, (key, value) => {
                        html += '<div class="item row justify-content-between w-75 mx-auto mt-3" data-id="'+value.id+'">';
                        html += '<p class="col-12"><b>'+ value.first_name + ' ' + value.last_name + '</b> Want to be your friend</p>';
                        html += '<button type="button" class="btn btn-secondary col-5 approve">Approve</button>';
                        html += '<button type="button" class="btn btn-secondary col-5 cancel">Cancel</button>';
                        html += '<div class="dropdown-divider"></div>';
                        html += '</div>';
                    });

                    $('#notcount').text(project.notiCount);
                    project.notiTable.html(html);
                }
            },
        })
    },

    approveRequest: (user_from, item) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, approve: 'true'},
            success: (data) => {
                let user = JSON.parse(data)['newfriend'],
                    avatar = JSON.parse(data)['avatar'],
                    html = '';

                $.each(user, (key, value) => {
                    html += '<tr>';
                    html += '<td><img alt="avatar" class="usersThumbnail" src="/public/uploads/'+ avatar[0].name +'"></td>';
                    html += '<td>' + value.first_name + ' ' + value.last_name + '</td>';
                    html += '<td><button type="button" class="btn btn-danger">\n' +
                        'Delete friend<i class="fas fa-user-minus ml-2"></i></button></td>';
                    html += '</tr>';
                });

                project.notiCount -= 1;
                $('#notcount').text(project.notiCount);
                item.remove();
                project.friendsTable.append(html);

                let addButton = $('.addFriend');

                $.each(addButton, (key, value) => {
                    if (user[0].id === $(value).attr('data-action')) {
                        $(value).removeClass('btn-success').addClass('btn-info').addClass('disabled');
                        $(value).empty();
                        $(value).html('Friend<i class="fas fa-user-friends ml-2"></i>');
                        $(value).removeAttr('data-id');
                        $(value).removeClass('addFriend');
                    }
                });
            }
        })
    },

    cancelRequest: (user_from) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, cancel: 'true'},
            success: (data) => {

            }
        })
    },

    deleteFriend: (user_to, user) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {to: user_to, delete: 'true'},
            success: () => {
                user.remove();
            }
        })
    },

    imageReader: (event, div) => {
        let preview = div,
            file = event.target.files[0],
            reader = new FileReader();

        reader.addEventListener('load', () => {
            preview.attr('src', reader.result);
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
};

$(document).on('click', '.addFriend', (event) => {
    let button = $(event.target).closest('.addFriend'),
        user_to = button.attr('data-action');

    project.sendFriendRequest(user_to, button);
});

project.showNotifications();

$(document).on('click', '.approve', (event) => {
    let button = $(event.target),
    user_from = button.closest('.item').attr('data-id'),
    item = button.closest('.item');

    project.approveRequest(user_from, item);
});

$(document).on('click', '.cancel', (event) => {
    let button = $(event.target),
        user_from = button.closest('.item').attr('data-id');

    project.cancelRequest(user_from);
});

$(document).on('click', '.deleteFriend', (event) => {
    if (confirm('Are you really want to delete your friend ?')) {
        let button = $(event.target),
            user_to = button.closest('.item').attr('data-id'),
            user = button.closest('.item');

        project.deleteFriend(user_to, user);
    }
    return false;
});

document.getElementById('editAvatar').addEventListener('change', (event) => {
    project.imageReader(event, $('#forShow'));
});
