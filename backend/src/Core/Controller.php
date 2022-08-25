<?php 
declare(strict_types=1);
namespace Core;

use models\Todays as Todays;
use models\Upcomings as Upcomings;
use models\Project;




Class Controller {

    public function model($model) {

        if ($model == "Todays") {
		    require_once './src/models/'.'Todays.php';
		    return new Todays(); 

        }else if ($model == "Upcomings") {
            require_once './src/models/'.'Upcomings.php';
		    return new Upcomings(); 
            
        }else if ($model == "Project") {
            require_once './src/models/'.'Project.php';
		    return new Project(); 

        }

	}

    
}