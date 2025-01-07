<?php
if (!isset($_SESSION['user_id'])) {
  setFlash('error', 'Please login to create a discussion');
  header('Location: /login');
  exit();
}

$title = "Create Discussion";
$css = [
  "../css/styles.css",
  "../css/forum.css"
];
$js = ["../js/discussion.js"];

require 'create_discussion_view.php';