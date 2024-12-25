$(function() {
    let present_complaints_text;
    BalloonEditor.create(document.querySelector("#present_complaints"), {})
        .then((present_complaints_edit) => {
            present_complaints_text = present_complaints_edit;
        })
        .catch((error) => {});

    let medical_history_details_text;
    BalloonEditor.create(document.querySelector("#medical_history_details"), {})
        .then((medical_history_details_edit) => {
            medical_history_details_text = medical_history_details_edit;
        })
        .catch((error) => {});

    let chronic_illness_text;
    BalloonEditor.create(document.querySelector("#chronic_illness"), {})
        .then((chronic_illness_edit) => {
            chronic_illness_text = chronic_illness_edit;
        })
        .catch((error) => {});

    let medications_text;
    BalloonEditor.create(document.querySelector("#medications"), {})
        .then((medications_edit) => {
            medications_text = medications_edit;
        })
        .catch((error) => {});

    let allergies_text;
    BalloonEditor.create(document.querySelector("#allergies"), {})
        .then((allergies_edit) => {
            allergies_text = allergies_edit;
        })
        .catch((error) => {});

    let family_history_text;
    BalloonEditor.create(document.querySelector("#family_history"), {})
        .then((family_history_edit) => {
            family_history_text = family_history_edit;
        })
        .catch((error) => {});

    /* let anesthetic_history_text;
    BalloonEditor.create(document.querySelector("#anesthetic_history"), {})
        .then((anesthetic_history_edit) => {
            anesthetic_history_text = anesthetic_history_edit;
        })
        .catch((error) => {}); */

    let nutritional_history_text;
    BalloonEditor.create(document.querySelector("#nutritional_history"), {})
        .then((nutritional_history_edit) => {
            nutritional_history_text = nutritional_history_edit;
        })
        .catch((error) => {});

    let remark_text;
    BalloonEditor.create(document.querySelector("#remark"), {})
        .then((remark_edit) => {
            remark_text = remark_edit;
        })
        .catch((error) => {});

    let birth_history_text;
    BalloonEditor.create(document.querySelector("#birth_history"), {})
        .then((birth_history_edit) => {
            birth_history_text = birth_history_edit;
        })
        .catch((error) => {});

    let immunization_text;
    BalloonEditor.create(document.querySelector("#immunization"), {})
        .then((immunization_edit) => {
            immunization_text = immunization_edit;
        })
        .catch((error) => {});

    let milestones_text;
    BalloonEditor.create(document.querySelector("#milestones"), {})
        .then((milestones_edit) => {
            milestones_text = milestones_edit;
        })
        .catch((error) => {});

    let other_detail_text;
    BalloonEditor.create(document.querySelector("#other_detail"), {})
        .then((other_detail_edit) => {
            other_detail_text = other_detail_edit;
        })
        .catch((error) => {});

    let cardio_vascular_other_text;
    BalloonEditor.create(document.querySelector("#cardio_vascular_other"), {})
        .then((cardio_vascular_other_edit) => {
            cardio_vascular_other_text = cardio_vascular_other_edit;
        })
        .catch((error) => {});

    let cardio_vascular_risk_text;
    BalloonEditor.create(document.querySelector("#cardio_vascular_risk"), {})
        .then((cardio_vascular_risk_edit) => {
            cardio_vascular_risk_text = cardio_vascular_risk_edit;
        })
        .catch((error) => {});

    let respiratory_other_text;
    BalloonEditor.create(document.querySelector("#respiratory_other"), {})
        .then((respiratory_other_edit) => {
            respiratory_other_text = respiratory_other_edit;
        })
        .catch((error) => {});

    /* let theremarks_text;
    BalloonEditor.create(document.querySelector("#remarks"), {})
        .then((remarks_edit) => {
            theremarks_text = remarks_edit;
        })
        .catch((error) => {}); */

    /* let medication_text;
    BalloonEditor.create(document.querySelector("#medication"), {})
        .then((medication_edit) => {
            medication_text = medication_edit;
        })
        .catch((error) => {}); */

    /* let gcs_text;
    BalloonEditor.create(document.querySelector("#gcs"), {})
        .then((gcs_edit) => {
            gcs_text = gcs_edit;
        })
        .catch((error) => {}); */

    let additional_risk_text;
    BalloonEditor.create(document.querySelector("#additional_risk"), {})
        .then((additional_risk_edit) => {
            additional_risk_text = additional_risk_edit;
        })
        .catch((error) => {});

    let plan_of_anasthesia_text;
    BalloonEditor.create(document.querySelector("#plan_of_anasthesia"), {})
        .then((plan_of_anasthesia_edit) => {
            plan_of_anasthesia_text = plan_of_anasthesia_edit;
        })
        .catch((error) => {});

    let referral_text;
    BalloonEditor.create(document.querySelector("#referral"), {})
        .then((referral_edit) => {
            referral_text = referral_edit;
        })
        .catch((error) => {});

    let special_investigation_text;
    BalloonEditor.create(document.querySelector("#special_investigation"), {})
        .then((special_investigation_edit) => {
            special_investigation_text = special_investigation_edit;
        })
        .catch((error) => {});

    let advice_text;
    BalloonEditor.create(document.querySelector("#advice_editor"), {})
        .then((advice_edit) => {
            advice_text = advice_edit;
        })
        .catch((error) => {});

    ("use strict");
    $('[data-toggle="push-menu"]').pushMenu("toggle");

    $("#pac_checkup_form").on("submit", function() {
        var present_complaints_val = present_complaints_text.getData();
        $("#present_complaints_val").val(present_complaints_val);

        var medical_history_details_val = medical_history_details_text.getData();
        $("#medical_history_details_val").val(medical_history_details_val);

        var chronic_illness_val = chronic_illness_text.getData();
        $("#chronic_illness_val").val(chronic_illness_val);

        var medications_val = medications_text.getData();
        $("#medications_val").val(medications_val);

        var allergies_val = allergies_text.getData();
        $("#allergies_val").val(allergies_val);

        var family_history_val = family_history_text.getData();
        $("#family_history_val").val(family_history_val);

        // var anesthetic_history_val = anesthetic_history_text.getData();
        // $("#anesthetic_history_val").val(anesthetic_history_val);

        var nutritional_history_val = nutritional_history_text.getData();
        $("#nutritional_history_val").val(nutritional_history_val);

        var remark_val = remark_text.getData();
        $("#remark_val").val(remark_val);

        var birth_history_val = birth_history_text.getData();
        $("#birth_history_val").val(birth_history_val);

        var immunization_val = immunization_text.getData();
        $("#immunization_val").val(immunization_val);

        var milestones_val = milestones_text.getData();
        $("#milestones_val").val(milestones_val);

        var other_detail_val = other_detail_text.getData();
        $("#other_detail_val").val(other_detail_val);

        var cardio_vascular_other_val = cardio_vascular_other_text.getData();
        $("#cardio_vascular_other_val").val(cardio_vascular_other_val);

        var cardio_vascular_risk_val = cardio_vascular_risk_text.getData();
        $("#cardio_vascular_risk_val").val(cardio_vascular_risk_val);

        var respiratory_other_val = respiratory_other_text.getData();
        $("#respiratory_other_val").val(respiratory_other_val);

        // var remarks_val = theremarks_text.getData();
        // $("#remarks_val").val(remarks_val);

        // var medication_val = medication_text.getData();
        // $("#medication_val").val(medication_val);

        // var gcs_val = gcs_text.getData();
        // $("#gcs_val").val(gcs_val);

        var additional_risk_val = additional_risk_text.getData();
        $("#additional_risk_val").val(additional_risk_val);

        var plan_of_anasthesia_val = plan_of_anasthesia_text.getData();
        $("#plan_of_anasthesia_val").val(plan_of_anasthesia_val);

        var referral_val = referral_text.getData();
        $("#referral_val").val(referral_val);

        var advice_data = advice_text.getData();
        $("#advice_val").val(advice_data);

        var special_investigation_text_val = special_investigation_text.getData();
        $("#special_investigation_val").val(special_investigation_text_val);


        return true;
    });

    $("#weight").keyup(function(e) {
        e.preventDefault();
        var height = $("#height").val();
        var weight = $(this).val();
        if (weight != "" && height != "") {
            height = Math.pow(height / 100, 2);
            var bmi = weight / height;
            check_bmi_rate(parseFloat(bmi));
        } else {
            $("#bmi_val").val("");
        }
    });

    $("#height").keyup(function(e) {
        e.preventDefault();
        var height = $(this).val();
        var weight = $("#weight").val();
        if (height == "" || weight == "") {
            $("#bmi_val").val("");
        } else {
            height = Math.pow(height / 100, 2);
            var bmi = weight / height;
            check_bmi_rate(bmi);
        }
    });

    $(".decimel").keypress(function(event) {
        var input = $(this).val();
        var keyCode = event.which;

        // Allow only digits, backspace, and dot
        if ((keyCode < 48 || keyCode > 57) && keyCode !== 8 && keyCode !== 46) {
            event.preventDefault();
        }

        // Prevent dot as the first character
        if (keyCode === 46 && input.length === 0) {
            event.preventDefault();
        }

        // Prevent multiple dots
        if (keyCode === 46 && input.indexOf(".") !== -1) {
            event.preventDefault();
        }
    });

    $(".decimel").on("keyup", function(e) {
        var inputValue = $(this).val();

        // Check if the value is greater than 10
        if (parseFloat(inputValue) > 10) {
            $(this).val("");
        } else if (parseFloat(inputValue) < 0) {
            $(this).val("");
        }
    });

    

    $("#medical-check").on("click", function() {
        if ($(this).is(":checked")) {
            $("#medical-input").show();
        } else {
            $("#medical-input").hide();
            $("#medical-input").val("");
        }
    });

    $("#complication-check").on("click", function() {
        if ($(this).is(":checked")) {
            $("#complication-input").show();
        } else {
            $("#complication-input").hide();
            $("#complication-input").val("");
        }
    });

    $("#pacemaker-check").on("click", function() {
        if ($(this).is(":checked")) {
            $("#pacemaker-input").show();
        } else {
            $("#pacemaker-input").hide();
            $("#pacemaker-input").val("");
        }
    });

    $("#surgery_name")
        .select2({
            placeholder: "--select--",
            tags: true,
        })
        .on("select2:close", function() {
            var element = $(this);
            var new_surgery = $.trim(element.val());
            if (new_surgery != "") {
                $.ajax({
                    url: baseurl + "OT_Management/save_surgery_data",
                    type: "post",
                    data: {
                        new_surgery: new_surgery,
                    },
                    dataType: "json",
                    success: function(result) {
                        if (result.status == "1") {
                            element
                                .append(
                                    '<option value="' +
                                    result.data.id +
                                    '">' +
                                    result.data.text +
                                    "</option>"
                                )
                                .val(result.data.id);
                        }
                    },
                });
            }
        });

    $("#provisional_diagnosis")
        .select2({
            placeholder: "--select--",
            tags: true,
        })
        .on("select2:close", function() {
            var element = $(this);
            var new_initial_diagnosis = $.trim(element.val());
            if (new_initial_diagnosis != "") {
                $.ajax({
                    url: baseurl + "OPD_module/add_provisional_diagnosis",
                    type: "post",
                    data: {
                        new_initial_diagnosis: new_initial_diagnosis,
                    },
                    dataType: "json",
                    success: function(result) {
                        if (result.status == "1") {
                            element
                                .append(
                                    '<option value="' +
                                    result.data.id +
                                    '">' +
                                    result.data.text +
                                    "</option>"
                                )
                                .val(result.data.id);
                        }
                    },
                });
            }
        });

    $("#pac_advice")
        .select2({
            placeholder: "--select--",
            tags: true,
        })
        .on("select2:close", function() {
            var element = $(this);
            var new_pac_advice = $.trim(element.val());
            if (new_pac_advice != "") {
                $.ajax({
                    url: baseurl + "Anesthesia_Management/save_pac_advice",
                    type: "post",
                    data: {
                        new_pac_advice: new_pac_advice,
                    },
                    dataType: "json",
                    success: function(result) {
                        if (result.status == "1") {
                            element
                                .append(
                                    '<option value="' +
                                    result.data.id +
                                    '" selected>' +
                                    result.data.text +
                                    "</option>"
                                )
                                .val(result.data.id);
                        }
                        var advice_html = advice_text.getData();
                        var advice_data = $('#pac_advice :selected').text();
                        advice_text.setData(advice_html + "<p>" + advice_data + "</p>");
                        element.val('').change();
                    },
                });
            }
        });

    /* $("#pac_advice").change(function() {
        var advice_html = advice_text.getData();
        var advice_data = $(this).text();
        advice_text.setData(advice_html + "<p>" + advice_data + "</p>");
        $(this).val('').change();
    }) */

    // -------Chart Js-------

    /* var barChartData10 = [];
    barChartData10.push({
       value: 0,
       indicator: 'point',
       shape: 'triangle',
       width: 18,
       height: 18,
       offset: 8,
       color: '#1b02f7',
       colorRanges: [{
          startpoint: 0,
          breakpoint: 1,
          color: '#1b02f7'
       }, {
          startpoint: 1,
          breakpoint: 3,
          color: '#47fe12'
       }, {
          startpoint: 3,
          breakpoint: 7,
          color: '#e1e10d'
       }, {
          startpoint: 7,
          breakpoint: 10,
          color: '#fe1229'
       }],
       tooltipRanges: [{
          startpoint: 1,
          breakpoint: 4,
          tooltip: 'Low'
       }, {
          startpoint: 4,
          breakpoint: 7,
          tooltip: 'Moderate'
       }, {
          startpoint: 7,
          breakpoint: 10,
          tooltip: 'High'
       }]
    });

    var ctx10 = document.getElementById("canvas10").getContext("2d");
    window.myBar10 = new Chart(ctx10).Linear(barChartData10, {
       range: {
          startValue: 0,
          endValue: 10
       },
       responsive: true,
       animationSteps: 90,
       axisColor: '#c5c7cf',
       axisWidth: 6,
       majorTicks: {
          interval: 1,
          width: 8,
          height: 1,
          offset: 1,
          color: '#000'
       },
       minorTicks: {
          interval: 5,
          width: 3,
          height: 1,
          offset: 0,
          color: '#000'
       },
       tickLabels: {
          interval: 1,
          units: '',
          offset: -17
       },
       geometry: 'horizontal',
       scaleColorRanges: [{
          start: 0,
          end: 1,
          color: '#1b02f7'
       }, {
          start: 1,
          end: 3,
          color: '#47fe12'
       }, {
          start: 3,
          end: 7,
          color: '#e1e10d'
       }, {
          start: 7,
          end: 10,
          color: '#fe1229'
       }],
    });

    var barChartData10 = [];
    $(document).ready(function () {
       $("#vasinput").on("keyup", function () {

          var vasscore = $("#vasinput").val() || 0;
          barChartData10.pop();
          barChartData10.push({
             value: vasscore,
             indicator: 'point',
             shape: 'triangle',
             width: 18,
             height: 18,
             offset: 8,
             color: '#1b02f7',
             colorRanges: [{
                startpoint: 0,
                breakpoint: 1,
                color: '#1b02f7'
             }, {
                startpoint: 1,
                breakpoint: 3,
                color: '#47fe12'
             }, {
                startpoint: 3,
                breakpoint: 7,
                color: '#e1e10d'
             }, {
                startpoint: 7,
                breakpoint: 10,
                color: '#fe1229'
             }],
             tooltipRanges: [{
                startpoint: 1,
                breakpoint: 4,
                tooltip: 'Low'
             }, {
                startpoint: 4,
                breakpoint: 7,
                tooltip: 'Moderate'
             }, {
                startpoint: 7,
                breakpoint: 10,
                tooltip: 'High'
             }]
          });
       });
       $("#vasinput").on("keyup", function () {

          var ctx10 = document.getElementById("canvas10").getContext("2d");
          window.myBar10 = new Chart(ctx10).Linear(barChartData10, {
             range: {
                startValue: 0,
                endValue: 10
             },
             responsive: true,
             animationSteps: 90,
             axisColor: '#c5c7cf',
             axisWidth: 6,
             majorTicks: {
                interval: 1,
                width: 8,
                height: 1,
                offset: 1,
                color: '#000'
             },
             minorTicks: {
                interval: 5,
                width: 3,
                height: 1,
                offset: 0,
                color: '#000'
             },
             tickLabels: {
                interval: 1,
                units: '',
                offset: -17
             },
             geometry: 'horizontal',
             scaleColorRanges: [{
                start: 0,
                end: 1,
                color: '#1b02f7'
             }, {
                start: 1,
                end: 3,
                color: '#47fe12'
             }, {
                start: 3,
                end: 7,
                color: '#e1e10d'
             }, {
                start: 7,
                end: 10,
                color: '#fe1229'
             }],
          });

       })
    });  */

});

function check_bmi_rate(bmi_rate) {
    if (bmi_rate < 18.5) {
        $("#bmi_val").val("Under weight (" + bmi_rate.toFixed(2) + ")");
    } else if (bmi_rate >= 18.5 && bmi_rate <= 24.9) {
        $("#bmi_val").val("Normal weight (" + bmi_rate.toFixed(2) + ")");
    } else if (bmi_rate >= 25 && bmi_rate < 29.9) {
        $("#bmi_val").val("Over weight (" + bmi_rate.toFixed(2) + ")");
    } else if (bmi_rate >= 30) {
        $("#bmi_val").val("Obese");
    }
}