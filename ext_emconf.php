<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Pdf generation',
    'description' => 'Pdf generation for various usages',
    'category' => 'misc',
	'author' => 'Peter Benke',
	'author_email' => 'info@typomotor.de',
    'state' => 'stable',
	'clearCacheOnLoad' => 0,
    'version' => '10.4.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
