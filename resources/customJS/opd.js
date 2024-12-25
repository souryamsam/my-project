
var JbaseContent = {};
var DocDetails = [];
$(document).ready(function () {
    $("#tbody_indian").hide();
    $("#tbody_Nonindian").hide();
   

    if ($("#hdnDetails").val() != "") {
        JbaseContent = JSON.parse($("#hdnDetails").val());
    }
    $("#ddl_nationality").change(function () {
        Doc = {}; 
        $("#tbody_Nonindian").html('');
        $("#tbody_indian").html('');
        var htmlBind = [];
        var tabIndex = 30;
        if ($("#ddl_nationality option:selected").val() != "") {
            if ($("#ddl_nationality option:selected").text() == "Indian") {
                htmlBind = bindHtmlDocs("1", $("#ddl_nationality option:selected").text(), tabIndex);
                $("#tbody_indian").html(htmlBind.join('')).show();
                bindDoctype("ddl_" + $("#ddl_nationality option:selected").text() + "1");
                $("#spnReqEmail").hide();
            } else {
                for (var i = 1; i <= 2; i++) {
                    htmlBind += bindHtmlDocs(i.toString(), "Non_Indian", tabIndex);
                    tabIndex = tabIndex+6
                }
                $("#tbody_Nonindian").html(htmlBind).show();
                bindDoctype("ddl_Non_Indian1");
                bindDoctype("ddl_Non_Indian2");
                bindDocDetailsAsperdb("Non_Indian");
                $("#spnReqEmail").show();
            }

            $('.datepicker').datepicker({
                autoclose: true,
                dateFormat: 'dd-mm-yy'
            }).attr("readonly", "readonly");
            $('select').select2();
            
            $("#txt_contactNo").focus();

        } else {
            swal({
                    title: "Warning!",
                    text: "Please choose Nationality.",
                    icon: "warning"
            });
        }
    });

    $("#btnCapture").click(function () {
        $("#lnk_reload").show();
        $("#img_capture").show();
        $("#btnCapture").hide();
        $("#video").hide();
        const canvas = document.createElement("canvas");
        // scale the canvas accordingly
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        // draw the video at that frame
        canvas.getContext('2d')
            .drawImage(video, 0, 0, canvas.width, canvas.height);
        // convert it to a usable data URL
        const dataURL = canvas.toDataURL();
        const img_capture = document.getElementById("img_capture");
        img_capture.src = dataURL;

        try {
            $.ajax({
                type: "POST",
                async: false,
                url: "opd-registration.aspx/CapturePatientImage",
                data: JSON.stringify({ imageData: dataURL }),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    //$("#lnk_reload").show();
                    //$("#img_capture").show();
                    //$("#btnCapture").hide();


                    if (response.d == "1") {
                        $("#lnk_reload").show();
                        $("#img_capture").show();
                        $("#btnCapture").hide();
                        $("#video").hide();
                    } else {
                        $("#lnk_reload").hide();
                        $("#img_capture").hide();
                        $("#btnCapture").show();
                        $("#video").show();
                    }
                },
                failure: function (response) {
                    alert(response.d);
                }
            });
        } catch (error) {
            console.error('Error while uploading image:', error);
        }
    });

    $("#ddl_persntCountry").change(function () {
        var htl = [];
        $("#ddl_PersntState").html('');

        var Doc1 = $.grep(JbaseContent.StateList, function (i) {
            return i.Parent_ID === $("#ddl_persntCountry option:selected").val();
        });
        $("#ddl_PersntState").append("<option value=''>-- Select --</option>");
        $.each(Doc1, function (key, val) {
            $("#ddl_PersntState").append("<option value='" + val["RecordID"] + "'>" + val["RecordName"] + "</option>");
        });

    });

    $("#ddl_PermaCountry").change(function () {
        var htl = [];
        $("#ddl_PermaState").html('');

        var Doc1 = $.grep(JbaseContent.StateList, function (i) {
            return i.Parent_ID === $("#ddl_PermaCountry option:selected").val();
        });
        $("#ddl_PermaState").append("<option value=''>-- Select --</option>");
        $.each(Doc1, function (key, val) {
            $("#ddl_PermaState").append("<option value='" + val["RecordID"] + "'>" + val["RecordName"] + "</option>");
        });
    });

    $("#chksame").change(function () {
        if ($("#chksame").is(':checked')) {
            $("#txt_PermaAddress").val($("#txt_PersntAddress").val());
            $("#txt_PermaPoliceSt").val($("#txt_PersntPoliceSt").val());
            $("#txt_PermaCityDist").val($("#txt_PersntCityDistrict").val());
            if ($("#ddl_PermaCountry option:selected").val() == "IN") {
                $("#ddl_PermaCountry").val($("#ddl_persntCountry").val()).change();
                $("#ddl_PermaState").val($("#ddl_PersntState").val()).change();
            } else {
                var htl = [];
                $("#ddl_PermaState").html('');

                var Doc1 = $.grep(JbaseContent.StateList, function (i) {
                    return i.Parent_ID === $("#ddl_persntCountry option:selected").val();
                });
                $("#ddl_PermaState").append("<option value=''>-- Select --</option>");
                $.each(Doc1, function (key, val) {
                    $("#ddl_PermaState").append("<option value='" + val["RecordID"] + "'>" + val["RecordName"] + "</option>");
                });

                $("#ddl_PermaCountry").val($("#ddl_persntCountry").val()).change();
                $("#ddl_PermaState").val($("#ddl_PersntState").val()).change();
            }
           
            $("#txt_PermaZipcode").val($("#txt_PersntZipcode").val());
        } else {
            $("#txt_PermaAddress").val('');
            $("#txt_PermaPoliceSt").val('');
            $("#txt_PermaCityDist").val('');
            $("#ddl_PermaCountry").val('').change();
            $("#ddl_PermaState").val('').change();
            $("#txt_PermaZipcode").val('');
        }
    });

    $("#chk_HazraRegNo").change(function () {
        if ($("#chk_HazraRegNo").is(":checked")) {
            $("#txt_HazraRegNo").val('').removeAttr("readonly");
        } else {
            $("#txt_HazraRegNo").val('').prop("readonly", "readonly");
        }
    });

    $("#ddl_patientCategory").change(function () {
        var Doc1 = $.grep(JbaseContent.PCateList, function (i) {
            return i.RecordID === $("#ddl_patientCategory option:selected").val();
        });

        if (Doc1.length > 0) {
            if ($.isNumeric(Doc1[0].Rate)) {
                $("#spn_regisFee").text(Doc1[0].Rate);
            } else {
                swalCustomWarning("Registration charge not set");
            }
        } 
        
    });

    $("#txtDob").change(function () {
        if ($("#txtDob").val() != "") {
            $.ajax({
                type: "POST",
                async: false,
                url: "opd-registration.aspx/dobCheck",
                data: JSON.stringify({data:$("#txtDob").val()}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var ret = JSON.parse(response.d);
                    console.log(JSON.stringify(ret, 3, 3));
                    if (ret.stat == "1") {
                        $("#txt_year").val(ret.year);
                        $("#txt_month").val(ret.month);
                        $("#txt_day").val(ret.day);
                        $("#txt_email").focus();
                    } else {
                        $("#txtDob").val('');
                        swalCustomWarning(ret.msg);
                        $("#txtDob").focus();
                    }
                },
                failure: function (response) {
                    alert(response.d);
                }
            });
        }
    });
});

