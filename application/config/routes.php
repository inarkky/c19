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
	 * DEFINE ROUTES FOR DATASET
	*/
	'dataset/list' => [
		'controller' => 'commands',
		'action' => 'list',
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
	 * AJAX ROUTES FOR SOCIAL NETWORKS
	 * e.g. TWITTER & REDDIT NEWSFEED
	 */
	'api/status/twitter' => [
		'controller' => 'social',
		'action' => 'twitter',
	],
	'api/status/reddit' => [
		'controller' => 'social',
		'action' => 'reddit',
	],

	/** 
	 * MATH TESTING ROUTES
	 */
	'math' => [
		'controller' => 'statistics',
		'action' => 'index',
	],
];