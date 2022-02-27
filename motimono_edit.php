<!DOCTYPE html>
    <!--持ち物リスト「編集」リンクのジャンプ先-->
    <!--編集内容をフォームで入力する-->
    <!--入力後はupdate.phpにジャンプ-->
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>motimonoEdit</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
    </head>
     
    <body>
        <div id="wrap">
            <?php
            //DB接続設定
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
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                 
                    //編集選択機能
                    $sql = 'SELECT * FROM motimono WHERE id=:id AND email=:email';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                    $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                 
                    $newTitle = $results['title'];
                    $newId = $results['id'];
                    $newDate = $results['date'];
                    $newMemo = $results['memo'];
                }   
            ?>
         
            <!--編集内容の表示-->
            <form action="./update.php" method="post">
                <div>
                    <input type="hidden" name="email" value=<?php echo $email; ?> >
                    <label for="title">inventory<br></label>
                    <input id="title" type="text" name="title" value="<?php echo $newTitle; ?>">
                </div>
                <div>
                    <label for="date">date<br></label>
                    <input id="date" type="date" name="date" value="<?php echo $newDate; ?>">
                </div>
                <div>
                    <label for="memo">memo<br></label>
                    <input id="memo" type="text" name="memo" value="<?php echo $newMemo; ?>">
                </div>
                <div>
                    <input type="hidden" name="edit" value="<?php echo $newId; ?>">
                </div>
                <div>
                    <br><input id="submit" type="submit" name="editsub" value="送信">
                </div>    
            </form>
            <br>
            <a href=./index.php>メインページに戻る</a>
         
        </div><!--　wrap終わり　-->
        
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