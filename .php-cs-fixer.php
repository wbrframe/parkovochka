<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src/')
    ->in(__DIR__.'/tests/')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'self_accessor' => false,
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => false,
        'no_empty_phpdoc' => false,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'none'],
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
    ])
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/var/.php-cs-fixer.cache')
;
