<?php

$finder = PhpCsFixer\Finder::create()
	->ignoreUnreadableDirs()
	->notName('phpunit.xml')
	->exclude(['.circleci','vendor'])
	->in(__DIR__);

return PhpCsFixer\Config::create()
	->setUsingCache(true)
    ->setRules(array(
        '@PSR2' => true,
        '@Symfony' => true,
    ))
    ->setFinder($finder)
;
