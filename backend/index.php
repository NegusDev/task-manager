<?php
require_once 'src/require.php';

use controllers\Project;
use controllers\Todays as Today;
use controllers\Upcomings as Upcoming;
use Core\Router;


$router  = new Router();
$today = new Today();
$upcoming = new Upcoming();
$project = new Project();


$router::get('/', function () {
    
    echo json_encode([
        "message" => "WELCOME TO PROJECT MANAGER"
    ]);
});

// Upcomings
$router::get('/upcoming', function () {
    global $upcoming;

    return $upcoming->getUpcomingTasks();
});
$router::post('/upcoming', function () {
    global $upcoming;

    $upcoming->addUpcomingTask();
});

// SINGLE 
$router::get('/upcoming_single', function () {
    global $upcoming;

    $upcoming->readSingle();
});
$router::post('/delete', function () {
    global $upcoming;

    $upcoming->deleteUpcoming();
});


// MOVE TO DAILY TASKS
$router::post('/upcoming_update', function(){
    global $upcoming;

    $upcoming->updateUpcoming();
});



// dailytasks
$router::get('/dailytasks', function () {
    global $today;

    return $today->getDailyTasks();
});
$router::get('/daily_single', function () {
    global $today;

    return $today->readSingle();
});
$router::post('/dailytasks', function () {
    global $today;

    return $today->addTodayTask();
});
$router::post('/delete_daily', function () {
    global $today;

    $today->deleteDaily();
});
$router::post('/complete_task', function() {
    global $today;

    $today->completeTask();
});



// PROJECT
$router::get('/projects', function () {
    global $project;

    return $project->getProjects();
});
$router::get('/project_single', function () {
    global $project;

    return $project->readSingle();
});
$router::post('/projects', function () {
    global $project;

    return $project->addProject();
});
$router::get('/upcoming_project', function () {
    global $upcoming;

    return $upcoming->readSingleByProjectId();
});