function bindHtmlDocs(id, type, tabIndex) {
    var html = [];
   
    var contentID = type + id;
    html.push("<tr><td><select id='ddl_" + contentID + "' class='form-control input-sm' tabindex='" + tabIndex +"'></select></td>");
    html.push("<td><input id='inp_DocNo" + contentID + "' type='text' class='form-control input-sm'  tabindex='" + tabIndex +"'/><span id='spn_DocNo" + contentID + "' class='control-label' style='display:none;'></span></td>");
    html.push("<td><input id='inp_Issue" + contentID + "' type='text' class='form-control input-sm datepicker' tabindex='" + tabIndex + "' style='display:none;' /><span id='spn_Issue" + contentID + "' class='control-label' style='display:none;'></span></td>");
    html.push("<td><input id='inp_End" + contentID + "' type='text' class='form-control input-sm datepicker' tabindex='" + tabIndex + "' style='display:none;' /><span id='spn_End" + contentID + "' class='control-label' style='display:none;'></span></td>");
    html.push("<td><input id='inp_Exp" + contentID + "' type='text' class='form-control input-sm datepicker' tabindex='" + tabIndex +"' style='display:none;' /><span id='spn_Exp" + contentID + "' class='control-label' style='display:none;'></span></td>");
    html.push("<td><input id='inp_file" + contentID + "' type='file' class='form-control input-sm' tabindex='" + tabIndex +"' /><button id='btn_file" + contentID + "' type='button' class='btn btn-sm btn-info btn-xs' style='display:none;' onclick='show_doc(\"" + contentID + "\",\"" + id + "\")'><i class='fa fa-eye'></i></button></td>");
    html.push("<td><button id='btn_docSave" + contentID + "' type='button' class='btn btn-sm btn-success btn-xs' tabindex='" + tabIndex +"' onclick='saveDoc_details(\"" + contentID + "\",\"" + id + "\",\"" + type + "\")'><i class='fa fa-save'></i></button>");
    html.push("<button id='btn_docEdit" + contentID + "' type='button' class='btn btn-sm btn-info btn-xs' style='display:none;' onclick='editDoc_details(\"" + contentID + "\",\"" + id + "\",\"" + type + "\")'><i class='fa fa-edit'></i></button><span id='spn_existingFile" + contentID +"' style='display:none;'></span></td></tr>")
    return html;
}

