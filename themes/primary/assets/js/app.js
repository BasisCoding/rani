$(document).ready(function() {

    // Init Datepicker
    initDatepicker();

    // Init Datatable
    initDatatable();

    // Init Checkbox Group
    initCheckboxGroup();

    // Init Colorpicker
    initColorPicker();
});

function initDatepicker() {
    $('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });
}

function initSelect2() {
    $('.select2').select2();
}

function initDatatable() {
    // Setup - add a text input to each footer cell
    $('.datatable tfoot th').each( function() {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Cari '+title+'" />' );
    } );

    // DataTable
    var table = $('.datatable').DataTable({'theme':'bootstrap'});

    // Apply the search
    table.columns().every( function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if(that.search() !== this.value) {
                that
                    .search( this.value )
                    .draw();
            }
        });
    });

    $('.datatable').DataTable().columns(-1).order('desc').draw();
}

function initSummernote() {
    $(".summernote-simple").summernote({
       dialogsInBody: true,
      minHeight: 150,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['para', ['paragraph']]
      ]
    });
}

function initCheckboxGroup() {
    $("[data-checkboxes]").each(function() {
        var me     = $(this),
            group  = me.data('checkboxes'),
            role   = me.data('checkbox-role');

        me.change(function() {
            var all            = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
                checked        = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
                dad            = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
                total          = all.length,
                checked_length = checked.length;

            if(role == 'dad') {
                if(me.is(':checked')) {
                    all.prop('checked', true);
                }
                else {
                    all.prop('checked', false);
                }
            }
            else {
                if(checked_length >= total) {
                    dad.prop('checked', true);
                }
                else {
                    dad.prop('checked', false);
                }
            }
        });
    });
}

function initColorPicker() {
    $(".colorpickerinput").colorpicker({
        format: 'hex',
        component: '.input-group-append',
    });
}

$('[data-datemask]').toArray().forEach(function(field){
    new Cleave(field, {
        date: true,
        delimiter: '-',
        datePattern: ['Y', 'm', 'd']
    });
});

$('[data-phonemask]').toArray().forEach(function(field){
    new Cleave(field, {
        phone: true,
        phoneRegionCode: 'ID'
    });
});

$('[data-moneymask]').toArray().forEach(function(field){
    new Cleave(field, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
});
