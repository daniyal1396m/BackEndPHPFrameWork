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
            'title' => (empty($_POST['title'])) ? '' : trim(strip_tags($_POST['title'])),
            'isDone' => 0,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        if (empty($params['title'])) {
            return false;
        }
        if (App::get('DB')->insert('tasks', $params)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTasks(): bool
    {
        $params = [
            'title' => (empty($_POST['title'])) ? '' : trim(strip_tags($_POST['title'])),
        ];
        if (empty($params['title'])) {
            return false;
        }
        if (App::get('DB')->update('tasks', $params, $_POST['id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function doneTasks(): bool
    {
        $params = [
            'status' => 1
        ];
        if (App::get('DB')->update('tasks', $params, $_POST['id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteTasks()
    {
        if ($_POST['id'] == null) {
            return false;
        }
        $id = trim(strip_tags($_POST['id']));
        $task = App::get('DB')->first('tasks', id: $id);
        if (!empty($task)) {
            App::get('DB')->delete('tasks', $id);
            return true;
        }
        return false;
    }
}