function bindDoctype(contrlID) {
    $("#" + contrlID).html('');
    $.each(JbaseContent.DocList, function (key, val) {
        $("#" + contrlID).append("<option value='" + val["RecordID"] + "'>" + val["RecordName"] + "</option>");
    });
}

function bindDocDetailsAsperdb(type) {
   
        var Doc1 = $.grep(JbaseContent.DocList, function (i) {
            return i.ForIndian_nonIndian === type;
        });

    var i = 1;
    $.each(Doc1, function (key, val1) {
        $("#ddl_" + type + i.toString()).val(val1["RecordID"]).change().prop("disabled","disabled");
        if (val1["IssueDate"] != "") {
            if (val1["IssueDate"] == "ISSUE_DATE") {
                $("#inp_Issue" + type + i.toString()).show();
                $("#inp_End" + type + i.toString()).show();
            }
        }

        if (val1["Exp_Date"] != "") {
            if (val1["Exp_Date"] == "EXP_DATE") {
                $("#inp_Exp" + type + i.toString()).show();
            }
        }

        i++;
    });
}

function saveDoc_details(contrlID,id,type) {
    if ($("#ddl_" + contrlID).val() != "") {
        if ($("#inp_DocNo" + contrlID).val().trim() != "") {
            var flag = false;
            if (type == "Non_Indian") {
                if ($("#inp_Issue" + contrlID).val() != "") {
                    if ($("#inp_End" + contrlID).val() != "") {
                        if ($("#inp_Exp" + contrlID).val() != "") {
                            flag = true;
                        } else {
                            swal("Warning!", "Please enter choose expire date!", "warning");
                        }
                    } else {
                        swal("Warning!", "Please enter choose end date!", "warning");
                    }
                } else {
                    swal("Warning!", "Please enter choose issue date!", "warning");
                }
            } else {
                flag = true;
            }

            if (flag) {
                if ($("#inp_file" + contrlID).val() != "") {
                    var fileName = generate();
                    var formData = new FormData();
                    formData.append("existing", $("#spn_existingFile" + contrlID).text())
                    formData.append("fileName", fileName);
                    formData.append("file", $("#inp_file" + contrlID)[0].files[0]);

                    $.ajax({
                        url: '../hpims.asmx/UploadFiles',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (fileName) {
                            swal("Success!", "File uploaded successfully!", "success");

                            if (DocDetails.length > 0) {
                                DocDetails = $.grep(DocDetails, function (i) {
                                    return i.docType != $("#ddl_" + contrlID).val();
                                });
                            }
                            Doc = {}; 
                          
                            Doc.rowNo = id;
                            if ($("#ddl_nationality option:selected").text() == "Indian") {
                                Doc.Nationtype = "Indian";
                            } else {
                                Doc.Nationtype = "Non_Indian";
                            }
                            var Doc1 = $.grep(JbaseContent.DocList, function (i) {
                                return i.RecordID === $("#ddl_" + contrlID+" option:selected").val();
                            });
                            Doc.docType = $("#ddl_" + contrlID).val();
                            Doc.docTypeName = Doc1[0].RecordName;
                            Doc.docNo = $("#inp_DocNo" + contrlID).val();
                            Doc.IssueDate = $("#inp_Issue" + contrlID).val();
                            Doc.EndDate = $("#inp_End" + contrlID).val();
                            Doc.Exp_Date = $("#inp_Exp" + contrlID).val();
                            Doc.tempFilename = fileName;
                            Doc.ActFilename = $("#inp_file" + contrlID).val();
                            DocDetails.push(Doc);
                            $("#spn_existingFile" + contrlID).text('');
                            dataShowInViewMode(contrlID, id);
                            
                            
                        },
                    });
                } else {
                    swal("Warning!", "Please choose document!", "warning");
                }
            }
        } else {
            swal("Warning!", "Please enter proper document no!", "warning");
        }
    } else {
        swal("Warning!", "Please choose document type!", "warning");
    }
}

