let project = {

    showAllUsers: () => {
      $.ajax({
          url: "/showusers",
          method: "get",
          success: (response) => {
              let html =
          },
      })
    }
};

project.showAllUsers();