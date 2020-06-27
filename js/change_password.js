$(document).ready(() => {
    $("form[name='change_password_form']").validate({
        rules: {
            password: "required",
            new_password: "required",
            rpd_password: "required",
            password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8
            },
            rpd_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            }
        },
        messages: {
            password: {
                required: "Please enter a password!",
                minlength: "Password must be at least 8 characters long!"
            },
            new_password: {
                required: "Please enter a new password!",
                minlength: "Password must be at least 8 characters long!"
            },
            rpd_password: {
                required: "Please enter a password!",
                minlength: "Repeared password must be at least 8 characters long!",
                equalTo: "Password does not match with the new one!"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});