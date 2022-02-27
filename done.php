<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>DONE</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
     
    <body>
        <?php
            //動作自体は（持ち物）削除処理と同じ
            //リストの「完了」リンクからのジャンプ先
             
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
            if(isset($_GET['id'])){
                $id=$_GET['id'];
                 
                $sql = 'DELETE FROM motimono WHERE id=:id AND email=:email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();
                 
                echo "完了しました<br>";
                echo "<a href='./index.php'>メインページへ戻る</a>";
            }
        ?>
    </body>
</html>