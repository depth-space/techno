<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP80Migration:risky' => true,
        '@PHP82Migration' => true,
        'echo_tag_syntax' => [
            'format' => 'short',
        ],
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'mb_str_functions' => true,
        'nullable_type_declaration' => [
            'syntax' => 'question_mark',
        ],
        'ordered_interfaces' => [
            'order' => 'alpha',
        ],
        'increment_style' => [
            'style' => 'post',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ]
    ])
    ->setFinder($finder);
