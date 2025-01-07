<?php

function dd($data) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';

  die();
}

function urlIs($value) {
  return $_SERVER['REQUEST_URI'] === $value;
}

function basePath($path) {
  return BASE_PATH . $path;
}

function setFlash($key, $message){
  $_SESSION['_flash'][$key] = $message;
}

function getFlash($key){
  if(isset($_SESSION['_flash'][$key])){
    $msg = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);
    return $msg;
  }
  return null;
}

function hasFlash($key){
  return isset($_SESSION['_flash'][$key]) && !empty($_SESSION['_flash'][$key]);
}


function logout(){
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort(405);
  }

  try {
    // Clear all session data
    $_SESSION = array();

    // If it's desired to destroy the session cookie as well
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    setFlash('success', 'You have been logged out successfully.');
    header('Location: /login');
    exit();
} catch (Exception $e) {
    setFlash('error', 'An error occurred during logout.');
    header('Location: /');
    exit();
}
}