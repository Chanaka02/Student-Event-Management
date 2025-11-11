<?php
require_once __DIR__.'/db.php';

function get_events(){
    $pdo = getPDO();
    $stmt = $pdo->query('SELECT * FROM events ORDER BY date');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_event($id){
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM events WHERE event_id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function create_event($title,$date,$venue,$desc){
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO events (title,date,venue,description) VALUES (?,?,?,?)');
    return $stmt->execute([$title,$date,$venue,$desc]);
}

function update_event($id,$title,$date,$venue,$desc){
    $pdo = getPDO();
    $stmt = $pdo->prepare('UPDATE events SET title=?,date=?,venue=?,description=? WHERE event_id=?');
    return $stmt->execute([$title,$date,$venue,$desc,$id]);
}

function delete_event($id){
    $pdo = getPDO();
    $stmt = $pdo->prepare('DELETE FROM events WHERE event_id=?');
    return $stmt->execute([$id]);
}

function get_registrations($event_id){
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM registrations WHERE event_id = ? ORDER BY timestamp DESC');
    $stmt->execute([$event_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function register_attendee($event_id,$name,$student_id,$email,$contact){
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO registrations (event_id,name,student_id,email,contact) VALUES (?,?,?,?,?)');
    return $stmt->execute([$event_id,$name,$student_id,$email,$contact]);
}
