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
	'accordion-section' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/accordion-section',
		'version' => '0.1.0',
		'title' => 'Accordion Section',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			
		),
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'interactivity' => true
		),
		'textdomain' => 'accordion-section',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'big-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/big-card',
		'version' => '0.1.0',
		'title' => 'Big Card',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			'linkText' => array(
				'type' => 'string',
				'default' => 'Big Card'
			),
			'svgIcon' => array(
				'type' => 'string',
				'default' => '<svg width="63" height="74" viewBox="0 0 63 74" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_712_513)"><path d="M28.7266 56.3986H15.5693V72.6753H28.7266V56.3986Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M61.6938 72.6753H4.63247C0.200268 68.18 0.200268 60.8939 4.63247 56.3986H61.7025C57.2703 60.8939 57.2703 68.18 61.7025 72.6753H61.6938Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.2582 23.6952C21.0987 23.598 18.8347 23.7129 16.8929 26.5036C14.3764 30.1158 15.8392 35.1145 17.9987 39.071" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M41.1263 1.59851C41.1263 1.59851 35.684 0.105973 31.7395 4.10669C27.9603 7.9396 30.2853 12.5939 30.2853 12.5939C30.2853 12.5939 34.8742 14.9519 38.6534 11.119C42.5979 7.11827 41.1263 1.59851 41.1263 1.59851Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31.426 18.2991C31.426 14.0246 29.3797 8.1339 22.8054 4.39813" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M51.68 22.2645C45.2015 12.9648 36.5983 18.3256 31.426 18.3256C26.2536 18.3256 17.6505 12.9648 11.1719 22.2645C5.46842 30.4602 12.095 42.9834 17.1715 49.4305C21.5341 54.9767 25.0868 56.381 27.673 56.3898H27.6991C27.7688 56.3898 27.8384 56.3898 27.8994 56.3898H34.9439C35.0136 56.3898 35.0832 56.3898 35.1442 56.3898H35.1703C37.7565 56.381 41.3092 54.9767 45.6717 49.4305C50.7396 42.9834 57.3748 30.4514 51.6713 22.2645H51.68Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_712_513"><rect width="63" height="74" fill="white"/></clipPath></defs></svg>'
			),
			'linkURL' => array(
				'type' => 'string',
				'default' => ''
			),
			'backgroundColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'cardDescription' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'description' => 'A block for displaying important contacts.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'big-card',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
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
	'link-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'iowa-aea-theme/link-card',
		'version' => '0.1.0',
		'title' => 'Link Card',
		'category' => 'widgets',
		'icon' => 'smiley',
		'attributes' => array(
			'linkText' => array(
				'type' => 'string',
				'default' => 'Link Card'
			),
			'svgIcon' => array(
				'type' => 'string',
				'default' => '<svg width="63" height="74" viewBox="0 0 63 74" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_712_513)"><path d="M28.7266 56.3986H15.5693V72.6753H28.7266V56.3986Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M61.6938 72.6753H4.63247C0.200268 68.18 0.200268 60.8939 4.63247 56.3986H61.7025C57.2703 60.8939 57.2703 68.18 61.7025 72.6753H61.6938Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.2582 23.6952C21.0987 23.598 18.8347 23.7129 16.8929 26.5036C14.3764 30.1158 15.8392 35.1145 17.9987 39.071" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M41.1263 1.59851C41.1263 1.59851 35.684 0.105973 31.7395 4.10669C27.9603 7.9396 30.2853 12.5939 30.2853 12.5939C30.2853 12.5939 34.8742 14.9519 38.6534 11.119C42.5979 7.11827 41.1263 1.59851 41.1263 1.59851Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31.426 18.2991C31.426 14.0246 29.3797 8.1339 22.8054 4.39813" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M51.68 22.2645C45.2015 12.9648 36.5983 18.3256 31.426 18.3256C26.2536 18.3256 17.6505 12.9648 11.1719 22.2645C5.46842 30.4602 12.095 42.9834 17.1715 49.4305C21.5341 54.9767 25.0868 56.381 27.673 56.3898H27.6991C27.7688 56.3898 27.8384 56.3898 27.8994 56.3898H34.9439C35.0136 56.3898 35.0832 56.3898 35.1442 56.3898H35.1703C37.7565 56.381 41.3092 54.9767 45.6717 49.4305C50.7396 42.9834 57.3748 30.4514 51.6713 22.2645H51.68Z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_712_513"><rect width="63" height="74" fill="white"/></clipPath></defs></svg>'
			),
			'linkURL' => array(
				'type' => 'string',
				'default' => ''
			),
			'backgroundColor' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'description' => 'A block for displaying important contacts.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'link-card',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
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
