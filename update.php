<!DOCTYPE html>
    <!--motimono_editページからジャンプ-->
    <!--持ち物リストの編集作業-->
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>UPDATE</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
     
    <body>
        <div id="wrap">
        <?php
            require_once('./config.php');
            session_start();
            if(empty($_SESSION['EMAIL'])){
                header("Location:./top.php");
                exit();
            }else{
                $username = $_SESSION['name'];
                $email = $_SESSION['EMAIL'];
                $link = '<a href="logout.php">ログアウト</a>';
                $msg = 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さん';
                $email = htmlspecialchars($email, \ENT_QUOTES, 'UTF-8');
            }
        ?>
         
        <!-- ウェルカムメッセージ-->
        <h1><?php echo $msg; ?></h1>
         
        <!-- ログアウトのリンク-->
        <?php echo $link; ?>
         
        <?php
            //持ち物リスト編集の実行画面
             
            if(!empty($_POST['edit'])){
                $id = $_POST['edit'];
                $email=$_POST['email'];
                $title = $_POST['title'];
                $date = $_POST['date'];
                $memo = $_POST['memo'];
                //編集実行機能    
                $sql = 'UPDATE motimono SET title=:title,date=:date,memo=:memo WHERE id=:id AND email=:email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title',$title,PDO::PARAM_STR);
                $stmt->bindParam(':date',$date,PDO::PARAM_STR);
                $stmt->bindParam(':memo',$memo,PDO::PARAM_STR);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                 
                $stmt->execute();
                 
                echo "データが更新されました<br>";
                echo "<a href='./index.php'>持ち物リストへ戻る</a>";
            }
        ?>
        </div>
        <!--javascriptリンク始まり--> 
            <script type="text/javascript" src="index.js"></script>
        <!--javascriptリンク終わり-->
         
        <!--  footer始まり -->
        <footer>
            <small>2021  team APPLE</small>
        </footer>
        <!--  footer終わり -->
    </body>
</html>