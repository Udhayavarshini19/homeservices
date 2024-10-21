<?php

require_once 'session.php';
require_once 'DB.php';
require_once 'helpers.php';

if (isset($_POST['login'])) {
    $input = clean($_POST);

    $contact = $input['contact'];
    $password = $input['password'];

    if ($contact == "0909" && $password == "admin123") {
        $s = new stdClass();
        $s->name = "admin";
        $_SESSION['user'] = $s;

        header('Location: ../admin.php');
        exit();
    } else {
        $stmt = DB::query(
            "SELECT * FROM providers WHERE contact=? AND password=?",
            [$contact , $password]
        );
        $provider = $stmt->fetch(PDO::FETCH_OBJ);

        if (isset($provider)) {
            $_SESSION['user'] = $provider;
    
            $_SESSION['provider_id'] = $provider->id;
            header('Location: ../provider_dashboard.php');
            exit();
        } else {
            header('Location: ../login.php?msg=failed');
            exit();
        }
    }
}
