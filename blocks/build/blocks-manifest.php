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
	'bread-crumbs' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/bread-crumbs',
		'version' => '0.1.0',
		'title' => 'Bread Crumbs',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying breadcrumb navigation.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'bread-crumbs',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'events-list' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/events-list',
		'version' => '0.1.0',
		'title' => 'Events List',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying a list of events.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'events-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'important-contacts' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/important-contacts',
		'version' => '0.1.0',
		'title' => 'Important Contacts',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			'contacts' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'description' => 'A block for displaying important contacts.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'important-contacts',
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
	'page-children' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/page-children',
		'version' => '0.1.0',
		'title' => 'Page Children',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying page children.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'page-children',
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
