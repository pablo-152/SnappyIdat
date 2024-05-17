/* ------------------------------------------------------------------------------
*
*  # Fixed Columns extension for Datatables
*
*  Specific JS code additions for datatable_extension_fixed_columns.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        columnDefs: [{ 
            orderable: false,
            width: '100px'/*,
            targets: [ 5 ]*/
        }],
        dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        }
    });


    // Left fixed column example
    $('.datatable-fixed-left').DataTable({
        columnDefs: [
            { 
                orderable: false,
                targets: [5]
            },
            { 
                width: "200px",
                targets: [0]
            },
            { 
                width: "300px",
                targets: [1]
            },
            { 
                width: "200px",
                targets: [5, 6]
            },
            { 
                width: "100px",
                targets: [4]
            }
        ],
        scrollX: true,
        scrollY: '100%',
        scrollCollapse: true,
        fixedColumns: true
    });

    $(function() {


        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            columnDefs: [{ 
                orderable: false,
                width: '100px',
                targets: [ 5 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });
    
    
        // Single row selection
        var singleSelect = $('.datatable-selection-single').DataTable();
        $('.datatable-selection-single tbody').on('click', 'tr', function() {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
            }
            else {
                singleSelect.$('tr.success').removeClass('success');
                $(this).addClass('success');
            }
        });
    
    
        // Multiple rows selection
        $('.datatable-selection-multiple').DataTable();
        $('.datatable-selection-multiple tbody').on('click', 'tr', function() {
            $(this).toggleClass('success');
        });
    
    
        // Individual column searching with text inputs
        $('.datatable-column-search-inputs tfoot td').not(':last-child').each(function () {
            var title = $('.datatable-column-search-inputs thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control input-sm" placeholder="Search '+title+'" />');
        });
        var table = $('.datatable-column-search-inputs').DataTable();
        table.columns().every( function () {
            var that = this;
            $('input', this.footer()).on('keyup change', function () {
                that.search(this.value).draw();
            });
        });
    
    
    
    
    
        // External table additions
        // ------------------------------
    
        // Add placeholder to the datatable filter option
        $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');
    
    
        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    
    
        // Enable Select2 select for individual column searching
        $('.filter-select').select2();
        
    });


    // Right fixed column example
    $('.datatable-fixed-right').DataTable({
        columnDefs: [
            { 
                orderable: false,
                targets: [5]
            },
            { 
                width: "300px",
                targets: [0]
            },
            { 
                width: "300px",
                targets: [1]
            },
            { 
                width: "200px",
                targets: [5, 6]
            },
            { 
                width: "100px",
                targets: [3, 4]
            }
        ],
        scrollX: true,
        scrollY: '350px',
        scrollCollapse: true,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        }
    });


    // Left and right fixed columns
    $('.datatable-fixed-both').DataTable({
        columnDefs: [
            { 
                orderable: false,
                targets: [ 5 ]
            },
            { 
                width: "200px",
                targets: [0]
            },
            { 
                width: "100px",
                targets: [1]
            },
            { 
                width: "200px",
                targets: [5, 6]
            },
            { 
                width: "100px",
                targets: [4]
            }
        ],
        scrollX: true,
        scrollY: '350px',
        scrollCollapse: true,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        }
    });


    //
    // Fixed column with complex headers
    //
    
    // Initialize
    var table = $('.datatable-fixed-complex').DataTable({
        autoWidth: false,
        columnDefs: [
            { 
                orderable: false,
                targets: [5]
            },
            { 
                width: "250px",
                targets: [0]
            },
            { 
                width: "250px",
                targets: [1]
            },
            { 
                width: "200px",
                targets: [5, 6]
            },
            { 
                width: "100px",
                targets: [4]
            }
        ],
        scrollX: true,
        scrollY: '350px',
        scrollCollapse: true,
        fixedColumns: true
    });

    // Adjust columns on window resize
    setTimeout(function() {
        $(window).on('resize', function () {
            table.columns.adjust();
        });
    }, 100);



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
    
});
