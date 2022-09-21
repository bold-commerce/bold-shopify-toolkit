<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->ignoreUnreadableDirs()
    ->notName('phpunit.xml')
    ->exclude(['.circleci','vendor'])
    ->in(__DIR__);

return (new Config)
    ->setUsingCache(true)
    ->setRules(array(
        '@PSR2' => true,
        '@Symfony' => true,
    ))
    ->setFinder($finder);
