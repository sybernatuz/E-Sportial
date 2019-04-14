$(document).ready( function () {
    $('#game-table').DataTable({
        columnDefs: [
            {
                targets: "no-sort",
                orderable: false
            }
        ]
    });

});