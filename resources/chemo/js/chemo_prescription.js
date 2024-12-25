function calculate_total_val() {
    var qnt_dose = $('#quantity_dose').val();
    var freq_dur = $('#freq_dur :selected').text();
    var duration = $('#duration').val();
    var time = $('#time :selected').val();
    var total = 1;
    if (qnt_dose != "" && parseFloat(qnt_dose) != 1) {
        total *= parseInt(qnt_dose);
    }
    if (freq_dur == "BD") {
        total *= 2;
    } else if (freq_dur == "TDS") {
        total *= 3;
    } else if (freq_dur == "QID") {
        total *= 4;
    }

    if (duration != '' && parseFloat(duration) != 1) {
        total *= duration;
    }
    if (time != '' && parseFloat(time) != 1) {
        total *= time;
    }
    $('#total_quantity').val(total);
    $('#total_quantity_hidden').val(total);
    // alert();
    // alert("***"+qnt_dose+"***"+freq_dur+"***"+duration+"***"+time);

}
let notes_val;
BalloonEditor
    .create(document.querySelector('#notes'), {})
    .then(case_history_text => {
        notes_val = case_history_text;
    })
    .catch(error => {
        console.log(error);
    });
$('#chemo_prescription').on('submit', function() {
    $('#notes_val').val(notes_val.getData());
    return true;
});

