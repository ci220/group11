<?php

session_start();

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'functions.php';

require basePath('core/Database.php');
require basePath('core/router/router.php');

unset($_SESSION['_flash']);

// $test = $db->query('SELECT * FROM users')->fetchAll();



