$(document).ready( function () {
    $('#user-table').DataTable({
        buttons: [],
        columnDefs: [
            {
                targets: "no-sort",
                orderable: false
            }
        ],
    });
});