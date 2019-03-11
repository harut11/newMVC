let project = {
    notiTable: $('#notifications'),
    friendsTable: $('#friends'),
    notiCount: null,

    sendFriendRequest: (user_to, button, action_space) => {
        $.ajax({
            url: '/friendrequest',
            method: "get",
            data: {to: user_to, send_request: 'true'},
            success: (data) => {
                if (data === 'false') {
                    let html = '<button class="btn btn-secondary approveFromUsers" type="button">Approve</button>' +
                            '<button class="btn btn-secondary cancelFromUsers ml-2" type="button">Reject</button>';
                    action_space.empty();
                    action_space.append(html);

                    return false;
                } else if (data === 'sended') {
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
                        html += '<button type="button" class="btn btn-secondary col-5 cancel">Reject</button>';
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
                    html += '<td><a class="forModal" href="/usershow?'+ user[0].id +'"><img alt="avatar" ' +
                        'class="usersThumbnail" src="/public/uploads/'+ avatar[0].name +'"></a></td>';
                    html += '<td><a class="forModal" href="/usershow?'+ user[0].id +'">' + value.first_name + ' '
                        + value.last_name + '</a></td>';
                    html += '<td><button type="button" class="btn btn-danger">\n' +
                        'Delete friend<i class="fas fa-user-minus ml-2"></i></button></td>';
                    html += '</tr>';
                });

                project.notiCount -= 1;
                $('#notcount').text(project.notiCount);
                item.remove();
                project.friendsTable.append(html);

                let td = $('.actions');

                $.each(td, (key, value) => {
                    if ($(value).closest('.item').attr('data-id') === user[0].id) {
                        let html = '<button type="button" class="btn btn-info disabled">' +
                            'Friend<i class="fas fa-user-friends ml-2"></i></button>';

                        $(value).empty();
                        $(value).html(html);

                        $(value).closest('.item').find('.forModal').attr('href', '/usershow?' + user[0].id);
                    }
                });
            }
        })
    },

    approveFromAll: (user_from, item, action_space, a) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, approve: 'true'},
            success: () => {
                let items = $('#notifications .item');

                $.each(items, (key, value) => {
                    if ($(value).attr('data-id') === item.attr('data-id')) {
                        $(value).remove();
                    }
                });


                project.notiCount -= 1;
                $('#notcount').text(project.notiCount);

                action_space.empty();

                let html = '<button type="button" class="btn btn-info disabled">Friend' +
                                '<i class="fas fa-user-friends ml-2"></i></button>';

                a.attr('href', '/usershow?' + user_from);

                action_space.html(html);
            }
        })
    },

    cancelFromAll: (user_from, item, action_space) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, cancel: 'true'},
            success: () => {
                let items = $('#notifications .item'),
                    html = '<button type="button" class="btn btn-success addFriend" data-action="'+ item.attr('data-id')
                        +'">' + 'Add friend <i class="fas fa-user-plus ml-2"></i></button>';

                $.each(items, (key, value) => {
                    if ($(value).attr('data-id') === item.attr('data-id')) {
                        $(value).remove();
                    }
                });

                project.notiCount -= 1;
                $('#notcount').text(project.notiCount);

                action_space.empty();
                action_space.html(html);
            }
        })
    },

    cancelRequest: (user_from, item) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, cancel: 'true'},
            success: () => {
                item.remove();
                project.notiCount -= 1;
                $('#notcount').text(project.notiCount);

                let td = $('.actions');

                $.each(td, (key, value) => {
                    if ($(value).closest('.item').attr('data-id') === user_from) {
                        let html = '<button type="button" class="btn btn-success addFriend" data-action="'+user_from+'">' +
                            'Add friend<i class="fas fa-user-plus ml-2"></i></button>';

                        $(value).empty();
                        $(value).html(html);
                    }
                });
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
        user_to = button.attr('data-action'),
        action_space = $(event.target).closest('td');

    project.sendFriendRequest(user_to, button, action_space);
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
        user_from = button.closest('.item').attr('data-id'),
        item = button.closest('.item');

    project.cancelRequest(user_from, item);
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

$(document).on('click', '.approveFromUsers', (event) => {
    let button = $(event.target),
        user_from = button.closest('.item').attr('data-id'),
        item = button.closest('.item'),
        action_space = button.closest('td'),
        a = button.closest('.item').find('.forModal');

    project.approveFromAll(user_from, item, action_space, a);
});

$(document).on('click', '.cancelFromUsers', (event) => {
    let button = $(event.target),
        user_from = button.closest('.item').attr('data-id'),
        item = button.closest('.item'),
        action_space = button.closest('td');

    project.cancelFromAll(user_from, item, action_space);
});

let editAvatar = document.getElementById('editAvatar');

if (editAvatar) {
    editAvatar.addEventListener('change', (event) => {
        project.imageReader(event, $('#forShow'));
    });
}
