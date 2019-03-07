let project = {

    sendFriendRequest: (user_to, user_from) => {
        $.ajax({
            url: '/friendrequest',
            method: 'post',
            data: {from: user_from, to: user_to},
            success: (data) => {
                console.log(data);
            }
        })
    }
};
