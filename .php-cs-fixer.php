<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('docker')
    ->exclude('tools')
    ->exclude('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    'blank_line_before_statement' => [
        'statements' => [
            'case',
            'continue',
            'declare',
            'default',
            'exit',
            'goto',
            'include',
            'include_once',
            'phpdoc',
            'require',
            'require_once',
            'return',
            'throw',
            'try',
        ],
    ],
    'braces' => [
        'allow_single_line_anonymous_class_with_empty_body' => true,
        'allow_single_line_closure' => true,
        'position_after_anonymous_constructs' => 'same',
        'position_after_control_structures' => 'same',
        'position_after_functions_and_oop_constructs' => 'next',
    ],
    'concat_space' => false,
    'declare_strict_types' => true,
    'ternary_to_null_coalescing' => true,
    'modernize_types_casting' => true,
])
    ->setFinder($finder)
    ->setUsingCache(false);
