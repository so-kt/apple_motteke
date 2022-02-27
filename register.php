<!--新規登録時の処理-->
<link rel="stylesheet" href="index.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
        <link rel="icon"  href="MOTTEKE_fabikon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp|Material+Icons+Round|Material+Icons+Two+Tone">
<?php
    require_once('./config.php');
    //データベースへ接続、テーブルがない場合は作成
    try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("create table if not exists userData(
        id int not null auto_increment primary key,
        name varchar(255),
        email varchar(255),
        password varchar(255),
        created timestamp not null default current_timestamp
        )");
    } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
     
    //メールアドレスのバリデーション
    if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo '入力された値が不正です。';
        $link = '<a href="top.php">戻る</a>';
        echo $link;
        return false;
    }
     
    //正規表現でパスワードをバリデーション
    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
        return false;
    }
        
    $name = $_POST['name'];
     
    //データベース内のメールアドレスを取得
    $stmt = $pdo->prepare("select email from userData where email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    //データベース内のメールアドレスと重複していない場合、登録する。
    if (!isset($row['email'])) {
        $stmt = $pdo->prepare("insert into userData(name, email, password) value(?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
?>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
         
        <body id="log_body">
            <main class="main_log">
                <p>登録完了</p>
             
                <h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;" class="h1_log">ログインしてください</h1>
             
                <form action="login.php" method="post" class="form_log">
                    <!--<label for="email" class="label">メールアドレス</label><br>-->
                    <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br><br>
                    <!--<label for="password" class="label">パスワード</label><br>-->
                    <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br><br>
                    <button type="submit" class="log_button">ログインする</button>
                </form>
                <p align="center">戻るボタンや更新ボタンを押さないでください</p>
        </body>
        <?php
            }else {
        ?>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
         
        <body id="log_body">
            <main class="main_log">
                <p>既に登録されたメールアドレスです</p>
                 
                <h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;" class="h1_log">初めての方はこちら</h1>
                <form action="register.php" method="post" class="form_log">
                    <!--<label for="email" class="label">メールアドレス</label><br>-->
                    <input type="name" name="name" class="textbox un" placeholder="ユーザ名"><br><br>
                    <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br><br>
                    <!--<label for="password" class="label">パスワード</label><br>-->
                    <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br><br>
                    <button type="submit" class="log_button">新規登録する</button>
                    <p style="text-align:center;margin-top: 1.5em;">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
                </form>
                <?php
                    $link = '<a href="top.php">戻る</a>';
                    echo $link;
                ?>
            </main>
        </body>
         
        <?php
            return false;
            }
        ?>