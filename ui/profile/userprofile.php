<?php

$title = 'User Profile';
$css = ["css/styles.css"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}
  
  $user = $db->query(
      'SELECT first_name, second_name, username, email, profile_picture 
       FROM users 
       WHERE id = ?', 
      [$_SESSION['user_id']]
  )->fetch();


  if (!$user) {
      setFlash('error', 'User not found');
      abort(404);
  }


require 'userprofile_view.php';