function generate() {
    let id = () => {
        return Math.floor((1 + Math.random()) * 0x100000)
            .toString(16)
            .substring(1);
    }
    return id();
}

function dataShowInViewMode(contrlID, srno) {
    var Doc1 = $.grep(DocDetails, function (i) {
        return i.rowNo === srno;
    });
    console.log(JSON.stringify(Doc1, 3, 3));
    $.each(Doc1, function (key, val) {
        if (val["Nationtype"] == "Indian") {
            $("#ddl_" + contrlID).prop("disabled", "disabled");
        }
        $("#spn_DocNo" + contrlID).text(val["docNo"]).show();
        $("#inp_DocNo" + contrlID).val('').hide();
        if (val["Nationtype"] != "Indian") {
            $("#spn_Issue" + contrlID).show().text(val["IssueDate"]);
            $("#inp_Issue" + contrlID).val('').hide();

            $("#spn_End" + contrlID).show().text(val["EndDate"]);
            $("#inp_End" + contrlID).val('').hide();

            $("#spn_Exp" + contrlID).show().text(val["Exp_Date"]);
            $("#inp_Exp" + contrlID).val('').hide();
        }

        $("#inp_file" + contrlID).val('').hide();
        $("#btn_file" + contrlID).show();  //btn_docEdit

        $("#btn_docSave" + contrlID).hide(); 
        $("#btn_docEdit" + contrlID).show(); 
    });
   
   
}

function show_doc(ctrlID, id) {
    var Doc1 = $.grep(DocDetails, function (i) {
        return i.rowNo === id;
    });
    var src = "";
    var fileName = "";
    $.each(Doc1, function (key, val) {
        fileName = val["tempFilename"];
    });
    if ($("#hdnPatientCode").val() != "") {

    } else {
        src = "../UploadedImages/tempDocs/" + fileName;
    }
    $("#docView").modal("show");
    $("#Docview_iframe").prop("src", src);

}

