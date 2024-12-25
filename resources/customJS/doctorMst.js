function validate() {
    if ($("#txt_MedicalRegisNo").val().trim() == "") {
        $("#txt_MedicalRegisNo").val('');
    } else if ($("#txt_doctorName").val().trim() == "") {
        $("#txt_doctorName").val('');
    } else if ($("#txt_qualification").val().trim() == "") {
        $("#txt_qualification").val('');
    } else if ($("#txt_email").val().trim() == "") {
        $("#txt_email").val('');
    } else if ($("#txt_email").val().trim() != "") {
        ValidateEmail();
    } else if ($("#txt_address").val().trim() == "") {
        $("#txt_address").val('');
    } else if ($("#txt_doctorName").val().trim() == "") {
        $("#txt_doctorName").val('');
    } else if ($("#txt_doctorName").val().trim() == "") {
        $("#txt_doctorName").val('');
    }
}

function ValidateEmail()
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if ($("#txt_email").val().match(mailformat)) {       
        return true;
    }
    else {
        $("#txt_email").val('');
        return false;
    }
}

