<!--ログイン・新規登録ページ-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  href="MOTTEKE_fabikon.png">
    <link rel="stylesheet" href="index.css">
    <title>TopPage</title>
</head>
<body>
    <div class="loginform">
        <img src="透過.png" alt="mottekeロゴ" title="mottekeロゴ">
        <h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;" class="h1_log">ログインしてください</h1>
        <form action="login.php" method="post" class="form_log">
            <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br><br>
            <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br><br>
            <button type="submit" class="log_button">ログインする</button>
        </form>

        <h1 style="text-align:center;margin-top: 2em;margin-bottom: 1em;" class="h1_log">初めての方はこちら</h1>
        <form action="register.php" method="post" class="form_log">
            <input type="name" name="name" class="textbox un" placeholder="ユーザ名"><br><br>
            <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br><br>
            <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br><br>
            <button type="submit" class="log_button">新規登録する</button>
            <p style="text-align:center;margin-top: 1.5em;">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
        </form>
    </div>
    
</body>
</html>