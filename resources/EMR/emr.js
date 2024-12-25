let thecomborbidity_note_edt;
let thetreatment_history_edt;
let thepast_history_notes_edt;
let theknown_allergies_edt;
let thefamilyplan_measures_edt;
let thedevices_note_edt;
let theclinical_staging_edt;
let thedoctor_advice_edt;
let theplan_of_treatment_edt;
let theadvice_on_admission_edt;
let thepr_text_edt;
let theproctoscopy_edt;
let thehaed_neck_edt;
let theper_speculum_edt;
let thepv_text_edt;
let thethorax_edt;
let thebreast_thorax_edt;
let theabdomen_edt;
let thepelvis_edt;
let thegenitalia_edt;
let theextremities_edt;
let theadditional_notes_edt;

BalloonEditor
    .create(document.querySelector('#comborbidity_note_edt'), {})
    .then(comborbidity_note_editor => {
        thecomborbidity_note_edt = comborbidity_note_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#treatment_history_edt'), {})
    .then(treatment_history_editor => {
        thetreatment_history_edt = treatment_history_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#past_history_notes_edt'), {})
    .then(past_history_notes_editor => {
        thepast_history_notes_edt = past_history_notes_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#known_allergies_edt'), {})
    .then(known_allergies_editor => {
        theknown_allergies_edt = known_allergies_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#familyplan_measures_edt'), {})
    .then(familyplan_measures_editor => {
        thefamilyplan_measures_edt = familyplan_measures_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#devices_note_edt'), {})
    .then(devices_note_editor => {
        thedevices_note_edt = devices_note_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#clinical_staging_edt'), {})
    .then(clinical_staging_editor => {
        theclinical_staging_edt = clinical_staging_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#doctor_advice_edt'), {})
    .then(doctor_advice_editor => {
        thedoctor_advice_edt = doctor_advice_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#plan_of_treatment_edt'), {})
    .then(plan_of_treatment_editor => {
        theplan_of_treatment_edt = plan_of_treatment_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#advice_on_admission_edt'), {})
    .then(advice_on_admission_editor => {
        theadvice_on_admission_edt = advice_on_admission_editor;
    })
    .catch(error => {});
BalloonEditor
    .create(document.querySelector('#pr_text_edt'), {})
    .then(pr_text_editor => {
        thepr_text_edt = pr_text_editor;
    })
    .catch(error => {});


BalloonEditor
    .create(document.querySelector('#proctoscopy_edt'), {})
    .then(proctoscopy_editor => {
        theproctoscopy_edt = proctoscopy_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#haed_neck_edt'), {})
    .then(haed_neck_editor => {
        thehaed_neck_edt = haed_neck_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#per_speculum_edt'), {})
    .then(per_speculum_editor => {
        theper_speculum_edt = per_speculum_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#pv_text_edt'), {})
    .then(pv_text_editor => {
        thepv_text_edt = pv_text_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#thorax_edt'), {})
    .then(thorax_editor => {
        thethorax_edt = thorax_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#breast_thorax_edt'), {})
    .then(breast_thorax_editor => {
        thebreast_thorax_edt = breast_thorax_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#abdomen_edt'), {})
    .then(abdomen_editor => {
        theabdomen_edt = abdomen_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#pelvis_edt'), {})
    .then(pelvis_editor => {
        thepelvis_edt = pelvis_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#genitalia_edt'), {})
    .then(genitalia_editor => {
        thegenitalia_edt = genitalia_editor;
    })
    .catch(error => {});


BalloonEditor
    .create(document.querySelector('#extremities_edt'), {})
    .then(extremities_editor => {
        theextremities_edt = extremities_editor;
    })
    .catch(error => {});

BalloonEditor
    .create(document.querySelector('#additional_notes_edt'), {})
    .then(additional_notes_editor => {
        theadditional_notes_edt = additional_notes_editor;
    })
    .catch(error => {});
$(function() {
    'use strict';
    $('[data-toggle="push-menu"]').pushMenu('toggle');

    $("#parity").click(function() {
        if ($("#parity").is(":checked")) {
            $("#parity_gravida").prop("disabled", false);
            $("#parity").val('parity_yes');
        } else if ($("#gravida").is(":checked")) {
            $("#parity_gravida").prop("disabled", false);
            $("#gravida").val('gravida_yes');
        } else {
            $("#parity_gravida").prop("disabled", true);
            $("#parity").val('parity_no');
            $("#gravida").val('gravida_no');
        }
    })

    $("#gravida").click(function() {
        if ($("#gravida").is(":checked")) {
            $("#parity_gravida").prop("disabled", false);
            $("#gravida").val('gravida_yes');
        } else if ($("#parity").is(":checked")) {
            $("#parity_gravida").prop("disabled", false);
            $("#parity").val('parity_yes');
        } else {
            $("#parity_gravida").prop("disabled", true);
            $("#parity").val('parity_no');
            $("#gravida").val('gravida_no');
        }
    })

    $("#miscarriages").click(function() {
        if ($("#miscarriages").is(":checked")) {
            $("#miscarriages_details").prop("disabled", false);
            $("#miscarriages").val('miscarriages_yes');
        } else {
            $("#miscarriages_details").prop("disabled", true);
            $("#miscarriages").val('miscarriages_no');
        }
    })

    $("#abortion").click(function() {
        if ($("#abortion").is(":checked")) {
            $("#abortion_details").prop("disabled", false);
            $("#abortion").val('abortion_yes');
        } else {
            $("#abortion_details").prop("disabled", true);
            $("#abortion").val('abortion_no');

        }
    })

    $("#cycle_details").click(function() {
        if ($("#cycle_details").is(":checked")) {
            $("#cycle_details_area").prop("disabled", false);
            $("#cycle_details").val('cycle_details_yes');
        } else {
            $("#cycle_details_area").prop("disabled", true);
            $("#cycle_details").val('cycle_details_no');
        }
    })

    $("#feeding").click(function() {
        if ($("#feeding").is(":checked")) {
            $("#feeding_details").prop("disabled", false);
            $("#feeding").val('feeding_yes');
        } else {
            $("#feeding_details").prop("disabled", true);
            $("#feeding").val('feeding_no');
        }
    })

    $("#pallor").click(function() {
        if ($("#pallor").is(":checked")) {
            $("#pallor_details").prop("disabled", false);
            //$("#pallor_text").prop("required",true);
            $("#pallor").val('pallor_yes');
        } else {
            $("#pallor_details").prop("disabled", true);
            //$("#pallor_text").prop("required",false);
            $("#pallor").val('pallor_no');
        }
    })

    $("#icterus").click(function() {
        if ($("#icterus").is(":checked")) {
            $("#icterus_details").prop("disabled", false);
            $("#icterus").val('icterus_yes');
            //$("#icterus_text").prop("required",true);
        } else {
            $("#icterus_details").prop("disabled", true);
            $("#icterus").val('icterus_no');
            //$("#icterus_text").prop("required",false);
        }
    })

    $("#clubbing").click(function() {
        if ($("#clubbing").is(":checked")) {
            $("#clubbing_details").prop("disabled", false);
            $("#clubbing").val('clubbing_yes');
            //$("#clubbing_text").prop("required",true);
        } else {
            $("#clubbing_details").prop("disabled", true);
            $("#clubbing").val('clubbing_no');
            //$("#clubbing_text").prop("required",false);
        }
    })

    $("#edema").click(function() {
        if ($("#edema").is(":checked")) {
            $("#edema_details").prop("disabled", false);
            $("#edema").val('edema_yes');
            //$("#edema_text").prop("required",true);
        } else {
            $("#edema_details").prop("disabled", true);
            $("#edema").val('edema_no');
            //$("#edema_text").prop("required",false);
        }
    })

    $("#anasarca").click(function() {
        if ($("#anasarca").is(":checked")) {
            $("#anasarca_details").prop("disabled", false);
            $("#anasarca").val('anasarca_yes');
            //$("#anasarca_text").prop("required",true);
        } else {
            $("#anasarca_details").prop("disabled", true);
            $("#anasarca").val('anasarca_no');
            //$("#anasarca_text").prop("required",false);
        }
    })

    $("#hydration").click(function() {
        if ($("#hydration").is(":checked")) {
            $("#hydration_details").prop("disabled", false);
            //$("#hydration_text").prop("required",true);
            $("#hydration").val('hydration_yes');
        } else {
            $("#hydration_details").prop("disabled", true);
            //$("#hydration_text").prop("required",false);
            $("#hydration").val('hydration_no');
        }
    })

    $("#add_diagnostics").click(function(e) {
        e.preventDefault();
        var diagnostic = $("#diagnostic").val();
        var diagnostic_result = $("#diagnostic_result").val();
        var diagnostic_ids = $("input[name='diagnostic_val[]']").map(function() { return $(this).val().toUpperCase(); }).get();
        var diagnostic_result_val = $("input[name='diagnostic_result_val[]']").map(function() { return $(this).val(); }).get();
        var diagnostic_arr = new Array();
        var diagnostic_result_arr = new Array();
        diagnostic_arr.push(diagnostic_ids);
        diagnostic_result_arr.push(diagnostic_result_val);
        var b = countInArray(diagnostic_arr[0], diagnostic.toUpperCase());
        var c = countInArray(diagnostic_result_arr[0], diagnostic_result);
        if (diagnostic == "") {
            $.toast({
                heading: "Warning",
                text: 'Provide Diagnostics / Investigations',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            })
        } else if (diagnostic_result == "") {
            $.toast({
                heading: "Warning",
                text: 'Provide result',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            })
        } else {
            // if (b < 1 || c < 1) {
            if (b < 1) {
                var trow = '';
                trow += '<tr>' +
                    '<td>' + diagnostic + '</td>' +
                    '<td>' + diagnostic_result + '</td>' +
                    '<td class="text-center"><a href="#" data-toggle="tooltip" title="Click to Delete" class="remove-diagnostics"><i class="fa fa-times text-red"></i></a></td>' +
                    '<input type="hidden" name="diagnostic_val[]" id="dicision_taken_val"  value="' + diagnostic + '">' +
                    '<input type="hidden" name="diagnostic_result_val[]" id="diagnostic_result_val" value="' + diagnostic_result + '">' +
                    '</tr>';
                $("#diagnostic_tbl tbody tr.no-item").remove();
                $("#diagnostic_tbl tbody").append(trow);
                $("#diagnostic").val("");
                $("#diagnostic_result").val("");
            } else {
                $.toast({
                    heading: "Warning",
                    text: 'Duplicate record!',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: false
                })
            }
        }
    })

    $("#diagnostic_tbl").on('click', '.remove-diagnostics', function(e) {
        e.preventDefault();
        var confirm = "Are you sure to delete?";
        if (window.confirm(confirm)) {
            $(this).parent().parent().remove();
        }
    })

    function countInArray(array, value) {
        return array.reduce((n, x) => n + (x === value), 0);
    }

    $("#other_family_history_chkbx").click(function() {
        if ($("#other_family_history_chkbx").is(":checked")) {
            $("#other_family_history").fadeIn();
        } else {
            $("#other_family_history").fadeOut();
        }
    })

    $("#other_devices_situ_chkbx").click(function() {
        if ($("#other_devices_situ_chkbx").is(":checked")) {
            $("#other_devices_situ").fadeIn();
        } else {
            $("#other_devices_situ").fadeOut();
        }
    })

    /* create BMI calc */

    $('#emr_weight').keyup(function(e) {
        e.preventDefault();
        var height = $('#emr_height').val();
        var weight = $(this).val();
        if (weight != "" && height != "") {
            console.log(weight)
            checkBSA(weight, height)
            var x_height = Math.pow((parseFloat(height) / 100), 2);
            console.log(x_height)
            var bmi = parseFloat(weight) / x_height;
            //$("#bmi_val").val('Under weight ('+bmi.toFixed(2)+')');
            check_bmi_rate(parseFloat(bmi))
        } else {
            $("#bmi_val").val('');
        }
    })

    $('#emr_height').keyup(function(e) {
        e.preventDefault();
        var height = $(this).val();
        var weight = $("#emr_weight").val();
        if (height == "" || weight == "") {
            $("#bmi_val").val('');
        } else {
            checkBSA(weight, height)
            height = Math.pow((parseFloat(height) / 100), 2);
            var bmi = parseFloat(weight) / height;
            //$("#bmi_val").val('Under weight ('+bmi.toFixed(2)+')');
            check_bmi_rate(parseFloat(bmi))
        }
    })

    function checkBSA(weight, height) {
        var multy_bsa = parseFloat(weight) * parseFloat(height);
        var devied_bsa = (multy_bsa) / 3600;
        var cal_bsa = Math.sqrt(devied_bsa);
        $("#bsa_val").val(cal_bsa.toFixed(2));
    }
    /* --end-- */

    /* create BMI calc for followup*/

    $('#f_weight').keyup(function(e) {
        e.preventDefault();
        var height = $('#f_height').val();
        var weight = $(this).val();
        if (weight != "" && height != "") {
            checkfollowupBSA(weight, height)
            height = Math.pow((parseFloat(height) / 100), 2);
            var bmi = parseFloat(weight) / height;
            //$("#bmi_val").val('Under weight ('+bmi.toFixed(2)+')');
            check_followup_bmi_rate(parseFloat(bmi))
        } else {
            $("#f_bmi").val('');
        }
    })

    $('#f_height').keyup(function(e) {
        e.preventDefault();
        var height = $(this).val();
        var weight = $("#f_weight").val();
        if (height == "" || weight == "") {
            $("#f_bmi").val('');
        } else {
            checkfollowupBSA(weight, height)
            height = Math.pow((parseFloat(height) / 100), 2);
            var bmi = parseFloat(weight) / height;
            //$("#bmi_val").val('Under weight ('+bmi.toFixed(2)+')');
            check_followup_bmi_rate(bmi)
        }
    })

    function checkfollowupBSA(weight, height) {
        var multy_bsa = parseFloat(weight) * parseFloat(height);
        var devied_bsa = (multy_bsa) / 3600;
        var cal_bsa = Math.sqrt(devied_bsa);
        $("#f_bsa").val(cal_bsa.toFixed(2));
    }
    /* --end-- */
    $('#add_chief_complain').on('click', function(e) {
        e.preventDefault();
        var chiefComplain = $('#chief_complaints').val();
        var chiefComplain_text = $('#chief_complaints :selected').text();
        if (chiefComplain != '') {
            $('#chief_complain_table').append("<tr><td>" + chiefComplain_text + "</td><td class='text-center'><a href='#'  onclick='remove_tr(event,this)' class='remove-diagnostics'><i class='fa fa-times text-red'></i></a></td><input type='hidden' name='chief_complains[]' value='" + chiefComplain + "'></tr>");
            $('#chief_complaints').val('').trigger('change');
        } else {
            $.toast({
                heading: "Warning",
                text: 'Provide Chief complain',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            })
        }
    });

    $("#add_diagnostic_tests").click(function(e) {
        e.preventDefault();
        var clinical_test_group = $("#clinical_test_group").val();
        var clinical_test = $("#clinical_test").val();
        var clinical_test_group_name = $("#clinical_test_group option:selected").text();
        var clinical_test_name = $("#clinical_test option:selected").text();
        var clinical_test_groups = $("input[name='clinical_test_group_val[]']").map(function() { return $(this).val(); }).get();
        var clinical_tests = $("input[name='clinical_test_val[]']").map(function() { return $(this).val(); }).get();
        var clinical_test_group_arr = new Array();
        var clinical_test_arr = new Array();
        clinical_test_group_arr.push(clinical_test_groups);
        clinical_test_arr.push(clinical_tests);
        var b = countInArray(clinical_test_group_arr[0], clinical_test_group);
        var c = countInArray(clinical_test_arr[0], clinical_test);
        if (clinical_test_group == "") {
            $.toast({
                heading: "Warning",
                text: 'Please choose group.',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            })
        } else if (clinical_test == "") {
            $.toast({
                heading: "Warning",
                text: 'Please choose test.',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            })
        } else {
            if (b < 1 || c < 1 || c < 1) {
                var trow = '';
                trow += '<tr>' +
                    '<td>' + clinical_test_group_name + '</td>' +
                    '<td colspan="2">' + clinical_test_name + '</td>' +
                    '<td><a href="#" class="remove_clinical_test"><i class="fa fa-times text-red" data-toggle="tooltip" title="Click to delete the Investigation"></i></a></td>' +
                    '<input type="hidden" name="clinical_test_group_val[]" id="clinical_test_group_val"  value="' + clinical_test_group + '">' +
                    '<input type="hidden" name="clinical_test_val[]" id="clinical_test_val" value="' + clinical_test + '">' +
                    '</tr>';
                $("#dgstaging_tbl tbody tr.no-item").remove();
                $("#dgstaging_tbl tbody").append(trow);
                //$("#clinical_test_group").val("").trigger("change");
                $("#clinical_test").val("").trigger("change");
            } else {
                $.toast({
                    heading: "Warning",
                    text: 'Duplicate record!',
                    showHideTransition: "fade",
                    position: "top-right",
                    icon: "error",
                    loader: false
                })
            }
        }
    })

    $("#dgstaging_tbl").on('click', '.remove_clinical_test', function(e) {
        e.preventDefault();
        var confirm = "Are you sure want to delete?";
        if (window.confirm(confirm)) {
            $(this).parent().parent().remove();
        }
    })

    $("#clinical_test_group").on("change", function(e) {
        e.preventDefault();
        var clinical_test_group = this.value;
        if (clinical_test_group != "") {
            var clinical_test_group_arr = clinical_test_group.split('~');
            $.ajax({
                url: baseurl + 'OPD_module/get_all_clinical_tests',
                type: "POST",
                dataType: "JSON",
                "data": { "check_point": "cnci_clicnical_test", "clinical_test_group": clinical_test_group_arr[0], "corp_code": clinical_test_group_arr[1] },
                beforeSend: function() {
                    $("#add_diagnostic_tests").html('<i class="fa fa-refresh fa-spin"></i>');
                    $("#add_diagnostic_tests").prop("disabled", true);
                    $("#clinical_test").prop("disabled", true);
                },
                success: function(result) {
                    var option = '<option value="">--select--</option>';
                    if (result.status == '1') {
                        $.each(result.data.clinical_tests, function(idx, obj) {
                            option += '<option value="' + obj.TEST_CODE + '">' + obj.TEST_NAME + '</option>';
                        })
                    }
                    $("#clinical_test").html(option);
                },
                complete: function() {
                    $("#add_diagnostic_tests").html('<i class="fa fa-plus"></i>');
                    $("#add_diagnostic_tests").prop("disabled", false);
                    $("#clinical_test").prop("disabled", false);
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            })
        }
    })

    $("#patient_admission").click(function() {
        if ($("#patient_admission").is(":checked")) {
            $(".adminssion_tr").fadeIn();
            $("#admitted_under_lbl").html('Admit Under<span class="text-red">*</span>');
            $("#admitted_under").prop("required", true);
        } else {
            $("#admitted_under_lbl").html('Admit Under');
            $("#admitted_under").prop("required", false);
            $(".adminssion_tr").fadeOut();
        }
    })

    $('#provisional_diagnosis').select2({
        //placeholder: '--select--',
        tags: true,
    }).on('select2:close', function() {
        var element = $(this);
        var new_initial_diagnosis = $.trim(element.val()); //(element.val() != "")?$.trim(element.text()):"";
        if (new_initial_diagnosis != '') {
            $.ajax({
                url: baseurl + 'OPD_module/add_provisional_diagnosis',
                type: "post",
                data: { new_initial_diagnosis: new_initial_diagnosis },
                dataType: 'json',
                success: function(result) {
                    if (result.status == '1') {
                        element.append('<option value="' + result.data.id + '">' + result.data.text + '</option>').val(result.data.id);
                        fetch_all_diagnosis('provisional', result.data.id)
                    }
                }
            })
        }
    });

    $('#chief_complaints').select2({
        //placeholder: '--select--',
        tags: true,
    }).on('select2:close', function() {
        var element = $(this);
        var chief_complaints = $.trim(element.val()); //(element.val() != "")?$.trim(element.text()):"";
        if (chief_complaints != '') {
            $.ajax({
                url: baseurl + 'OPD_module/save_chief_complaints',
                type: "post",
                data: { chief_complaints: chief_complaints },
                dataType: 'json',
                success: function(result) {
                    if (result.status == '1') {
                        element.append('<option value="' + result.data.id + '">' + result.data.text + '</option>').val(result.data.id);
                    }
                }
            })
        }
    });

    /* $("#provisional_diagnosis").on("change", function() {
        var val = this.value;
        if (val != "") {
            $("#follow_up_diagnosis").val(val).trigger("change");
            $("#final_diagnosis").val(val).trigger("change");
        }
    }) */

    /* $("#final_diagnosis").on("change", function() {
        var val = this.value;
        if (val != "") {
            $("#follow_up_diagnosis").val(val).trigger("change");
        }
    }) */

    $('#final_diagnosis').select2({
        //placeholder: '--select--',
        tags: true,
    }).on('select2:close', function() {
        var element = $(this);
        var new_initial_diagnosis = $.trim(element.val()); //(element.val() != "")?$.trim(element.text()):"";
        if (new_initial_diagnosis != '') {
            $.ajax({
                url: baseurl + 'OPD_module/add_provisional_diagnosis',
                type: "post",
                data: { new_initial_diagnosis: new_initial_diagnosis },
                dataType: 'json',
                success: function(result) {
                    if (result.status == '1') {
                        element.append('<option value="' + result.data.id + '">' + result.data.text + '</option>').val(result.data.id);
                        fetch_all_diagnosis('final', result.data.id)
                    }
                }
            })
        }
    });

    $("#emr_form").submit(function(e) {
        var comborbidity_note_edt = thecomborbidity_note_edt.getData();
        var treatment_history_edt = thetreatment_history_edt.getData();
        var past_history_notes_edt = thepast_history_notes_edt.getData();
        var known_allergies_edt = theknown_allergies_edt.getData();
        var familyplan_measures_edt = thefamilyplan_measures_edt.getData();
        var devices_note_edt = thedevices_note_edt.getData();
        var clinical_staging_edt = theclinical_staging_edt.getData();
        var doctor_advice_edt = thedoctor_advice_edt.getData();
        var plan_of_treatment_edt = theplan_of_treatment_edt.getData();
        var advice_on_admission_edt = theadvice_on_admission_edt.getData();
        var past_history_notes = thepast_history_notes_edt.getData()
        var pr_text_edt = thepr_text_edt.getData();
        var proctoscopy_edt = theproctoscopy_edt.getData();
        var haed_neck_edt = thehaed_neck_edt.getData();
        var per_speculum_edt = theper_speculum_edt.getData();
        var pv_text_edt = thepv_text_edt.getData();
        var thorax_edt = thethorax_edt.getData();
        var breast_thorax_edt = thebreast_thorax_edt.getData();
        var abdomen_edt = theabdomen_edt.getData();
        var pelvis_edt = thepelvis_edt.getData();
        var genitalia_edt = thegenitalia_edt.getData();
        var extremities_edt = theextremities_edt.getData();
        var additional_notes_edt = theadditional_notes_edt.getData();
        $("#comborbidity_note").val(comborbidity_note_edt);
        $("#past_history_notes").val(past_history_notes_edt);
        $("#known_allergies").val(known_allergies_edt);
        $("#treatment_history").val(treatment_history_edt);
        $("#familyplan_measures").val(familyplan_measures_edt);
        $("#devices_note").val(devices_note_edt);
        $("#clinical_staging").val(clinical_staging_edt);
        $("#doctor_advice").val(doctor_advice_edt);
        $("#plan_of_treatment").val(plan_of_treatment_edt);
        $("#advice_on_admission").val(advice_on_admission_edt);
        $("#pr_text").val(pr_text_edt);
        $("#proctoscopy").val(proctoscopy_edt);
        $("#haed_neck").val(haed_neck_edt);
        $("#per_speculum").val(per_speculum_edt);
        $("#pv_text").val(pv_text_edt);
        $("#thorax").val(thorax_edt);
        $("#breast_thorax").val(breast_thorax_edt);
        $("#abdomen").val(abdomen_edt);
        $("#pelvis").val(pelvis_edt);
        $("#genitalia").val(genitalia_edt);
        $("#extremities").val(extremities_edt);
        $("#additional_notes").val(additional_notes_edt);
        var chief_complain_len = $("#chief_complain_table tr").length;
        if (chief_complain_len <= 0) {
            $('html, body').animate({
                scrollTop: $(".box-header").offset().top
            });
            /* $.toast({
                heading: "Warning",
                text: 'Please add chief complaints!',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            }) */
            swal({
                title: "Warning",
                text: 'Please add chief complaints!',
                type: "error"
            }, function() {
                //swal.close()
            });
            return false;
        } else if (past_history_notes == "") {
            $('html, body').animate({
                scrollTop: $(".past_history").offset().top
            });
            /* $.toast({
                heading: "Warning",
                text: 'The note field is required!',
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: false
            }) */
            swal({
                title: "Warning",
                text: 'The note field is required!',
                type: "error"
            }, function() {
                //swal.close()
            });
            return false;
        } else {
            return true;
        }
    })

    /* transfer department */
    $(".chemo_dept").on("click", function(e) {
        var uhid = $(this).data("uhid");
        var ptcode = $(this).data("ptcode");
        var status = $(this).data("status");
        swal({
                title: "Warning!",
                text: "Do you want to transfer department Medical Oncology (Chemotherapy) ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $(".confirm").attr('disabled', 'disabled');
                    $.ajax({
                        url: baseurl + 'OPD_module/updateEMRpatientdepartment',
                        method: 'post',
                        dataType: 'json',
                        data: { uhid_id: uhid, pt_code: ptcode, dept_id: 'SS_07' },
                        beforeSend: function() {},
                        success: function(result) {
                            if (result.status == '1') {
                                swal({
                                    title: "Success",
                                    text: result.message,
                                    type: "success"
                                }, function() {
                                    if (status == 'YES') {
                                        location.href = baseurl + "chemotherapy-dashboard/"
                                    } else {
                                        location.reload();
                                    }
                                })
                            } else {
                                swal({
                                    title: "Failed",
                                    text: result.message,
                                    type: "danger"
                                }, function() {
                                    //swal.close()
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        },
                        complete: function() {}
                    })
                } else {
                    swal("Cancelled", "", "error");
                    e.preventDefault();
                }
            }
        )
    })

    $(".radio_dept").on("click", function(e) {
            var uhid = $(this).data("uhid");
            var ptcode = $(this).data("ptcode");
            var status = $(this).data("status");
            swal({
                    title: "Warning!",
                    text: "Do you want to transfer to Radiation Oncology (Radiotherapy) ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes, I am sure!',
                    cancelButtonText: "No, cancel it!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $(".confirm").attr('disabled', 'disabled');
                        $.ajax({
                            url: baseurl + 'OPD_module/updateEMRpatientdepartment',
                            method: 'post',
                            dataType: 'json',
                            data: { uhid_id: uhid, pt_code: ptcode, dept_id: 'SS_01' },
                            beforeSend: function() {},
                            success: function(result) {
                                if (result.status == '1') {
                                    swal({
                                        title: "Success",
                                        text: result.message,
                                        type: "success"
                                    }, function() {
                                        if (status == 'YES') {
                                            location.href = baseurl + "radiotherapy-dashboard/"
                                        } else {
                                            location.reload();
                                        }
                                    })
                                } else {
                                    swal({
                                        title: "Failed",
                                        text: result.message,
                                        type: "danger"
                                    }, function() {
                                        //swal.close()
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            },
                            complete: function() {}
                        })
                    } else {
                        swal("Cancelled", "", "error");
                        e.preventDefault();
                    }
                }
            )
        })
        /* end */

    //$('input[name="lmp"]').datepicker("option", "minDate", new Date());
    $('input[name="to_be_admitted_on"]').datepicker("option", "minDate", new Date());
    $('input[name="to_be_admitted_on_followup"]').datepicker("option", "minDate", new Date());

    $('#slides').click(function() {
        if ($('#slides').is(":checked")) {
            $('#slides_value').prop("disabled", false);
            $('#other_slides_text').prop("disabled", false);
        } else {
            $('#slides_value').prop("disabled", true);
            $('#other_slides_text').prop("disabled", true);
        }
    })
})

$(document).ready(function() {
    var arr = [];
    $.getJSON(baseurl + 'resources/EMR/ICD10.json', function(data) {
        //$.getJSON('dist/custom/Data/1.json', function (data) {
        $.each(data, function(key, val) {
            arr.push(val["CODE"] + val["SHORT_DESCRIPTION"]);
        });
        //console.log(JSON.stringify(arr, 3, 3));
        var options = {
            data: arr
        };
        $("#icd_code").easyAutocomplete(options);
    });
})

function check_bmi_rate(bmi_rate) {
    if (bmi_rate < 18.5) {
        $("#bmi_val").val('Under weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 18.5 && bmi_rate <= 24.9) {
        $("#bmi_val").val('Normal weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 25 && bmi_rate < 29.9) {
        $("#bmi_val").val('Over weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 30) {
        $("#bmi_val").val('Obese');
    }
}

function check_followup_bmi_rate(bmi_rate) {
    if (bmi_rate < 18.5) {
        $("#f_bmi").val('Under weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 18.5 && bmi_rate <= 24.9) {
        $("#f_bmi").val('Normal weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 25 && bmi_rate < 29.9) {
        $("#f_bmi").val('Over weight (' + bmi_rate.toFixed(2) + ')');
    } else if (bmi_rate >= 30) {
        $("#f_bmi").val('Obese');
    }
}

function fetch_all_diagnosis(d_type, selected_test = "") {
    var provisional_diagnosis = $("#provisional_diagnosis").val();
    var final_diagnosis = $("#final_diagnosis").val();
    var follow_up_diagnosis = $("#follow_up_diagnosis").val();
    $.ajax({
        url: baseurl + 'OPD_module/fetch_diagnosis_dropdown_data',
        type: "post",
        dataType: 'json',
        beforeSend: function() {
            //$('#final_diagnosis').html('<option value="">Updating...</option>');
            //$('#doctor_diagnosis').html('<option value="">Updating...</option>');
        },
        success: function(result) {
            var diagnosis_data = '<option value="">--select--</option>';
            if (result.status == '1') {
                $.each(result.data, function(idx, obj) {
                    diagnosis_data += '<option value="' + obj.id + '">' + obj.text + '</option>'
                })
            } else {
                diagnosis_data = '<option value="">No result found</option>';
            }
            setTimeout(function() {
                if (d_type != '') {
                    if (d_type == 'provisional') {
                        $('#final_diagnosis').html(diagnosis_data);
                        $('#follow_up_diagnosis').html(diagnosis_data);
                        $("#final_diagnosis").val(final_diagnosis).trigger("change");
                        $("#follow_up_diagnosis").val(follow_up_diagnosis).trigger("change");
                    } else if (d_type == 'final') {
                        $('#provisional_diagnosis').html(diagnosis_data);
                        $('#follow_up_diagnosis').html(diagnosis_data);
                        $("#provisional_diagnosis").val(provisional_diagnosis).trigger("change");
                        $("#follow_up_diagnosis").val(follow_up_diagnosis).trigger("change");
                    } else {
                        $('#provisional_diagnosis').html(diagnosis_data);
                        $('#follow_up_diagnosis').html(diagnosis_data);
                    }
                } else {
                    $("#provisional_diagnosis").val(provisional_diagnosis).trigger("change");
                    $("#final_diagnosis").val(final_diagnosis).trigger("change");
                    $("#follow_up_diagnosis").val(follow_up_diagnosis).trigger("change");
                    $('#final_diagnosis').html(diagnosis_data);
                }
            }, 300)
        }
    })
}

/* charlson */
function getCharlseagepoint(age) {
    value = 0;
    if (age < 50) {
        value = 1;
    } else if (age >= 50 && age <= 60) {
        value = 2;
    } else if (age >= 60 && age <= 70) {
        value = 3;
    } else if (age >= 70) {
        value = 4;
    } else if (age > 80) {
        value = 5;
    } else {
        value = 6
    }
    return value;
}

function createChemoDischarge(e, uhid, adid, chemo_line_id, line_id, cycle, cycle_date) {
    e.preventDefault();
    document.getElementById('custom_id').value = uhid;
    document.getElementById('mode').value = 'create_chemo_discharge';
    document.getElementById('custom_form').action = baseurl + '/chemotherapy-discharge';
    $("#custom_form").append('<input type="hidden" id="administrator_id" name="administrator_id" value="' + adid + '">');
    $("#custom_form").append('<input type="hidden" id="chemo_line_id" name="chemo_line_id" value="' + chemo_line_id + '">');
    $("#custom_form").append('<input type="hidden" id="line_id" name="line_id" value="' + line_id + '">');
    $("#custom_form").append('<input type="hidden" id="cycle" name="cycle" value="' + cycle + '">');
    $("#custom_form").append('<input type="hidden" id="cycle_date" name="cycle_date" value="' + cycle_date + '">');
    $("#custom_form").attr("target", "_blank");
    document.getElementById('custom_form').submit();
}

function remove_tr(e, data) {
    e.preventDefault();
    if (confirm('Are you sure you want to delete?')) {
        $(data).closest('tr').remove();
    }
}

/* Discharge history */
function bind_discharge_data(ele, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_all_discharge_data',
        type: "POST",
        dataType: "JSON",
        "data": { "uhid": uhid },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            var str = '';
            if (result.status == 1) {
                $.each(result.data, function(idx, obj) {
                    str += '<tr>' +
                        '<td>' + (idx + 1) + '</td>' +
                        '<td>' + obj.DATE + '</td>' +
                        '<td>' + obj.SOURCE.replace('/_/g', "") + '</td>';
                    if (obj.SOURCE == "RADIOTHERAPY_EBRT") {
                        str += '<td><a class="btn btn-xs btn-primary" target="_blank" href="' + baseurl + 'radiothapy-administration-pdf/' + obj.UHID_ENC + "/" + obj.ADMINISTER_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    } else if (obj.SOURCE == "RADIOTHERAPY_BRACHYTHERAPY") {
                        str += '<td><a class="btn btn-xs btn-primary" target="_blank" href="' + baseurl + 'brachytherapy-pdf/' + obj.UHID_ENC + "/" + obj.ADMINISTER_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    } else if (obj.SOURCE == "CHEMO") {
                        str += '<td><a class="btn btn-xs btn-primary" target="_blank" href="' + baseurl + 'chemotherapy-discharge-pdf/' + obj.UHID_ENC + "/" + obj.ADMINISTER_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    }
                    '</tr>';
                });
            } else {
                str += '<tr class="odd"><td colspan="12" class="dataTables_empty" style="text-align: center;">No data available in table</td></tr>';
            }
            $('#discharge_history_id').html(str);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}
/* --end-- */

/* presscription history*/
function bind_prescription_data(e, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_all_prescription_data',
        type: "POST",
        dataType: "JSON",
        "data": {
            "uhid": uhid
        },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            var str = '';
            if (result.status == 1) {
                $.each(result.data, function(idx, obj) {
                    str += '<tr>' +
                        '<td>' + (idx + 1) + '</td>' +
                        '<td>' + obj.PRESCRIPTIONS_DATE + ' ' + obj.PRESCRIPTIONS_TIME + '</td>' +
                        '<td>' + obj.PRESCRIPTIONS_TYPE + '</td>' +
                        '<td>' + obj.CREATED_BY + '</td>';
                    if (obj.PRESCRIPTIONS_TYPE == "NORMAL") {
                        str += '<td><a class="btn btn-sm btn-primary" target="_blank" href="' + baseurl + 'prescription-pdf/' + obj.PRESCRIPTIONS_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    } else if (obj.PRESCRIPTIONS_TYPE == "DIGITAL") {
                        str += '<td><a class="btn btn-sm btn-primary" target="_blank" href="' + baseurl + 'digital-prescription-pdf/' + obj.PRESCRIPTIONS_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    } else if (obj.PRESCRIPTIONS_TYPE == "CHEMO") {
                        str += '<td><a class="btn btn-sm btn-primary" target="_blank" href="' + baseurl + 'chemotherapy-prescription-pdf/' + obj.UHID_ENC + "/" + obj.PRESCRIPTIONS_ID_ENC + '"><i class="fa fa-eye"></i>&nbsp;View</a></td>';
                    }
                    '</tr>';
                });
            } else {
                str += '<tr class="odd"><td valign="top" colspan="12" class="dataTables_empty" style="text-align: center;">No data available in table</td></tr>';
            }
            $('#prescription_history_id').html(str);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}
/* --end-- */

/* pac history */
function bind_pac_history(ele, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_all_pac_data',
        type: "POST",
        dataType: "HTML",
        "data": { "uhid": uhid },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            $('#pac_history_div').html(result);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}
/* end */

$(function() {
    function charlson_survival_formula(points) {
        /* if (points == 0) {
            return '98%';
        } else if (points == 1) {
            return '96%';
        } else if (points == 2) {
            return '90%';
        } else if (points == 3) {
            return '77%';
        } else if (points == 4) {
            return '53%';
        } else if (points == 5) {
            return '51%';
        } else if (points >= 6) {
            return '2%';
        } else {
            return '0%';
        } */
        var eulers_no = 2.71828;
        var eulers_no_val = eulers_no ** (points * 0.9);
        var charlson_perc = 0.983 ** eulers_no_val;
        var final_score = (charlson_perc * 100);
        return Math.ceil(final_score) + '%';
    }

    var patient_age = $("#patient_age").val();
    var charls_point = getCharlseagepoint(parseFloat(patient_age));
    $(".points1").text(charls_point);
    $(".final").text(' ' + charls_point);
    $(".charls_cal").on("change", function() {
        var id = $(this).data("id");
        var point = $(this).val();
        $(".points" + id).text(point);
        var charls_val = 0;
        $(".charls_cal").each(function() {
            var input_val = $(this).val();
            input_val = (input_val == "") ? "0" : input_val;
            charls_val += parseFloat(input_val);
        });
        charls_val += charls_point;
        $(".final").text(' ' + charls_val);
    })

    $("#charlson_form").on("submit", function() {
        var charls_points = new Array();
        charls_points.push(charls_points);
        var charls_val = 0;
        $(".charls_cal").each(function() {
            var input_val = $(this).val();
            input_val = (input_val == "") ? "0" : input_val;
            charls_val += +parseFloat(input_val);
            charls_points.push(input_val);
        });
        charls_val += charls_point;
        $("#charlson_predict_val > h3").fadeIn();
        $("#charlson_predict_val > h3").text(charlson_survival_formula(charls_val));
        $("#charlson_predict_val").find('p').remove();
        $("#charlson_predict_val > h3").after("<p>Estimated 10-year Survival</p>");
        $("#charlson_scores").val(charls_points.join `,`);
        $("#estimatemod").modal("hide");
        $("#update_charlson_modal").modal("hide");
        return false;
    })

    $(document).on('click', '.readmore', function() {
        var read_id = $(this).attr("data-id");
        var read_text = $(this).text(); //more or less
        if (read_text == "Read more") {
            $("#" + read_id + "").show();
            $(this).text("Read less");
        } else {
            $("#" + read_id + "").hide();
            $(this).text("Read more");
        }
    })
});

/* lis history*/
function bind_lis_data(e, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_all_lis_data',
        type: "POST",
        dataType: "HTML",
        "data": {
            "uhid": uhid
        },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            $('#lis_history_id').html(result);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}
/* --end-- */

/* RIS history */
function bind_ris_report(e, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_ris_report_data',
        type: "POST",
        dataType: "HTML",
        "data": { "uhid": uhid },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            $('#ris_table_body').html(result);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}

function bind_outsourced_report(e, uhid) {
    $.ajax({
        url: baseurl + 'OPD_module/get_outsourced_report_data',
        type: "POST",
        dataType: "HTML",
        "data": { "uhid": uhid },
        beforeSend: function() {
            $(".mainbody").fadeIn();
        },
        success: function(result) {
            $('#outsourced_report_tbody').html(result);
        },
        complete: function() {
            $(".mainbody").fadeOut();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    })
}

function removeCharAtIndex(index, str) {
    var maxIndex = index == 0 ? 0 : index;
    return str.substring(0, maxIndex) + str.substring(index, str.length)
}
/* --end-- */