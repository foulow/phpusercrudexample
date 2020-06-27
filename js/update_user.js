$(document).ready(() => {
    $("form[name='update_user_form']").validate({
        rules: {
            username: "required",
            color: "required",
            username: {
                required: true,
                minlength: 5,
                remote: {
                    url: "ajax/validations/check_user_name.php",
                    type: "post",
                    data: {
                        username: function(){
                            return $("#username").val();
                        },
                        currentusername: function(){
                            return $("#currentusername").val();
                        }
                    } 
                }
            }
        },
        messages: {
            username: {
                required: "Please enter a username!",
                minlength: "Username must be at least 5 characters long!",
                remote: "Username already in use!"
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