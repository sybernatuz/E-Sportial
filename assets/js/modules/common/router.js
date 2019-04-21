/**
 * For now, we rely on the router.js script tag to be included
 * in the layout. This is just a helper module to get that object.
 */
const routes = require('../../../../public/js/fos_js_routes.json');
const router = require('../../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router');

router.setRoutingData(routes);
module.exports = router;