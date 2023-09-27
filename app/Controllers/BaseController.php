<?php

namespace App\Controllers;

use Core\App;
use Core\Request;
use Firebase\JWT\JWT;

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
        $value = Request::post('title');
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

    /*
     *
     * Authentication
     *
     * */
    public function register()
    {
        $name = Request::post('name');
        $email = Request::post('email');
        $password = password_hash(Request::post('password'),
            PASSWORD_DEFAULT);
        $params = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];
        if ($name == '' || $email == '' || $password == '') {
            echo noContentResponse();
        }
        if (APP::get('DB')->exists('users', $email)) {
            echo noContentResponse();
        } else {
            App::get('DB')->insert('users', $params);
        }
    }

    public function login()
    {
        $email = Request::post('email');
        $password = Request::post('password');
        $params = [
            'email' => $email,
            'password' => $password
        ];
        if ($params['email'] == '' || $params['password'] == '') {
            echo noContentResponse();
        }
        if (APP::get('DB')->exists('users', $email)) {
            $user = APP::get('DB')->findUser('users', $params['email']);
            if (password_verify($params['password'], $user[0]->password)) {
                session_start();
                $uniqueCode = bin2hex(random_bytes(16));
                $secret_key = $uniqueCode;
                $issuer_claim = "http://localhost:8088";
                $audience_claim = "http://localhost:3000";
                $issuedat_claim = time();
                $notbefore_claim = $issuedat_claim + 10;
                $expire_claim = $issuedat_claim + 60;
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "name" => $user[0]->password,
                        "email" => $user[0]->email
                    ));
                http_response_code(200);
                $jwt = JWT::encode($token, $secret_key, 'HS256');
                echo json_encode(
                    array(
                        "status" => 200,
                        "message" => "Successful login.",
                        "jwt" => $jwt,
                        "uniqueCode" => $secret_key,
                        "email" => $email,
                        "expireAt" => $expire_claim
                    ));
            } else {
                echo json_encode(
                    array(
                        "status" => 404,
                        "message" => "login Error",
                    ));
            }
        } else {
            echo noContentResponse();
        }
    }
    /*
     *
     * End Authentication
     *
     * */
}
