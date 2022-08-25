<?php

declare(strict_types=1);

namespace controllers;

use Core\Controller;

class Project extends Controller
{

    public function __construct()
    {
        $this->projectModel = $this->model('Project');
    }

    public function addProject()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

        $data = json_decode(file_get_contents("php://input"));


        $title = $data->title;
        $description = $data->description;
        $display_color = $data->display_color;
        $start_date = $data->start_date;
        $end_date = $data->end_date;


        $results = $this->projectModel->insertProject($title, $description,$display_color,$start_date,$end_date);


        if ($results) {
            echo json_encode([
                'message' => 'Added project'
            ]);
        } else {
            echo json_encode([
                'message' => 'project Not Created'
            ]);
        }
    }

    public function getProjects()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $po =  $this->projectModel->readProjects();

        echo json_encode($po, JSON_PRETTY_PRINT);
    }

    public function readSingle()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json *');

        $post_id = isset($_GET['id']) ? $_GET['id'] : die('failed');

        $id = $this->projectModel->readProjectById($post_id);

        echo json_encode($id, JSON_PRETTY_PRINT);
    }
}
