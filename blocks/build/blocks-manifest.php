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
	'event-calendar' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/event-calendar',
		'version' => '0.1.0',
		'title' => 'Event Calendar',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying a calendar of events.',
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'event-calendar',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
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
			'interactivity' => true
		),
		'textdomain' => 'events-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
	),
	'header-slider' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/header-slider',
		'version' => '0.1.0',
		'title' => 'Header Slider',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying a header slider.',
		'attributes' => array(
			'slides' => array(
				'default' => array(
					
				),
				'type' => 'array',
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'title' => array(
							'type' => 'string'
						),
						'content' => array(
							'type' => 'string'
						),
						'slide_label' => array(
							'type' => 'string'
						),
						'image' => array(
							'type' => 'string',
							'format' => 'uri'
						)
					),
					'required' => array(
						'image',
						'title',
						'slide_label'
					)
				)
			)
		),
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'header-slider',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
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
	'side-tab' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/side-tab',
		'version' => '0.1.0',
		'title' => 'Side Tab',
		'category' => 'widgets',
		'icon' => 'smiley',
		'parent' => array(
			'iowa-aea-theme/side-tabs'
		),
		'attributes' => array(
			'tabNumber' => array(
				'type' => 'number',
				'default' => 1
			),
			'backgroundColor' => array(
				'type' => 'string',
				'default' => '#f28b82'
			)
		),
		'description' => 'An individual tab block for use within the Side Tabs container.',
		'example' => array(
			
		),
		'supports' => array(
			'reusable' => false
		),
		'textdomain' => 'side-tab',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css'
	),
	'side-tabs' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/side-tabs',
		'version' => '0.1.0',
		'title' => 'Side Tabs',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A container block for side tabs with individual tab blocks.',
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
	),
	'staff-directory-search' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/staff-directory-search',
		'version' => '0.1.0',
		'title' => 'Staff Directory Search',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'A block for displaying a staff directory search.',
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'staff-directory-search',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
	)
);
