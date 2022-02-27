<?php
    define('DSN', 'データベース名');
    define('DB_USER', 'ユーザ名');
    define('DB_PASS', 'パスワード');
     
    //DBへの接続・設定
      
     //DB接続
    $dsn = 'データベース名';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     
    //持ち物：テーブル・カラム作成
    $sql = "CREATE TABLE IF NOT EXISTS motimono"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."email varchar(255),"
    ."title varchar(255),"
    ."date DATE,"
    ."memo TEXT"
    .");";
    $stmt = $pdo->query($sql);
     
    //TDL：テーブル・カラム作成  
    $sql = "CREATE TABLE IF NOT EXISTS todolist"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "email varchar(255),"
    . "title varchar(255),"
    . "due_date varchar(20),"
    . "status varchar(20),"
    . "memo TEXT,"
    . "created_at char(20),"
    . "updated_at char(20)"
    .");";
    $stmt = $pdo -> query($sql);
?>