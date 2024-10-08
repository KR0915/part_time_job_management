<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/part_time_worker/part_time_workers/login', array('controller' => 'part_time_workers', 'action' => 'login'));
	
	Router::connect('/part_time_worker/attendances/index/:id', 
    array('controller' => 'attendances', 'action' => 'index'), 
    array('pass' => array('id'), 'id' => '[0-9]+')
	);

	
	Router::connect('/part_time_worker/part_time_workers/workHistory/:id', 
		array('controller' => 'part_time_workers', 'action' => 'workHistory'), 
		array('pass' => array('id'), 'id' => '[0-9]+')
	);


	Router::connect('/part_time_worker/attendances/submitTimesheet/:workerId', array('controller' => 'attendances', 'action' => 'submitTimesheet'), array('pass' => array('workerId'), 'workerId' => '[0-9]+'));

	Router::connect('/attendances/calendar/:workerId', array('controller' => 'attendances', 'action' => 'calendar'));

	Router::connect(
		'/attendances/getTimesheet/:workerId/:date',
		array('controller' => 'attendances', 'action' => 'getTimesheet'),
		array(
			'pass' => array('workerId', 'date'),
			'workerId' => '[0-9]+',
			'date' => '[0-9]{4}-[0-9]{2}-[0-9]{2}'
		)
	);

	Router::connect(
		'/part_time_worker/attendances/editSubmittedTimesheet/:workerId/:date',
		array('controller' => 'attendances', 'action' => 'editSubmittedTimesheet'),
		array(
			'pass' => array('workerId', 'date'),
			'workerId' => '[0-9]+',
			'date' => '[0-9]{4}-[0-9]{2}-[0-9]{2}'
		)
	);
	
	CakePlugin::routes();

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
