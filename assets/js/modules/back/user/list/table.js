$(document).ready( function () {
    $('#user-table').DataTable({
        columnDefs: [
            {
                targets: "no-sort",
                orderable: false
            }
        ],
    });
});