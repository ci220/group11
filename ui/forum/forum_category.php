<?php
$title = "Forum Categories";
$css = [
    "css/styles.css",
    "css/forum.css"
];

$categories = [
    ["id" => 1, "name" => "Train Operations", "description" => "Discussions about train schedules, delays, and logistics."],
    ["id" => 2, "name" => "Stations", "description" => "Topics about station facilities, cleanliness, and management."],
    ["id" => 3, "name" => "Travel Tips", "description" => "Practical advice and tips for railway journeys."],
];

require 'forum_category_view.php';