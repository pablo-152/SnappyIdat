function fnFormatDetails(table_id, html) {

    var sOut = "<table id=\"exampleTable_" + table_id + "\">";

    sOut += html;
    sOut += "</table>";
    return sOut;
}
var iTableCounter = 1;
var oTable;
var oInnerTable;
var TableHtml;

//Run On HTML Build
$(document).ready(function () {

    TableHtml = $('#exampleTable_2').html();

    //Insert a 'details' column to the table
    var nCloneTh = document.createElement('th');
    var nCloneTd = document.createElement('td');

    $('#exampleTable thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

    //Initialse DataTables, with no sorting on the 'details' column
    var oTable = $('#exampleTable').dataTable({
      dom: 'ftipr',
            'bJQueryUI': true,

            'sPaginationType': 'full_numbers',
            'aoColumnDefs': [{
                    'bSortable': false,
                    'class': 'details-control',
                    'aTargets': [0]
                }
            ],
            'aaSorting': [[1, 'asc']]
        });

    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
    $('#exampleTable tbody tr td.details-control').on('click', function () {
        var nTr = $(this).closest('tr');

        if (oTable.fnIsOpen(nTr)) {

            oTable.fnClose(nTr);
        } else {
            oTable.fnOpen(nTr, fnFormatDetails(iTableCounter, TableHtml), 'details-control');
            oInnerTable = $('#exampleTable_' + iTableCounter).dataTable({
              orderCellsTop: true,
              fixedHeader: true,
              dom: '',
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers'
                });
            iTableCounter = iTableCounter + 1;

        }
    });
    

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function () {
        // Enumerate all rows
        oTable.$('tr').each(function(index, nTr){              
            // If row has details expanded
            if (oTable.fnIsOpen(nTr)) {
                oTable.fnClose(nTr);
                $(nTr).removeClass('shown');
            }
        });
    });

    $('#btn-show-all-children').on('click', function () {
        // Enumerate all rows              
        oTable.$('tr').each(function(index, nTr){
            // If row has details collapsed
            if (!oTable.fnIsOpen(nTr)) {
                /* Open this row */
                oTable.fnOpen(nTr, fnFormatDetails(iTableCounter, TableHtml), 'details-control');
                $(nTr).addClass('shown');
            }
        });
    });      
});


//--------------------------------------------------------------------------------------------------------------------------------
function fnFormatDetails2(table_id, html) {
    var sOut = "<table id=\"exampleTable2_" + table_id + "\">";

    sOut += html;
    sOut += "</table>";
    return sOut;
}
var iTableCounter = 1;
var oTable;
var oInnerTable;
var TableHtml;

//Run On HTML Build
$(document).ready(function () {

    TableHtml = $('#exampleTable_3').html();

    //Insert a 'details' column to the table
    var nCloneTh = document.createElement('th');
    var nCloneTd = document.createElement('td');

    $('#exampleTable2 thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

    //Initialse DataTables, with no sorting on the 'details' column
    var oTable = $('#exampleTable2').dataTable({
      dom: 'ftipr',
            'bJQueryUI': true,

            'sPaginationType': 'full_numbers',
            'aoColumnDefs': [{
                    'bSortable': false,
                    'class': 'details-control',
                    'aTargets': [0]
                }
            ],
            'aaSorting': [[1, 'asc']]
        });

   
    $('#exampleTable2 tbody tr td.details-control').on('click', function () {
        var nTr = $(this).closest('tr');

        if (oTable.fnIsOpen(nTr)) {

            oTable.fnClose(nTr);
        } else {
            oTable.fnOpen(nTr, fnFormatDetails2(iTableCounter, TableHtml), 'details-control');
            oInnerTable = $('#exampleTable2_' + iTableCounter).dataTable({
              orderCellsTop: true,
              fixedHeader: true,
              dom: '',
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers'
                });
            iTableCounter = iTableCounter + 1;

        }
    });
    

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function () {
        // Enumerate all rows
        oTable.$('tr').each(function(index, nTr){              
            // If row has details expanded
            if (oTable.fnIsOpen(nTr)) {
                oTable.fnClose(nTr);
                $(nTr).removeClass('shown2');
            }
        });
    });

    $('#btn-show-all-children').on('click', function () {
        // Enumerate all rows              
        oTable.$('tr').each(function(index, nTr){
            // If row has details collapsed
            if (!oTable.fnIsOpen(nTr)) {
                
                oTable.fnOpen(nTr, fnFormatDetails2(iTableCounter, TableHtml), 'details-control');
                $(nTr).addClass('shown2');
            }
        });
    });      
});
//--------------------------------------------------------------------------------------------------------------------------------
function fnFormatDetails3(table_id, html) {
    var sOut = "<table id=\"exampleTable3_" + table_id + "\">";

    sOut += html;
    sOut += "</table>";
    return sOut;
}
var iTableCounter = 1;
var oTable;
var oInnerTable;
var TableHtml;

