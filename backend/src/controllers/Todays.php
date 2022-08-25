<?php

declare(strict_types=1);

namespace controllers;

use Core\Controller;

class Todays extends Controller
{

    public function __construct()
    {
        $this->todaysModel = $this->model('Todays');
    }

    public function addTodayTask()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

        $data = json_decode(file_get_contents("php://input"));


        $title = $data->title;
        $project_id = $data->project_id;


        $results = $this->todaysModel->insert($title, $project_id);


        if ($results) {
            echo json_encode([
                'message' => "Added to Today's task"
            ]);
        } else {
            echo json_encode([
                'message' => 'Task Not Added'
            ]);
        }
    }

    public function getDailyTasks()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $po =  $this->todaysModel->readDailyTasks();

        echo json_encode($po, JSON_PRETTY_PRINT);
    }

    public function readSingle()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json *');

        $post_id = isset($_GET['id']) ? $_GET['id'] : die('failed');
   

        $id = $this->todaysModel->readDailyTaskByProjectId($post_id);

        echo json_encode($id, JSON_PRETTY_PRINT);
    }

    public function deleteDaily() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

        $data = json_decode(file_get_contents("php://input"));


        $id = $data->id;


        $results = $this->todaysModel->deleteDaily($id);


        if ($results) {
            echo json_encode([
                'message' => "Daily task has been deleted"
            ]);
        } else {
            echo json_encode([
                'message' => 'Task Not Added'
            ]);
        }

    }
    public function completeTask(){

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

        $data = json_decode(file_get_contents("php://input"));

        $id = $data->id;


        $result =  $this->todaysModel->completeTask($id);

        if ($result) {
            echo json_encode([
                'message' => 'Task Completed'
            ]);
        }else {
            echo json_encode([
                'message' => 'Something went wrong'
            ]);
        }

    }
}
