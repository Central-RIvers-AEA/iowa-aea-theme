<?php
// This file is generated. Do not modify it manually.
return array(
	'accordion' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/accordion',
		'version' => '0.1.0',
		'title' => 'Accordion',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			'sections' => array(
				'type' => 'array',
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'title' => array(
							'type' => 'string',
							'source' => 'html'
						),
						'content' => array(
							'type' => 'string',
							'source' => 'html',
							'default' => '<p>Default content for section</p>'
						)
					)
				)
			)
		),
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'accordion',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'interactive-map' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/interactive-map',
		'version' => '0.1.0',
		'title' => 'Interactive Map',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'interactive-map',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'side-tabs' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/side-tabs',
		'version' => '0.1.0',
		'title' => 'Side Tabs',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			'titleOne' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-header-one'
			),
			'tabContentOne' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-content-one'
			),
			'titleTwo' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-header-two'
			),
			'tabContentTwo' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-content-two'
			),
			'titleThree' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-header-three'
			),
			'tabContentThree' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-content-three'
			),
			'titleFour' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-header-four'
			),
			'tabContentFour' => array(
				'type' => 'string',
				'source' => 'html',
				'selector' => '.tab-content-four'
			)
		),
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'side-tabs',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);
