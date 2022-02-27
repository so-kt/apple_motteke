    <!--カレンダー上の数字のジャンプ先：日付ごとのリスト表示-->

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>EACH DATE</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
     
    <body>
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
        
        <?php
                
            if(isset($_GET['date'])){
                $date = $_GET['date'];
                 
                //日付別検索持ち物編
                $sql = 'SELECT * FROM motimono WHERE email=:email AND date=:date';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->bindParam(':date',$date,PDO::PARAM_STR);
                $stmt->execute();
                 
                $md_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 
                //日付別検索todoリスト
                $stmt = $pdo->prepare('SELECT * FROM todolist WHERE email =:email AND due_date=:due_date');
                $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                $stmt -> bindParam(':due_date', $date, PDO::PARAM_STR);
                $stmt -> execute();
                 
                $td_results =$stmt -> fetchAll(PDO::FETCH_ASSOC);
            }
        ?>
         
        <!--持ち物リスト-->
        <div id="wrap">
        <!-- ログアウトのリンク-->
        <?php echo $link; ?>
        <h3><?php echo $date; ?>の持ち物</h3>
        
        <div class="content-table"> 
            <table class="table-list">
                <tr>
                    <th class="heading-list">inventory</th>
                    <th class="heading-list">date</th>
                    <th class="heading-list">memo</th>
                    <th class="heading-list">edit</th>
                    <th class="heading-list">delete</th>
                    <th class="heading-list">done</th>
                </tr>
                             
                <?php foreach($md_results as $row){ ?>
                    <tr>
                        <td class="cell-list">
                            <?= htmlspecialchars($row['title'],ENT_QUOTES); ?>
                        </td>
                        <td class="cell-list">
                            <?= htmlspecialchars($row['date'],ENT_QUOTES); ?>
                        </td>
                        <td class="cell-list">
                            <?= htmlspecialchars($row['memo'],ENT_QUOTES); ?>
                        </td>
                        <td class="cell-list">
                            <a href="./motimono_edit.php?id=<?php echo $row['id'] ?>"><span class="material-icons-outlined">edit</span></a>
                        </td>
                        <td class="cell-list">
                            <a href="./delete.php?type=m&id=<?php echo $row['id'] ?>" onclick="return checkDel()"><span class="material-icons-outlined">delete</span></a>
                        </td>
                        <td class="cell-list">
                            <a href="./done.php?id=<?php echo $row['id'] ?>" onclick="return checkDone()"><span class="material-icons-outlined">done</span></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
         
        <!--ToDoList表示-->
        <div id="todolist">
                     
            <!--ToDoリスト表示-->
            <div class="content-table"> 
                <table class="table-list">
                    <tr>
                        <th class="heading-list">title</th>
                        <th class="heading-list">due_date</th>
                        <th class="heading-list">status</th>
                        <th class="heading-list">memo</th>
                        <th class="heading-list">created_at</th>
                        <th class="heading-list">updated_at</th>
                        <th class="heading-list">edit</th>
                        <th class="heading-list">delete</th>
                    </tr>
                             
                    <?php foreach($td_results as $row){ ?>
                        <tr>
                            <td class="cell-list">
                                <?php if($row['title']==""){echo "（不明）";}else{echo $row['title'];} ?>
                            </td>
                            <td class="cell-list">
                                <?php if($row['due_date']==""){echo "（不明）";}else{echo $row['due_date'];} ?>
                            </td>
                            <td class="cell-list">
                                <?php if($row['status']==""){echo "（不明）";}else{echo $row['status'];} ?>
                            </td>
                            <td class="cell-list">
                                <?php if($row['memo']==""){echo "（不明）";}else{echo $row['memo'];}?>
                            </td>
                            <td class="cell-list">
                                <?php echo $row['created_at']; ?>
                            </td>
                            <td class="cell-list">
                                <?php if($row['updated_at']==""){echo "変更なし";}else{echo $row['updated_at'];} ?>
                            </td>
                            <td class="cell-list">
                                <a href="./todolist_edit.php?id=<?php echo $row['id'] ?>" ><span class="material-icons-outlined">edit</span></a>
                            </td>
                            <td class="cell-list">
                                <a href="./delete.php?type=t&id=<?php echo $row['id'] ?>" onclick ="return checkDel()"><span class="material-icons-outlined">delete</span></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div><!-- content-table 終わり-->
        </div>
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