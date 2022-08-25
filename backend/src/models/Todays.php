<?php

declare(strict_types=1);

namespace models;

class Todays
{

  public function add(array $data)
  {
    global $Db;
    $columns = implode(',', array_keys($data));
    $values = "'" . implode("','", array_values($data)) . "'"; 

    $sql = sprintf("INSERT INTO %s(%s) VALUES(%s)", 'todays', $columns, $values);
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

  public function readDailyTasks()
  {
    global $Db;
    $sql = "SELECT * FROM `todays`";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $upcomings[] = $row;
      }
    }
    return $upcomings ?? [];
  }

  public function readDailyTaskById(string $id)
  {
    global $Db;

    $sql = "SELECT * FROM `todays`WHERE `id` = '$id'";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $daily[] = $row;
      }
    }
    return $daily ?? [];
  }

  public function readDailyTaskByProjectId(string $id)
  {
    global $Db;
    $today = date('d');

    $sql = "SELECT * FROM `todays` 
                  WHERE `project_id` = '$id' 
                  AND DAY(created_at) = '$today'
                  AND `completed` = 0 ";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $daily[] = $row;
      }
    }
    return $daily ?? [];
  }

  public function deleteDaily(string $id) {
    global $Db;
    $sql = "DELETE FROM `todays` WHERE `id` = '$id'"; 
    $result = $Db->query($sql) or die($Db->error);
    return $result;
  }

  public function completeTask(string $id){
    global $Db;

    $sql = "UPDATE `todays` SET 
              `completed`= 1
               WHERE `id` = '$id'";
    $result = $Db->query($sql);
    if (!$result) {
    die($Db->error);
    }

    return $result;

  }

}
