let project = {
    notiTable: $('#notifications'),

    sendFriendRequest: (user_to, button) => {
        $.ajax({
            url: '/friendrequest',
            method: "get",
            data: {to: user_to},
            success: () => {
                button.removeClass('btn-success').addClass('btn-secondary').addClass('disabled');
                button.removeAttr('data-action').html('Request sent<i class="fas fa-user-plus ml-2"></i>');
            }
        })
    },

    showNotifications: () => {
        $.ajax({
            url: '/notifications',
            method: 'get',
            success: (response) => {
                let requester = JSON.parse(response)['users'],
                    html = '';

                $.each(requester, (key, value) => {
                    html = html + '<div class="item row justify-content-between w-75 mx-auto">';
                    html = html + '<p class="col-12"><b>'+ value.first_name + ' ' + value.last_name + '</b> Want to be your friend</p>';
                    html = html + '<button class="btn btn-secondary col-5">Approve</button>';
                    html = html + '<button class="btn btn-secondary col-5">Cancel</button>';
                    html = html + '<div class="dropdown-divider"></div>';
                    html = html + '</div>';
                });

                $('#notcount').text(requester.length);
                project.notiTable.html(html);
            },
        })
    }
};

$(document).on('click', '.addFriend', (event) => {

    let button = $(event.target),
        user_to = button.attr('data-action');

    project.sendFriendRequest(user_to, button);
});

project.showNotifications();
