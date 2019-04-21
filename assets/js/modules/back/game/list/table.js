const Routing = require('../../../common/router');

$(document).ready( function () {
    $('#game-table').DataTable({
        buttons: [
            {
                text: "<i class='material-icons left'>add</i>New",
                className: 'waves-effect waves-light btn',
                action: function ( e, dt, node, config ) {
                    window.location.href = Routing.generate('app_admin_game_new')
                }
            }
        ],
        columnDefs: [
            {
                targets: "no-sort",
                orderable: false
            }
        ]
    });

});