//Run On HTML Build
$(document).ready(function () {

    TableHtml = $('#exampleTable_4').html();

    //Insert a 'details' column to the table
    var nCloneTh = document.createElement('th');
    var nCloneTd = document.createElement('td');

    $('#exampleTable3 thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

    //Initialse DataTables, with no sorting on the 'details' column
    var oTable = $('#exampleTable3').dataTable({
      dom: 'ftipr',
            'bJQueryUI': true,

            'sPaginationType': 'full_numbers',
            'aoColumnDefs': [{
                    'bSortable': false,
                    'class': 'details-control',
                    'aTargets': [0]
                }
            ],
            'aaSorting': [[1, 'asc']]
        });

   
    $('#exampleTable3 tbody tr td.details-control').on('click', function () {
        var nTr = $(this).closest('tr');

        if (oTable.fnIsOpen(nTr)) {

            oTable.fnClose(nTr);
        } else {
            oTable.fnOpen(nTr, fnFormatDetails3(iTableCounter, TableHtml), 'details-control');
            oInnerTable = $('#exampleTable3_' + iTableCounter).dataTable({
              orderCellsTop: true,
              fixedHeader: true,
              dom: '',
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers'
                });
            iTableCounter = iTableCounter + 1;

        }
    });
    

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function () {
        // Enumerate all rows
        oTable.$('tr').each(function(index, nTr){              
            // If row has details expanded
            if (oTable.fnIsOpen(nTr)) {
                oTable.fnClose(nTr);
                $(nTr).removeClass('shown3');
            }
        });
    });

    $('#btn-show-all-children').on('click', function () {
        // Enumerate all rows              
        oTable.$('tr').each(function(index, nTr){
            // If row has details collapsed
            if (!oTable.fnIsOpen(nTr)) {
                
                oTable.fnOpen(nTr, fnFormatDetails3(iTableCounter, TableHtml), 'details-control');
                $(nTr).addClass('shown3');
            }
        });
    });      
});
//--------------------------------------------------------------------------------------------------------------------------------
function fnFormatDetails4(table_id, html) {
    var sOut = "<table id=\"exampleTable4_" + table_id + "\">";

    sOut += html;
    sOut += "</table>";
    return sOut;
}
var iTableCounter = 1;
var oTable;
var oInnerTable;
var TableHtml;

//Run On HTML Build
$(document).ready(function () {

    TableHtml = $('#exampleTable_5').html();

    //Insert a 'details' column to the table
    var nCloneTh = document.createElement('th');
    var nCloneTd = document.createElement('td');

    $('#exampleTable4 thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

    //Initialse DataTables, with no sorting on the 'details' column
    var oTable = $('#exampleTable4').dataTable({
      dom: 'ftipr',
            'bJQueryUI': true,

            'sPaginationType': 'full_numbers',
            'aoColumnDefs': [{
                    'bSortable': false,
                    'class': 'details-control',
                    'aTargets': [0]
                }
            ],
            'aaSorting': [[1, 'asc']]
        });

   
    $('#exampleTable4 tbody tr td.details-control').on('click', function () {
        var nTr = $(this).closest('tr');

        if (oTable.fnIsOpen(nTr)) {

            oTable.fnClose(nTr);
        } else {
            oTable.fnOpen(nTr, fnFormatDetails4(iTableCounter, TableHtml), 'details-control');
            oInnerTable = $('#exampleTable4_' + iTableCounter).dataTable({
              orderCellsTop: true,
              fixedHeader: true,
              dom: '',
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers'
                });
            iTableCounter = iTableCounter + 1;

        }
    });
    

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function () {
        // Enumerate all rows
        oTable.$('tr').each(function(index, nTr){              
            // If row has details expanded
            if (oTable.fnIsOpen(nTr)) {
                oTable.fnClose(nTr);
                $(nTr).removeClass('shown4');
            }
        });
    });

    $('#btn-show-all-children').on('click', function () {
        // Enumerate all rows              
        oTable.$('tr').each(function(index, nTr){
            // If row has details collapsed
            if (!oTable.fnIsOpen(nTr)) {
                
                oTable.fnOpen(nTr, fnFormatDetails4(iTableCounter, TableHtml), 'details-control');
                $(nTr).addClass('shown4');
            }
        });
    });      
});
//--------------------------------------------------------------------------------------------------------------------------------
function fnFormatDetails5(table_id, html) {
    var sOut = "<table id=\"exampleTable5_" + table_id + "\">";

    sOut += html;
    sOut += "</table>";
    return sOut;
}
var iTableCounter = 1;
var oTable;
var oInnerTable;
var TableHtml;

//Run On HTML Build
$(document).ready(function () {

    TableHtml = $('#exampleTable_6').html();

    //Insert a 'details' column to the table
    var nCloneTh = document.createElement('th');
    var nCloneTd = document.createElement('td');

    $('#exampleTable5 thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

    //Initialse DataTables, with no sorting on the 'details' column
    var oTable = $('#exampleTable5').dataTable({
      dom: 'ftipr',
            'bJQueryUI': true,

            'sPaginationType': 'full_numbers',
            'aoColumnDefs': [{
                    'bSortable': false,
                    'class': 'details-control',
                    'aTargets': [0]
                }
            ],
            'aaSorting': [[1, 'asc']]
        });

   
    $('#exampleTable5 tbody tr td.details-control').on('click', function () {
        var nTr = $(this).closest('tr');

        if (oTable.fnIsOpen(nTr)) {

            oTable.fnClose(nTr);
        } else {
            oTable.fnOpen(nTr, fnFormatDetails5(iTableCounter, TableHtml), 'details-control');
            oInnerTable = $('#exampleTable5_' + iTableCounter).dataTable({
              orderCellsTop: true,
              fixedHeader: true,
              dom: '',
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers'
                });
            iTableCounter = iTableCounter + 1;

        }
    });
    

    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function () {
        // Enumerate all rows
        oTable.$('tr').each(function(index, nTr){              
            // If row has details expanded
            if (oTable.fnIsOpen(nTr)) {
                oTable.fnClose(nTr);
                $(nTr).removeClass('shown5');
            }
        });
    });

    $('#btn-show-all-children').on('click', function () {
        // Enumerate all rows              
        oTable.$('tr').each(function(index, nTr){
            // If row has details collapsed
            if (!oTable.fnIsOpen(nTr)) {
                
                oTable.fnOpen(nTr, fnFormatDetails5(iTableCounter, TableHtml), 'details-control');
                $(nTr).addClass('shown5');
            }
        });
    });      
});