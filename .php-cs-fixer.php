<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->exclude('vendor');

return (new Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        'align_multiline_comment' => ['comment_type'=>'phpdocs_like'],
        'array_indentation' => false,
        'phpdoc_to_comment' => ['allow_before_return_statement' => true, 'ignored_tags' => ['var']],
        'array_syntax' => ['syntax' => 'short'],  // Обязательная запятая после каждого элемента многострочного массива, даже после последней строки
        'binary_operator_spaces' => [
            'default' => 'single_space',  // Обязательный одиночный пробел вокруг операторов (==, &&, …)
        ],
        'blank_line_before_statement' => [
            'statements' => ['break', 'case', 'continue', 'declare', 'default', 'do', 'exit', 'for', 'foreach', 'goto', 'if', 'include', 'include_once', 'phpdoc', 'require', 'require_once', 'return', 'switch', 'throw', 'try', 'while', 'yield', 'yield_from'],  // Обязательная пустая строка перед return, если return не является единственной строкой в блоке
        ],
        'braces_position' => true,
        'class_attributes_separation' => [
            'elements' => ['method' => 'one'],
        ],
        'class_definition' => [
            'single_line' => true,  // Родительский класс и список реализуемых интерфейсов перечисляются в одной строке с именем класса
        ],
        'concat_space' => ['spacing' => 'one'],
        'control_structure_braces' => true,
        'echo_tag_syntax' => [
            'format' => 'short',
        ],
        'no_mixed_echo_print' => ['use' => 'print'],
        'global_namespace_import' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'new_with_parentheses' => true,  // При создании объектов всегда используются круглые скобки, даже если в конструкторе нет аргументов
        'no_alternative_syntax' => [
            'fix_non_monolithic_code' => false,
        ],
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'allow_hidden_params' => true,
            'remove_inheritdoc' => false,
        ],
        'no_useless_else' => true,
        'no_unused_imports' => true,  // Удаление неиспользуемых импортов
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'method_public',
                'method_protected',
                'method_private',
            ],
            'sort_algorithm' => 'none',
        ],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'phpdoc_order' => true,  // Группируем аннотации таким образом, чтобы аннотации одного типа шли подряд
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',  // Если внутри тэгов PHPDoc, таких как @param или @return присутствуют типы null и прочие, всегда помещаем null в конец списка тип
        ],
        'phpdoc_align' => false,
        'phpdoc_summary' => false,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_no_alias_tag' => [
            'replacements' => [
                'type' => 'var',
                'link' => 'see',
            ],
        ],
        'phpdoc_add_missing_param_annotation' => false,
        'semicolon_after_instruction' => false,
        'single_import_per_statement' => true,  // Выражение use используется для каждого класса
        'single_quote' => true,  // Использование одинарных кавычек вместо двойных, если не требуется интерполяция
        'single_blank_line_at_eof' => true,
        'single_line_throw' => false,
        'spaces_inside_parentheses' => [
            'space' => 'none',
        ],  // Пробелы не используются внутри скобок [ и ]
        'trailing_comma_in_multiline' => true,
        'types_spaces' => [
            'space_multiple_catch' => 'single',
        ],
        'yoda_style' => false,
        'unary_operator_spaces' => true,
        'visibility_required' => [
            'elements' => ['method', 'property'],
        ],
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);
