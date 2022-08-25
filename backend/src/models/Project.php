<?php

declare(strict_types=1);

namespace models;

class Project
{

  public function add(array $data)
  {
    global $Db;
    $columns = implode(',', array_keys($data));
    $values = "'" . implode("','", array_values($data)) . "'";

    $sql = sprintf("INSERT INTO %s(%s) VALUES(%s)", 'project', $columns, $values);
    $result = $Db->query($sql) or die($Db->error);
    return $result;
  }

  public function insertProject($title, $description,$display_color, $start_date, $due_date): bool
  {
    if (isset($title, $description) && isset($start_date,  $due_date)) {
      $data = [
        "title" => htmlspecialchars(strip_tags($title)),
        "description" => htmlspecialchars(strip_tags($description)),
        "display_color" => htmlspecialchars(strip_tags($display_color)),
        "start_date" =>  htmlspecialchars(strip_tags($start_date)),
        "end_date" =>  htmlspecialchars(strip_tags($due_date))
      ];
    }

    return $this->add($data);
  }

  public function readProjects()
  {
    global $Db;
    $sql = "SELECT * FROM `project` ORDER BY `created_at` DESC";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
      }
    }
    return $projects ?? [];
  }

  public function readProjectById(string $id)
  {
    global $Db;
    $sql = "SELECT * FROM `project`WHERE `project_id` = '$id' LIMIT 1";
    $result = $Db->query($sql) or die($Db->error);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $upcoming[] = $row;
      }
    }
    return $upcoming ?? [];
  }
}