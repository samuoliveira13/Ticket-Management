<?php
  require_once('../database/database.connection.php');

  $db = getDatabaseConnection();

  $department = $_REQUEST['department_name'] ?? null;
  $user = $_REQUEST['name'] ?? null;
  $status = $_REQUEST['status'] ?? null;
  $priority = $_REQUEST['priority'] ?? null;

  $sql = "SELECT tickets.*, departments.department_name, users.name 
          FROM tickets 
          JOIN departments ON tickets.department_id = departments.department_id JOIN users ON users.id = tickets.user_id 
          WHERE assigned_to IS NULL ";

  $params = [];

  if (!empty($department)) {
    $sql .= "AND departments.department_name = :department_name ";
    $params['department_name'] = $department;
  }

  if (!empty($user)) {
    $sql .= "AND users.username = :user_name ";
    $params['user_name'] = $user;
  }

  if (!empty($status)) {
    $sql .= "AND tickets.status = :status ";
    $params['status'] = $status;
  }

  if (!empty($priority)) {
    $sql .= "AND tickets.priority = :priority ";
    $params['priority'] = $priority;
  }

  try {
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $filteredData = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($filteredData);
  } catch (PDOException $e) {
    echo json_encode(['error' => $e]);
  }
?>