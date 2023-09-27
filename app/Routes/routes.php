<?php

/**
 * @var $router Core\Router
 */
$router->get('', 'BaseController@index');
$router->get('tasks', 'BaseController@indexTasks');
$router->post('tasks/store', 'BaseController@storeTasks');
$router->post('tasks/edit', 'BaseController@updateTasks');
$router->post('tasks/done', 'BaseController@doneTasks');
$router->post('tasks/delete', 'BaseController@deleteTasks');
$router->post('store/login', 'BaseController@login');
$router->post('store/register', 'BaseController@register');
