<?php

declare(strict_types=1); 

namespace models;

class Upcomings
{

  public function add(array $data)
  {
    global $Db;
    $columns = implode(',', array_keys($data));
    $values = "'" . implode("','", array_values($data)) . "'";

    $sql = sprintf("INSERT INTO %s(%s) VALUES(%s)", 'upcomings', $columns, $values);
    $result = $Db->query($sql) or die($Db->error);
    return $result;
  }

  public function insert(string $title, string $project_id): bool
  {
    if (isset($title) && isset($project_id)) {
      $data = [
        "title" => htmlspecialchars(strip_tags($title)),
        "project_id" => htmlspecialchars(strip_tags($project_id))
      ];
    }

    return $this->add($data);
  }

  public function readUpcomings()
  {
    global $Db;
    $sql = "SELECT * FROM `upcomings` ORDER BY `created_at` DESC";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $upcomings[] = $row;
      }
    }
    return $upcomings ?? [];
  }

  public function readUpcomingsById(string $id)
  {
    global $Db;
    $sql = "SELECT * FROM `upcomings`WHERE `id` = '$id' LIMIT 1";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $upcoming[] = $row;
      }
    }
    return $upcoming ?? [];
  } 

  public function readUpcomingsByProjectId(string $id)
  {
    global $Db;
    $sql = "SELECT * FROM `upcomings` WHERE `project_id` = '$id' AND `waiting` = 1 ORDER BY `created_at` ASC";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $upcoming[] = $row;
      }
    }
    return $upcoming ?? [];
  }

  public function updateUpcoming(string $id) {
    global $Db;

    $sql = "UPDATE `upcomings` SET 
              `approved`= 1,
              `waiting`= 0
               WHERE `id` = '$id'";
    $result = $Db->query($sql);
     if (!$result) {
       die($Db->error);
     }

    return $result;
	}

  public function deleteUpcoming(string $id){
    global $Db;
    $sql = "DELETE FROM `upcomings` WHERE `id` = '$id'"; 
    $result = $Db->query($sql) or die($Db->error);
    return $result;
  }

}
