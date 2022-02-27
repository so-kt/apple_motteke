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
 
        require_once('./config.php');
 
        session_start();
        //メールアドレスのバリデーション
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo '入力された値が不正です。';
            $link = '<a href="top.php">戻る</a>';
            echo $link;
            return false;
        }
        //DB内でPOSTされたメールアドレスを検索
        try {
            $pdo = new PDO(DSN, DB_USER, DB_PASS);
            $stmt = $pdo->prepare('select * from userData where email = ?');
            $stmt->execute([$_POST['email']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        //emailがDB内に存在しているか確認
        if (!isset($row['email'])) {
            echo 'メールアドレス又はパスワードが間違っています。';
            return false;
        }
        //パスワード確認後sessionにメールアドレスを渡す
        if (password_verify($_POST['password'], $row['password'])) {
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['EMAIL'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            if($_SESSION['name']){
                header('Location:index.php');
            }

        } else {
            echo 'メールアドレス又はパスワードが間違っています。';
            $link = '<a href="top.php">戻る</a>';
            echo $link;
            return false;
        }
    ?>
    </body>
</html>