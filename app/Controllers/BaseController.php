<?php

namespace App\Controllers;

use Core\App;

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
        $params = [
            'title' => $_POST['start'],
            'isDone' => 0,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        if ($_POST['start'] == '') {
            echo json_encode(0);
        }
        App::get('DB')->insert('tasks', $params);
        $latest = json_encode(App::get('DB')->latest('tasks'));
        echo json_decode($latest, true)[0]['id'];
    }

    public function updateTasks()
    {
        $params = [
            'title' => (empty($_POST['title'])) ? '' : trim(strip_tags($_POST['title'])),
        ];
        if (empty($params['title'])) {
            echo json_encode(0);
            exit(0);
        }
        return App::get('DB')->update('tasks', $params, $_POST['id']);
    }

    public function doneTasks()
    {
       return App::get('DB')->done('tasks', $_POST['id']);
    }

    public function deleteTasks()
    {
        if ($_POST['id'] == null) {
            echo json_encode(0);
            exit(0);
        }
        $id = trim(strip_tags($_POST['id']));
        $task = App::get('DB')->first('tasks', id: $id);
        if (!empty($task)) {
            App::get('DB')->delete('tasks', $id);
            echo json_encode(1);
            exit(0);
        }
        echo json_encode(0);
        exit(0);
    }
}
