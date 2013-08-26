var aac_moodle = function () {

    return {
        ShowHideStudents: function () {
            
            if ($("#showhideStudentsLink").text() == "view") {

                $("#showhideStudentsLink").html("hide");
                $(".aac_studentList").show();
            }
            else {
                $("#showhideStudentsLink").html("view");
                $(".aac_studentList").hide();
            }
        }
        ,
        validate_brokenform: function () {

            return aac_moodle.validate_required($("textarea[name='description']").val(), "Please enter a description.");
        },
        validate_StudentDoesNotHaveAccessForm: function () {
            return aac_moodle.validate_required($("input[name='studentName']").val(), "Please enter a student's Name.");
        },
        validate_required:function(field, alerttxt)
        {

                if (field == null || field == "")
                {
                  alert(alerttxt);
                  return false;
                }
            else
            {
                return true;
            }       
        },
        Staff_AddUser: function (userName) {
            
            $("input[name='addedUser']").val(userName);
            document.forms["form_search"].submit();
        },
        Staff_AddUserCancel: function () {
            $("#aac_staffSearch").hide();
            $("#aac_staff").show();
        },
        Staff_RemoveUser: function (userName) {
            $("input[name='removeUser']").val(userName);
            document.forms["form_search"].submit();
        }

    }


}();


$(function () {
    $("#showhideStudentsLink").click(aac_moodle.ShowHideStudents);


    $("form").submit(function () {
        if (submitted) {
            return false;
        }
        submitted = true;
        return true;
    });

});

submitted = false;