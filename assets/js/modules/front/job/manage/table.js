$(document).ready( function () {
    $('#job-table').DataTable();
});

$(".add").click(function () {
   window.location.href = "/job/new";
});