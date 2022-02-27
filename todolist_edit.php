<!DOCTYPE html>
     <!--todo「編集」リンクのジャンプ先-->
     <!--編集作業までをこのリンクで行う-->
     <!--処理完了後は自動的にメインページへ転送-->
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
                //編集内容の表示
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                 
                    $stmt = $pdo->prepare('SELECT * FROM todolist WHERE email =:email AND id=:id');
                    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt -> execute();
                 
                    $results =$stmt -> fetch();
                 
                    //due_dateの処理
                    if($results['due_date']=="未定"){
                        $undec="undec";
                    }elseif(!empty($results['due_date'])){
                        $due_date=$results['due_date'];
                    }
                }
             
             
                //編集後データ書き込み
                if(isset($_POST["edit_submit"])){
                    $re_title=$_POST["title"];$re_status=$_POST["status"];
                    $re_memo=$_POST["memo"];$updated_at=date("Y-m-d H:i");
                }
             
                if(!empty($_POST["undecided"])){
                    $re_due_date=$_POST["undecided"];
                }elseif(!empty($_POST["pre_due_date"]) && empty($_POST["undecided"])){
                    $re_due_date=$_POST["pre_due_date"];
                }else{
                    $re_due_date="";
                }
             
                if(isset($_POST["edit_submit"]) && isset($re_due_date)){
                    $sql='UPDATE todolist SET title=:title, due_date=:due_date, status=:status, updated_at=:updated_at, memo=:memo WHERE id=:id AND email=:email';
                    $stmt=$pdo->prepare($sql);
                 
                    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                    $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                    $stmt->bindParam(':title',$re_title,PDO::PARAM_STR);
                    $stmt->bindParam(':due_date',$re_due_date,PDO::PARAM_STR);
                    $stmt->bindParam(':status',$re_status,PDO::PARAM_STR);
                    $stmt->bindParam(':updated_at',$updated_at,PDO::PARAM_STR);
                    $stmt->bindParam(':memo',$re_memo,PDO::PARAM_STR);
                 
                    $stmt->execute();
                 
                    $url="./index.php";
                    header("Location:".$url);
                    exit();
                }
            ?>
        
         
            <!--編集内容の表示-->
            <form action="" method="post">
                <div>
                    <input type="hidden" name="email" value=<?php echo $email; ?>>
                    <label>title<br></label>
                    <input  id="title" type="title" name="title" value=<?php echo $results['title']; ?>>
                </div>
                <div>
                    <label>due_date<br></label> 
                    <input  id="date" type="date" name="pre_due_date" value=<?php if(isset($due_date)){echo $due_date;} ?>><br>/
                    <label>undecided</label> 
                    <input type="checkbox" name="undecided" value="未定" <?php if(isset($undec)){echo "checked='checked'";} ?>>
                </div>
                <div>
                    <label>status<br></label> 
                    <select id="select" name="status">
                        <option value=""  <?php  if($results['status']==""){echo "selected";}?>>--choose an option--</option>
                        <option value="0：未着手" <?php if($results['status']=="0：未着手"){echo "selected";}?>>0：未着手</option>
                        <option value="1：まだまだ" <?php if($results['status']=="1：まだまだ"){echo "selected";}?>>1：まだまだ</option>
                        <option value="2：半分くらい" <?php if($results['status']=="2：半分くらい"){echo "selected";}?>>2：半分くらい</option>
                        <option value="3：もう少し" <?php if($results['status']=="3：もう少し"){echo "selected";}?>>3：もう少し</option>
                        <option value="4：達成！" <?php if($results['status']=="4：達成！"){echo "selected";}?>>4：達成！</option>
                    </select>
                </div>
                <div>
                    <label>memo<br></label>
                    <input id="memo" type="text" name="memo" value=<?php echo $results['memo'];?>>
                </div>
                <br>
                <input type="submit" name="edit_submit" id="submit">
            </form>
            <br>
            <a href=./index.php>メインページに戻る</a>
         
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