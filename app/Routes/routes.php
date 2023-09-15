<?php

/**
 * @var $router Core\Router
 */
$router->get('', 'BaseController@index');
$router->get('api/tasks', 'BaseController@indexTasks');
$router->post('api/tasks/store', 'BaseController@storeTasks');
$router->post('api/tasks/edit', 'BaseController@updateTasks');
$router->post('api/tasks/done', 'BaseController@doneTasks');
$router->post('api/tasks/delete', 'BaseController@deleteTasks');
