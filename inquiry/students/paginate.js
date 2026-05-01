jQuery(document).ready(function() {
    var table = jQuery('#example').dataTable({
        "bProcessing": true,
        "sAjaxSource": "pagination_data.php",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 5,
        "bLengthChange": false,
        "bFilter": false,
        "aoColumns": [
            { mData: 'Sr.no' },
            { mData: 'inquiry Id' },
            { mData: 'First Name' },
            { mData: 'middle Name' },
            { mData: 'Last Name' },
            { mData: 'Gender' },
            { mData: 'Mobile Number 1' },
            { mData: 'Mobile Number 2' },
            { mData: 'Email' },
            { mData: 'Faculty Name' },
            { mData: 'Level Name' },
            { mData: 'Program Name' },
            { mData: 'Last Exam' },
            { mData: 'Last Exam Status' },
            { mData: 'Status' },
            { mData: 'Inquiry Mode' },
            { mData: 'Assign Staff' },
            { mData: 'Counselor' },
            { mData: 'Remarks' },
            { mData: 'Action' }
        ]
    });
});