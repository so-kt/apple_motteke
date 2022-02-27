<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>DELETE</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
     
    <body>
        <?php
        //持ち物・todoリストの削除処理
        //リストの「削除」リンクからのジャンプ先
         
        //セッション処理
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
            //持ち物リストの削除
            if(isset($_GET['id']) && $_GET['type']=="m"){
                $id=$_GET['id'];
                 
                $sql = 'DELETE FROM motimono WHERE id=:id AND email=:email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();
                 
                echo "持ち物リストからデータが削除されました。"."<br>";
                echo "<a href='./index.php'>メインページに戻る</a>";
            }
             
            //todolistの削除
            if(isset($_GET['id']) && $_GET['type']=="t"){
                $id=$_GET['id'];
                 
                $sql = 'DELETE FROM todolist WHERE id=:id AND email=:email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();
                 
                echo "ToDoリストからデータが削除されました。"."<br>";
                echo "<a href='./index.php'>メインページに戻る</a>";
            }
        ?>
    </body>
</html>