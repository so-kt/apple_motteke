<?php
    //フォームからの投稿を記録 --> リストアップまで
    //持ち物・todo・日付検索共にここで処理
     
    require_once("./config.php");
     
    //motimono投稿機能
    if(!empty($_POST["title"]) &&isset($_POST["submit"])){
        $sql = $pdo -> prepare("INSERT INTO motimono(email,title,date,memo) VALUES(:email,:title,:date,:memo)");
        $sql -> bindParam(':email',$email,PDO::PARAM_STR);
        $sql -> bindParam(':title',$title,PDO::PARAM_STR);
        $sql -> bindParam(':date',$date,PDO::PARAM_STR);
        $sql -> bindParam(':memo',$memo,PDO::PARAM_STR);
         
        $email = $_POST["email"];    
        $title = $_POST["title"];//タイトル
        $date = $_POST["date"];//日付
        $memo = $_POST["memo"];//メモ
         
        $sql -> execute();
    }
     
    //todolistの投稿機能
    if(isset($_POST["t_submit"]) ){
        $email = $_POST["email"]; $title = $_POST["title"];
        $status = $_POST["status"]; $memo = $_POST["memo"];$date=date("Y-m-d H:i");    
    }
     
    //due_dateへの統一
    if(empty($_POST["pre_due_date"]) && !empty($_POST["undecided"])){
        $due_date = $_POST["undecided"];
    }elseif(!empty($_POST["pre_due_date"])){
        $due_date = $_POST["pre_due_date"];
    }else{
        $due_date = "";
    }
     
    //投稿データの書き込み
    if(isset($_POST["t_submit"]) && isset($due_date)){
        $sql=$pdo -> prepare("INSERT INTO todolist (email, title, due_date, status, memo, created_at) VALUES (:email, :title, :due_date, :status, :memo, :created_at)");
            
        $sql -> bindParam(':email', $email, PDO::PARAM_STR);
        $sql -> bindParam(':title', $title, PDO::PARAM_STR);
        $sql -> bindParam(':due_date', $due_date, PDO::PARAM_STR);
        $sql -> bindParam(':status', $status, PDO::PARAM_STR);
        $sql -> bindParam(':memo', $memo, PDO::PARAM_STR);
        $sql -> bindParam(':created_at', $date, PDO::PARAM_STR);
         
        $sql -> execute();
    }
        
    //持ち物を日付別で検索
    if(!empty($_POST['datespe'])){
        $dateSpe = $_POST['datespe'];
        $stmt = $pdo->prepare('SELECT * FROM motimono WHERE email =:email');
        $stmt -> bindParam(':name', $email, PDO::PARAM_STR);
         
        $stmt -> execute();
            
        $d_m_results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
     
    //持ち物表示機能
    $stmt = $pdo->prepare('SELECT * FROM motimono WHERE email =:email');
    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
    $stmt -> execute();
     
    $m_results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
      
    //todo表示機能
    $stmt = $pdo->prepare('SELECT * FROM todolist WHERE email =:email');
    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
     
    $stmt -> execute();
    $t_results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
?>