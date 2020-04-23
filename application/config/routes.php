<?php

return [

	/**
	 * DASHBOARD
	 */
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],

	/**
	 * DEFINE ROUTES FOR STATISTICS
	 */
	'statistics' => [
		'controller' => 'statistics',
		'action' => 'index',
	],

	/**
	 * DEFINE ROUTES FOR EXPORT
	 */
	'export' => [
		'controller' => 'export',
		'action' => 'index',
	],
	'export/download' => [
		'controller' => 'export',
		'action' => 'download',
	],

	/**
	 * DEFINE ROUTES FOR TEMPLATE
	 */
	'template' => [
		'controller' => 'template',
		'action' => 'index',
	],
	'template/element/add' => [
		'controller' => 'template',
		'action' => 'add',
	],
	'template/element/remove' => [
		'controller' => 'template',
		'action' => 'remove',
	],

	/** 
	 * DEFINE ROUTES FOR DATASET
	 */
	'dataset' => [
		'controller' => 'commands',
		'action' => 'index',
	],
	'dataset/get' => [
		'controller' => 'commands',
		'action' => 'get',
	],
	'api/dataset/setup' => [
		'controller' => 'commands',
		'action' => 'setup',
	],
	'api/dataset/update' => [
		'controller' => 'commands',
		'action' => 'update',
	],
	'api/dataset/parse' => [
		'controller' => 'commands',
		'action' => 'parse',
	],
	'api/dataset/edit' => [
		'controller' => 'commands',
		'action' => 'edit',
	],
	'api/dataset/purge' => [
		'controller' => 'commands',
		'action' => 'purge',
	],

	/**
	 * SETTINGS
	 */
	'setting' => [
		'controller' => 'setting',
		'action' => 'index',
	],
	'setting/update' => [
		'controller' => 'setting',
		'action' => 'update',
	],

	/** 
	 * AJAX ROUTES FOR SOCIAL NETWORKS
	 * e.g. TWITTER NEWSFEED
	 */
	'api/status/twitter' => [
		'controller' => 'social',
		'action' => 'twitter',
	],

	/** 
	 * MATH TESTING ROUTES
	 */
	'math' => [
		'controller' => 'statistics',
		'action' => 'index',
	],
];