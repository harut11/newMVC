let project = {
    loginMessage: $('#login_message'),

    showLoginMessage: () => {
        let formData = new FormData();
      $.ajax({
          url: "/registersubmit",
          type: "get",
          dataType: 'json',
          success: (result) => {
             // let user = JSON.parse(result);
             console.log(result);
             // window.location.href = '/login';
          },
          error: (err) => {
              console.log(err);
          }
      })
    }
};

 $('#register').click((e) => {
     e.preventDefault();
     project.showLoginMessage();
 });