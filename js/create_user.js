$(document).ready(() => {
    $("form[name='create_user_form']").validate({
        rules: {
            username: "required",
            password: "required",
            rpd_password: "required",
            color: "required",
            username: {
                required: true,
                minlength: 5,
                remote: {
                    url: "ajax/validations/check_user_name.php",
                    type: "post"
                }
            },
            password: {
                required: true,
                minlength: 8
            },
            rpd_password: {
                required: true,
                minlength: 3,
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: "Please enter a username!",
                minlength: "Username must be at least 5 characters long!",
                remote: "Username already in use!"
            },
            password: {
                required: "Please enter a password!",
                minlength: "Password must be at least 8 characters long!"
            },
            rpd_password: {
                required: "Please enter a password!",
                minlength: "Repeared password must be at least 8 characters long!",
                equalTo: "Password does not match with the previous one!"
            },
            color: {
                required: "Please select a favorite color!",
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});