function logOut() {
    swal({
        title: "Logged Out!",
        text: "Please login!",
        icon: "warning"
    }).then(function () {
        window.location = "../login.aspx";
    });
}

function ShowMSG_with_redirection(title, msg, type, redirectedLoc) {
    swal({
        title: title,
        text: msg,
        icon: type
    }).then(function () {
        window.location = redirectedLoc;
    });
}

function ShowMsg_withoutRedirection(title,  msg,    type) {
    swal({
        title: title,
        text: msg,
        icon: type
    });
}

function swalCustomWarningTimer(msg,id) {
    swal({ title: "Warning", text: msg, icon: "warning", timer: 3000 }).then(function () {
        $("#"+id).focus();
    });;
}

function swalCustomWarning(msg) {
    swal({ title: "Warning", text: msg, icon: "warning"});
}