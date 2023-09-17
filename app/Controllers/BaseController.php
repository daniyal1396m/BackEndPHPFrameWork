<?php

namespace App\Controllers;

use Core\App;
use Core\Request;

class BaseController
{
    public function index()
    {
        return view('main.index');
    }

    public function indexTasks()
    {
        $tasks = App::get('DB')->selectAll('tasks');
        return jsonResponse($tasks);
    }

    public function storeTasks()
    {
        $value = Request::post('start');
        $params = [
            'title' => $value,
            'isDone' => 0,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        if ($value == '') {
            echo noContentResponse();
        }
        App::get('DB')->insert('tasks', $params);
        $latest = json_encode(App::get('DB')->latest('tasks'));
        echo json_decode($latest, true)[0]['id'];
    }

    public function updateTasks()
    {
        $value = Request::post('title');

        $params = [
            'title' => (empty($value)) ? '' : trim(strip_tags($value)),
        ];
        if (empty($value)) {
            echo noContentResponse();
        }
        return App::get('DB')->update('tasks', $params, Request::post('id'));
    }

    public function doneTasks()
    {
       return App::get('DB')->done('tasks', Request::post('id'));
    }

    public function deleteTasks()
    {
        $value =Request::post('id');
        if ($value == null) {
            echo noContentResponse();
        }
        $id = trim(strip_tags($value));
        $task = App::get('DB')->first('tasks', id: $id);
        if (!empty($task)) {
            App::get('DB')->delete('tasks', $id);
            echo json_encode(1);
            exit(0);
        }
        echo noContentResponse();
    }
}
