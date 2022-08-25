<?php

declare(strict_types=1);

namespace controllers;

use Core\Controller;

class Upcomings extends Controller
{

    public function __construct()
    {
        $this->upcomingModel = $this->model('Upcomings');
    }

    public function addUpcomingTask()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


        $data = json_decode(file_get_contents("php://input"));


        $title = $data->title;
        $project_id = $data->project_id;


        $results = $this->upcomingModel->insert($title, $project_id);


        if ($results) {
            echo json_encode([
                'message' => 'Added'
            ]);
        } else {
            echo json_encode([
                'message' => 'task Not Added'
            ]);
        }
    }

    public function getUpcomingTasks()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $po =  $this->upcomingModel->readUpcomings();

        echo json_encode($po, JSON_PRETTY_PRINT);
    }

    public function readSingle()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $post_id = isset($_GET['id']) ? $_GET['id'] : die('failed');

        $id = $this->upcomingModel->readUpcomingsById($post_id);

        echo json_encode($id, JSON_PRETTY_PRINT);
    }

    public function readSingleByProjectId()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json ');

        $project_id = isset($_GET['id']) ? $_GET['id'] : die('love');
        
        $id = $this->upcomingModel->readUpcomingsByProjectId($project_id );

        echo json_encode($id, JSON_PRETTY_PRINT);
    }

    public function updateUpcoming() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-type');

        $data = json_decode(file_get_contents("php://input"));

        $id = $data->id;

        $result = $this->upcomingModel->updateUpcoming($id);

        if ($result) {
            echo json_encode([
                'message' => 'Added to daily Tasks'
            ]);
        }else {
            echo json_encode([
                'message' => 'Something went wrong'
            ]);
        }
    }
    public function deleteUpcoming() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


        $data = json_decode(file_get_contents("php://input"));


        $id = $data->id;

        // echo json_encode($id);

        $results = $this->upcomingModel->deleteUpcoming($id);


        // if ($results) {
        //     echo json_encode([
        //         'message' => 'Task Deleted'
        //     ]);
        // } else {
        //     echo json_encode([
        //         'message' => 'Error Occured'
        //     ]);
        // }


    }
}