function editDoc_details(contrlID, id, type) {
    var Doc1 = $.grep(DocDetails, function (i) {
        return i.rowNo === id;
    });
    //console.log(JSON.stringify(Doc1, 3, 3));
    $.each(Doc1, function (key, val) {
        if (val["Nationtype"] == "Indian") {
            $("#ddl_" + contrlID).prop("disabled", "");
        }
        $("#spn_DocNo" + contrlID).text('').hide();
        $("#inp_DocNo" + contrlID).val(val["docNo"]).show();
        if (val["Nationtype"] != "Indian") {
            $("#spn_Issue" + contrlID).hide().text('');
            $("#inp_Issue" + contrlID).val(val["IssueDate"]).show();

            $("#spn_End" + contrlID).hide().text('');
            $("#inp_End" + contrlID).val(val["EndDate"]).show();

            $("#spn_Exp" + contrlID).hide().text('');
            $("#inp_Exp" + contrlID).val(val["Exp_Date"]).show();
        }

        $("#inp_file" + contrlID).val('').show();
        $("#btn_file" + contrlID).hide();  //btn_docEdit

        $("#btn_docSave" + contrlID).show();
        $("#btn_docEdit" + contrlID).hide();
        $("#spn_existingFile" + contrlID).text(val["tempFilename"]);
    });
}

function snapImageReload() {
    $.ajax({
        type: "POST",
        async: false,
        url: "opd-registration.aspx/spanReload",
        data: JSON.stringify({}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            $("#btnCapture").show();
            $("#video").show();
            $("#lnk_reload").hide();
            $("#img_capture").hide();
        },
        failure: function (response) {
            alert(response.d);
        }
    });
}

function validation() {
    if ($("#txt_patientName").val().trim() == "") {
        swalCustomWarningTimer("Please enter Patient Name.","txt_patientName");
        $("#txt_patientName").val('');
        return false;
    } else if ($("#txt_contactNo").val().trim() == "") {
        swalCustomWarningTimer("Please enter Contact No.", "txt_contactNo");
        $("#txt_contactNo").val('');
        return false;
    } else if ($("#txt_contactNo").val().trim() != "" && $("#txt_contactNo").val().trim().length!=10) {
        swalCustomWarningTimer("Please enter valid Contact No.", "txt_contactNo");
        $("#txt_contactNo").val('');
        return false;
    } else if ($("#ddl_religion option:selected").val() == "") {
        swalCustomWarningTimer("Please enter Religion.","ddl_religion");
        return false;
    } else if ($("#ddl_caste option:selected").val() == "") {
        swalCustomWarningTimer("Please enter Caste.","ddl_caste");
        return false;
    } else if ($("#ddl_nationality option:selected").val() == "") {
        swalCustomWarningTimer("Please enter Nationality.","ddl_nationality");
        return false;
    } else if ($("#txt_PersntAddress").val().trim() == "") {
        swalCustomWarningTimer("Please enter Present Address.","txt_PersntAddress");
        $("#txt_PersntAddress").val('');
        return false;
    } else if ($("#txt_PersntPoliceSt").val().trim() == "") {
        swalCustomWarningTimer("Please enter Present Police Station.","txt_PersntPoliceSt");
        $("#txt_PersntPoliceSt").val('');
        return false;
    } else if ($("#txt_PersntCityDistrict").val().trim() == "") {
        swalCustomWarningTimer("Please enter Present City/District.","txt_PersntCityDistrict");
        $("#txt_PersntCityDistrict").val('');
        return false;
    } else if ($("#txt_PersntZipcode").val().trim() == "") {
        swalCustomWarningTimer("Please enter Present Pin Code.","txt_PersntZipcode");
        $("#txt_PersntZipcode").val('');
        return false;
    } else if ($("#txt_PermaAddress").val().trim() == "") {
        swalCustomWarningTimer("Please enter Present Address.","txt_PermaAddress");
        $("#txt_PermaAddress").val('');
        return false;
    } else if ($("#txt_PermaPoliceSt").val().trim() == "") {
        swalCustomWarningTimer("Please enter Permanent Police Station.","txt_PermaPoliceSt");
        $("#txt_PermaPoliceSt").val('');
        return false;
    } else if ($("#txt_PermaCityDist").val().trim() == "") {
        swalCustomWarningTimer("Please enter Permanent City/District.","txt_PermaCityDist");
        $("#txt_PermaCityDist").val('');
        return false;
    } else if ($("#txt_PermaZipcode").val().trim() == "") {
        swalCustomWarningTimer("Please enter Permanent Pin Code.","txt_PermaZipcode");
        $("#txt_PermaZipcode").val('');
        return false;
    } else if ($("#txt_relativeName1").val().trim() == "") {
        swalCustomWarningTimer("Please enter Relative 1 Name.","txt_relativeName1");
        $("#txt_relativeName1").val('');
        return false;
    } else if ($("#ddl_relative_relation1").val().trim() == "") {
        swalCustomWarningTimer("Please enter Relative 1 Relationship.", "ddl_relative_relation1");
        return false;
    }
    //else if ($("#txt_StdCode1").val().trim() == "") {
    //    swalCustomWarningTimer("Please enter Relative 1 STD Code.","txt_StdCode1");
    //    $("#txt_StdCode1").val('');
    //    return false;
    //}
    else if ($("#txt_relativeContact1").val().trim() == "") {
        swalCustomWarningTimer("Please enter relative 1 contact no.","txt_relativeContact1");
        $("#txt_relativeContact1").val('');
        return false;
    } 
    return true;
}

