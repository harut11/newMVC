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
                    html += '<div class="item row justify-content-between w-75 mx-auto" data-id="'+value.id+'">';
                    html += '<p class="col-12"><b>'+ value.first_name + ' ' + value.last_name + '</b> Want to be your friend</p>';
                    html += '<button type="button" class="btn btn-secondary col-5 approve">Approve</button>';
                    html += '<button type="button" class="btn btn-secondary col-5">Cancel</button>';
                    html += '<div class="dropdown-divider"></div>';
                    html += '</div>';
                });

                $('#notcount').text(requester.length);
                project.notiTable.html(html);
            },
        })
    },

    approveRequest: (user_from) => {
        $.ajax({
            url: '/friendrequest',
            method: 'get',
            data: {from: user_from, approve: 'true'},
            success: (data) => {
                console.log(data);
            }
        })
    }
};

$(document).on('click', '.addFriend', (event) => {
    let button = $(event.target),
        user_to = button.attr('data-action');

    project.sendFriendRequest(user_to, button);
});

project.showNotifications();

$(document).on('click', '.approve', (event) => {
    let button = $(event.target),
    user_from = button.closest('.item').attr('data-id');

    project.approveRequest(user_from);
});
