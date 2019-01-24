<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 09:22
 */


if (isset($_ENV['BOOTSTRAP_RESET_DATABASE']) && $_ENV['BOOTSTRAP_RESET_DATABASE'] == true) {
    initDatabase();
}
require __DIR__ . './../../vendor/autoload.php';

function initDatabase()
{
    echo "Resetting test database ...";
    passthru(sprintf(
        'php "%s/../../bin/console" doctrine:schema:drop --env=test --force --no-interaction',
        __DIR__
    ));
    passthru(sprintf(
        'php "%s/../../bin/console" doctrine:schema:update --env=test --force --no-interaction',
        __DIR__
    ));
    passthru(sprintf(
        'php "%s/../../bin/console" doctrine:fixtures:load --group=test --env=test --no-interaction',
        __DIR__
    ));
    echo "Done" . PHP_EOL . PHP_EOL;
}