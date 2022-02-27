<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>log out</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
         <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
         <link href="index.css" rel="stylesheet">
         <link rel="icon"  href="MOTTEKE_fabikon.png">
         <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
    </head>
    <body>
        <?php
            session_start();
            $_SESSION = array();//セッションの中身をすべて削除
            session_destroy();//セッションを破壊
        ?>

        <p>ログアウトしました。</p>
        <a href="./top.php">ログインへ</a>
    </body>
</html>