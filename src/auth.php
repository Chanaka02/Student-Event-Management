<?php
session_start();
require_once __DIR__ . '/db.php';

function current_user(){
    return $_SESSION['user'] ?? null;
}

function require_login(){
    if(!current_user()){
        $_SESSION['redirect_message'] = 'Please log in to access this page.';
        header('Location: ../public/login.php?redirect=1'); 
        exit;
    }
}

function login_user($email, $password){
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if($u && password_verify($password, $u['password'])){
        unset($u['password']);
        $_SESSION['user'] = $u;
        return true;
    }
    return false;
}

function logout(){ session_destroy(); }
