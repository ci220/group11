<?php
$title = "Home";
$css = [
    "css/styles.css",
    "css/home.css"
];
$js = [
    "js/script.js", 
    "js/components.js",
    "js/slider.js"
];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

// Fetch latest discussions
$latestDiscussions = $db->query(
    "SELECT d.*, u.username 
     FROM discussions d 
     JOIN users u ON d.user_id = u.id 
     ORDER BY d.date DESC 
     LIMIT 4"
)->fetchAll();


function timeAgo($datetime) {
  $now = new DateTime();
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
  if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
  if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
  if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
  if ($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
  return 'just now';
}

// Fetch categories with discussion counts
$categories = $db->query(
    "SELECT c.name, c.description, COUNT(d.id) as topic_count
     FROM (
         SELECT 'Train Operations' as name, 'Discussions about train schedules, delays, and logistics.' as description
         UNION ALL
         SELECT 'Stations', 'Topics about station facilities, cleanliness, and management.'
         UNION ALL
         SELECT 'Travel Tips', 'Practical advice and tips for railway journeys.'
     ) c
     LEFT JOIN discussions d ON d.category = c.name
     GROUP BY c.name, c.description"
)->fetchAll();

require 'home_page_view.php';