function ValidateEmail() {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if ($("#txt_email").val().match(mailformat)) {
        return true;
    }
    else {
        $("#txt_email").val('');
        return false;
    }
}

function saveOPDdetails(e) {
    var flag = false;
    if (validation()) {
        flag = true;
        if ($("#chk_HazraRegNo").is(":checked")) {
            if ($("#txt_HazraRegNo").val() == "") {
                flag = false;
                swal({
                    title: "Warning!",
                    text: "Please enter Hazra Registration No.",
                    icon: "warning"
                });
            }
        }

        if ($("#ddl_nationality option:selected").val() != "") {
            if ($("#ddl_nationality option:selected").text() == "Indian") {
                if (DocDetails.length == 0) {
                    flag = false;
                    swal({
                        title: "Warning!",
                        text: "Please enter Document details.",
                        icon: "warning"
                    });
                }
            } else {
                if (DocDetails.length < 2) {
                    flag = false;
                    swal({
                        title: "Warning!",
                        text: "Please enter Document details.",
                        icon: "warning"
                    });
                }

                if ($("#txt_email").val().trim() != "") {
                    ValidateEmail()
                }

                if ($("#txt_email").val().trim() == "") {
                    flag = false;
                    swal({
                        title: "Warning!",
                        text: "Please enter Email address.",
                        icon: "warning"
                    });
                }

              
            }
        } else {
            flag = false;
            swal({
                title: "Warning!",
                text: "Please enter Document details.",
                icon: "warning"
            });
        }

        if ($("#spn_regisFee").text() == "") {
            flag = false;
            swal({
                title: "Warning!",
                text: "Registration amount not given.",
                icon: "warning"
            });
        }
        
    }

   
    if (flag) {
        console.log(1);
        var opdData = {};
        opdData._uhid = "";
        opdData._patientCode = "";
        if ($("#chk_HazraRegNo").is(":checked")) {
            opdData._hazraRegno = $("#txt_HazraRegNo").val();
        } else {
            opdData._hazraRegno = "";
        }
        opdData._oldRegno = $("#txt_OldRegNo").val().trim();

        var basicInfo = {};
        basicInfo._patientSal = $("#ddl_Pationsalutaion").val().trim();
        basicInfo._patientName = $("#txt_patientName").val().trim();
        basicInfo._religion = $("#ddl_religion option:selected").val();
        basicInfo._caste = $("#ddl_caste option:selected").val();
        basicInfo._nationality = $("#ddl_nationality option:selected").val();

        if ($("#txtDob").val() != "") {
            basicInfo._dob = $("#txtDob").val();
        }
        if ($("#txt_year").val().trim() != "") {
            basicInfo._ageYY = $("#txt_year").val().trim();
        } else {
            basicInfo._ageYY = "0";
        }

        if ($("#txt_month").val().trim() != "") {
            basicInfo._ageMM = $("#txt_month").val().trim();
        } else {
            basicInfo._ageMM = "0";
        }

        if ($("#txt_day").val().trim() != "") {
            basicInfo._ageDD = $("#txt_day").val().trim();
        } else {
            basicInfo._ageDD = "0";
        }
        
        basicInfo._email = $("#txt_email").val().trim();
        basicInfo._gender = $("#ddl_gender option:selected").val().trim();
        basicInfo._occupation = $("#txt_occupation").val().trim();
        opdData._ptBasic = basicInfo;

        
        opdData._contactNo = $("#txt_contactNo").val().trim();

        var presentAdd = {};
        presentAdd._prstAdd = $("#txt_PersntAddress").val().trim();
        presentAdd._prstPS = $("#txt_PersntPoliceSt").val().trim();
        presentAdd._prstCity = $("#txt_PersntCityDistrict").val().trim();
        presentAdd._prstCountry = $("#ddl_persntCountry option:selected").val().trim();
        presentAdd._prstState = $("#ddl_PersntState option:selected").val().trim();
        presentAdd._prstPin = $("#txt_PersntZipcode").val().trim();
        opdData._prstAddDetails = presentAdd;

        var permanentAdd = {};
        permanentAdd._permaAdd = $("#txt_PermaAddress").val().trim();
        permanentAdd._permaPS = $("#txt_PermaPoliceSt").val().trim();
        permanentAdd._permaCity = $("#txt_PermaCityDist").val().trim();
        permanentAdd._permaCountry = $("#ddl_PermaCountry option:selected").val().trim();
        permanentAdd._permaState = $("#ddl_PermaState option:selected").val().trim();
        permanentAdd._permaPin = $("#txt_PermaZipcode").val().trim();
        opdData._permaAddDetails = permanentAdd;

        var relation1 = {};
        relation1._rel1Sal = $("#ddl_relativeSal1 option:selected").val().trim();
        relation1._rel1Name = $("#txt_relativeName1").val().trim();
        relation1._rel1Relationship = $("#ddl_relative_relation1 option:selected").val().trim();
        relation1._rel1Stdcode = $("#txt_StdCode1").val().trim();
        relation1._rel1ContactNo = $("#txt_relativeContact1").val().trim();
        opdData._rel1Details = relation1;

        var relation2 = {};
        relation2._rel2Sal = $("#ddl_relativeSal2 option:selected").val().trim();
        relation2._rel2Name = $("#txt_relativeName2").val().trim();
        relation2._rel2Relationship = $("#ddl_relative_relation2 option:selected").val().trim();
        relation2._rel2Stdcode = $("#txt_StdCode2").val().trim();
        relation2._rel2ContactNo = $("#txt_relativeContact2").val().trim();
        opdData._rel2Details = relation2;

        opdData._category = $("#ddl_patientCategory option:selected").val().trim();
        opdData._dept = $("#ddl_dept option:selected").val().trim();
        opdData._regisAmt = $("#spn_regisFee").text().trim();
        console.log(2);
        var _doc = [];
        $.each(DocDetails, function (k, v) {
            var _obj = {};
           
            _obj._docTypeID = v["docType"];
            _obj._docTypeName = v["docTypeName"];
            _obj._docNo = v["docNo"];
            _obj._issueDate = v["IssueDate"];
            _obj._endDate = v["EndDate"];                            
            _obj._expDate = v["Exp_Date"];
            _obj._tempFilename = v["tempFilename"];
            _obj._actualFilename = v["ActFilename"];
            _doc.push(_obj);
        });
        opdData._documentList = _doc;

        $.ajax({
            type: "POST",
            async: false,
            url: "opd-registration.aspx/opdSave",
            data: JSON.stringify({ obj: opdData }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var ret = JSON.parse(response.d);
                alert(ret.msg);
                //console.log(JSON.stringify(ret, 3, 3));
                //if (ret.stat == "1") {
                //    $("#txt_year").val(ret.year);
                //    $("#txt_month").val(ret.month);
                //    $("#txt_day").val(ret.day);
                //} else {
                //    $("#txtDob").val('');
                //    swalCustomWarning(ret.msg);
                //}
            },
            failure: function (response) {
                alert(response.d);
            }
        });
    } else {
        //alert(2);
    }
}

