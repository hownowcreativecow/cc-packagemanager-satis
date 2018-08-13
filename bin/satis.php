<?php
/**
 * @copyright 2018 Creative Cow Limited
 */
declare(strict_types=1);

$rootDir = dirname(__DIR__);
chdir($rootDir);
require $rootDir . '/vendor/autoload.php';

$application = new Composer\Satis\Console\Application();
$application->run();