function add_row(e) {
    e.preventDefault();
    var medicine_table_data = $('#table_row').val();
    var medicine_id = $('#medicine_id').val();
    var drug_name = $('#search_field').val();
    var qnt_dose = $('#quantity_dose').val();
    var freq_dur = $('#freq_dur :selected').text();
    var freq_dur_val = $('#freq_dur').val();
    var duration = $('#duration').val();
    var quantity = $('#total_quantity_hidden').val();
    var time = $('#time :selected').text();
    var time_val = $('#time').val();
    var instruction = $('#instruction').val();
    var remarks = $('#remarks').val();
    var medicine_html = $('#medicine_data').html();
    var str = "";
    if (drug_name == "") {
        $.toast({
            heading: "Warning",
            text: 'Drug name is required.',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#search_field').focus();
    } else if (medicine_html.includes(medicine_id)) {
        $.toast({
            heading: "Warning",
            text: 'Duplicate Drug!.',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#search_field').focus();
    } else if (qnt_dose == "") {
        $.toast({
            heading: "Warning",
            text: 'Qnt/Dose field is required',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#quantity_dose').focus();
    } else if (freq_dur_val == "") {
        $.toast({
            heading: "Warning",
            text: 'Freq./Dur field is required',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#freq_dur').focus();
    } else if (duration == "") {
        $.toast({
            heading: "Warning",
            text: 'Duration field is required.',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#duration').focus();
    } else if (time_val == "" || time_val == "0") {
        $.toast({
            heading: "Warning",
            text: 'Duration time field is required.',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#time').focus();
    } else if (quantity == "") {
        $.toast({
            heading: "Warning",
            text: 'Quantity field is required.',
            showHideTransition: "fade",
            position: "top-right",
            icon: "error",
            loader: false
        });
        $('#total_quantity').focus();
    } else {
        if (medicine_table_data == "0") {
            str += '<thead>' +
                '<tr>' +
                '<th>Drug Name</th>' +
                '<th class="text-right">Qnt/Dose</th>' +
                '<th>Freq./Dur.</th>' +
                '<th class="text-right">Total Qnt</th>' +
                '<th>Instruction</th>' +
                '<th>Remarks</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="medicine_table_body">';
        }
        str += '<tr>' +
            '<td>' + drug_name + '</td>' +
            '<input type="hidden" name="drug_id[]" value="' + medicine_id + '">' +
            '<td class="text-right">' + qnt_dose + '</td>' +
            '<input type="hidden" name="qnt_dose[]" value="' + qnt_dose + '">' +
            '<td>' + freq_dur + " " + duration + " " + time + '</td>' +
            '<input type="hidden" name="duration[]" value="' + duration + '">' +
            '<input type="hidden" name="time[]" value="' + time + '">' +
            '<input type="hidden" name="freq_dur[]" value="' + freq_dur_val + '">' +
            '<td class="text-right">' + parseFloat(quantity).toFixed(2) + '</td>' +
            '<input type="hidden" name="quantity[]" value="' + quantity + '">' +
            '<td>' + instruction + '</td>' +
            '<input type="hidden" name="instruction[]" value="' + instruction + '">' +
            '<td>' + remarks + '</td>' +
            '<input type="hidden" name="remarks[]" value="' + remarks + '">' +
            '<td><button type="button" onclick="delete_tr(event,this)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Delete</button></td>' +
            '</tr>';
        if (medicine_table_data == "0") {
            str += '</tbody>';
            $('#medicine_data').append(str);
        } else {
            $('#medicine_data > #medicine_table_body').append(str);
        }

        $('#table_row').val(parseFloat(medicine_table_data) + 1);
        $('#search_field').val('');
        $('#quantity_dose').val('');
        $('#freq_dur').val('').change();
        $('#duration').val('');
        $('#time').val('').change();
        $('#time').val('0').change();
        $('#instruction').val('');
        $('#remarks').val('');
        $('#total_quantity').val('');
    }

}

function delete_tr(e, data) {
    swal({
            title: "Warning!",
            text: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false,
        },
        function(isConfirm) {
            if (isConfirm) {
                var medicine_table_data = $('#table_row').val();
                var count = parseFloat(medicine_table_data) - 1;
                $('#table_row').val(count);
                if (count == 0)
                    $('#medicine_data').html('');
                $(data).closest('tr').remove();
                swal({
                    title: "Deleted!",
                    text: "Successfully deleted.",
                    type: "success"
                });
            } else {
                swal("Cancelled", "", "error");
                e.preventDefault();
            }
        });

}


function validateForm(e) {
    var medicine_count = $("#medicine_table_body tr").length;
    if (medicine_count <= 0) {
        swal("Warning!", "Please add medicines", "error");
        return false;
    } else {
        return true;
    }
}

$(function() {
    'use strict';
    $('[data-toggle="push-menu"]').pushMenu('toggle');

    $('#quantity_dose').on('keyup', function() {
        calculate_total_val();
    });

    $('#freq_dur').on('change', function() {
        var freq_dur = $(this).val();
        if (freq_dur == 'ZXp2WkR4UFFISG53RWwxdDlscUQzQT09') {
            $("#total_quantity").prop("disabled", false);
        } else {
            $("#total_quantity").prop("disabled", true);
        }
        calculate_total_val();
    });

    $('#duration').on('keyup', function() {
        calculate_total_val();
    });

    $('#time').on('change', function() {
        calculate_total_val();
    });

    $.widget('custom.tableAutocomplete', $.ui.autocomplete, {
        options: {
            open: function(event, ui) {
                $('.ui-autocomplete .ui-menu-item:first').trigger('mouseover');
            },
            focus: function(event, ui) {
                event.preventDefault();
            }
        },
        _create: function() {
            this._super();

            this.widget().menu("option", "items", ".ui-menu-item");
        },
        _renderMenu: function(ul, items) {
            var self = this;
            var $table = $('<table class="table-autocomplete table-striped table-hover chemoprescription" style="border-collapse: collapse;border:1px solid black!important">'),
                $thead = $('<thead>'),
                $headerRow = $('<tr>'),
                $tbody = $('<tbody>');

            $.each(self.options.columns, function(index, columnMapping) {
                $('<th>').text(columnMapping.title).appendTo($headerRow);
            });

            $thead.append($headerRow);
            $table.append($thead);
            $table.append($tbody);

            ul.html($table);

            $.each(items, function(index, item) {
                self._renderItemData(ul, ul.find("table tbody"), item);
            });
        },
        _renderItemData: function(ul, table, item) {
            return this._renderItem(table, item).data("ui-autocomplete-item", item);
        },
        _renderItem: function(table, item) {
            var self = this;
            var $tr = $('<tr class="ui-menu-item" role="presentation">');

            $.each(self.options.columns, function(index, columnMapping) {
                var cellContent = !item[columnMapping.field] ? '' : item[columnMapping.field];
                $('<td>').text(cellContent).appendTo($tr);
            });

            return $tr.appendTo(table);
        }
    });
});

$(function() {
    $('input#search_field').tableAutocomplete({
        source: result_sample,
        columns: [{
            field: 'value',
            title: 'Drug Name'
        }, {
            field: 'strength',
            title: 'Strength'
        }, {
            field: 'routes',
            title: 'Routes'
        }, {
            field: 'packsize',
            title: 'Pack Size'
        }, {
            field: 'quantity',
            title: 'Current Stock'
        }],
        delay: 500,
        select: function(event, ui) {
            if (ui.item != undefined) {
                $(this).val(ui.item.value + " " + ui.item.strength);
                $('#medicine_id').val(ui.item.id);
                // $('#selected_id').val(ui.item.id);
                // $('#selected_id').val(ui.item.id);
            }
            return false;
        }
    });
});