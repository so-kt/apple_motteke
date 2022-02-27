<!DOCTYPE html> 
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>MOTTEKE_Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
     
    <body id="index">
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
           
        <!--  header始まり-->
        <header>
            <div class="logo">
                <a href="index.php"><img src="MOTTEKE_logo.jpg" alt="MOTTEKE"></a>
            </div>
            <nav>
                <ul class="global-nav">
                    <li><a href="#call_inventory">InventoryList</a></li>
                    <li><a href="#call_todo">ToDoList</a></li>
                    <li><a href="#call_calendar">Calendar</a></li>
                </ul>
            </nav>
        </header>
        <!--  header終わり-->
         
         
        <!--  wrap始まり -->
        <div id="wrap">
            <!-- ウェルカムメッセージ-->
            <h1><?php echo $msg; ?></h1>
             
            <!-- ログアウトのリンク-->
            <?php echo $link; ?>
            <?php require_once("list_up.php"); //フォーム内容の記録・リストアップ ?>
            <?php require_once("calendar.php"); //カレンダー機能 ?>
            <br>
            <br>
              
            <!--持ち物リスト始まり-->
            <div id="motimono">
                <h1 id="call_inventory">InventoryList</h1>
                <div class="contents-list flex-reverse">
                    <div class="content-form">
                          
                        <!--持ち物登録フォーム--> 
                        <fieldset>
                            <h3 id="new">Register inventory</h3>
                            <form action="" method="post">
                                <div>
                                    <input type="hidden" name="email" value=<?php echo $email; ?>>
                                    <label for="title">inventory<br></label> 
                                    <input id="title" type="text" name="title" placeholder="例）筆記用具、ノート"> 
                                </div> 
                                <div> 
                                    <label for="date">date<br></label> 
                                    <input id="date" type="date" name="date"> 
                                </div> 
                                <div> 
                                    <label for="memo">memo<br></label> 
                                    <input id="memo" type="text" name="memo"> 
                                </div> 
                                <input id="submit" type="submit" name="submit" value="登録">
                            </form>
                        </fieldset>
                    </div><!--contents-form終わり-->
                     
                    <!--持ち物リスト表示-->
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
                             
                            <?php foreach($m_results as $row){ ?>
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
                    </div><!-- content-table 終わり-->
                </div><!-- contents-list 終わり-->
            </div><!--motimono 終わり-->
             
            <!--ToDoList始まり-->
             
            <!--ToDo投稿フォーム-->
            <br>
            <h1 id="call_todo">ToDoList</h1>
            <div class="contents-list flex-reverse">
                <div class="content-form">
                    <fieldset>
                        <h3 id="new">Register to do</h3>
                        <form action="" method="post">
                            <div>
                                <input type="hidden" name="email" value=<?php echo $email; ?>>
                                <label>title<br></label>
                                <input id="title" type="text" name="title">
                            </div>
                            <div>
                                <label>due_date<br></label>
                                <input id="date" type="date" name="pre_due_date"><br>
                                <label>日程未定の場合 →</label>
                                <input type="checkbox" name="undecided" value="未定">
                            </div>
                            <div>    
                                <label>status<br></label> 
                                <select id="select" name="status">
                                    <option value="">--choose an option--</option>
                                    <option value="0：未着手">0：未着手</option>
                                    <option value="1：まだまだ">1：まだまだ</option>
                                    <option value="2：半分くらい">2：半分くらい</option>
                                    <option value="3：もう少し">3：もう少し</option>
                                    <option value="4：達成！">4：達成！</option>
                                </select>
                            </div>
                            <div>
                                <label>memo<br></label>
                                <input id="memo" type="text" name="memo">
                            </div>
                            <input type="submit" name="t_submit" id="submit">
                         </form>
                    </fieldset>
                </div><!--content-form-todo-->
                 
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
                            
                            <?php foreach($t_results as $row){ ?>
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
                </div><!--ToDoリスト表示 終わり -->
            </div><!-- contents-list 終わり-->
             
             
            <!--カレンダー-->
            <div class="container"> 
                <h1 id="call_calendar">Calendar</h1>
                <h3 id="c-h3" class="mb-5"><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3> 
                <table class="table table-bordered"> 
                    <tr> 
                        <th id="c-th">日</th> 
                        <th id="c-th">月</th> 
                        <th id="c-th">火</th> 
                        <th id="c-th">水</th> 
                        <th id="c-th">木</th> 
                        <th id="c-th">金</th> 
                        <th id="c-th">土</th> 
                    </tr> 
                    <?php 
                        foreach ($weeks as $week) { 
                            echo $week; 
                        }
                    ?> 
                </table> 
            </div><!--カレンダー終わり-->
             
        </div><!--  wrap終わり -->
         
         
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