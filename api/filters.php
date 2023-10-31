<?php
  require_once('../database/database.connection.php');

  $db = getDatabaseConnection();

  $department = $_REQUEST['department_name'] ?? null;
  $user = $_REQUEST['user'] ?? null;
  $date = $_REQUEST['date'] ?? null;
  $status = $_REQUEST['status'] ?? null;
  $priority = $_REQUEST['priority'] ?? null;

  $sql = "SELECT tickets.*, departments.department_name
          FROM tickets 
          JOIN departments ON tickets.department_id = departments.department_id JOIN users ON users.id = tickets.user_id 
          WHERE 1 = 1 ";

  $params = [];

  if (!empty($department)) {
    $sql .= "AND departments.department_name = :department_name ";
    $params['department_name'] = $department;
  }

  if (!empty($user)) {
    $sql .= "AND users.username = :name ";
    $params['name'] = $user;
  }

  if (!empty($date)) {
    $sql .= "AND tickets.date = :date ";
    $params['date'] = $date;
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