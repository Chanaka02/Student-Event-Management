<?php
// Run once to create an admin user. Remove after use.
require_once __DIR__.'/../src/db.php';
if(PHP_SAPI === 'cli'){ echo "Run this from browser"; exit; }
try{
  $pdo = getPDO();
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users'); $stmt->execute();
  $c = $stmt->fetchColumn();
  if($c==0){
    $h = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)')
        ->execute(['Admin','admin@example.com',$h,'admin']);
    echo "Admin created: admin@example.com / admin123 — remove this file after use.";
  } else { echo "Users exist; setup skipped."; }
}catch(Exception $e){ echo "Error: ".$e->getMessage(); }
