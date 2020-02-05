<?php
require_once(__DIR__ . '/../config/config.php');
$app = new MyApp\Controller\Login();
$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>TyProGame</title>
  <meta name="description" content="プログラミング言語のタイピングが練習できるTyProGameです。">
  <link rel="stylesheet" href="sub.css">
  <link rel="icon" sizes="16x16" href="favicon-16x16.ico">
</head>

<body>
  <div id="container">
    <form action="" method="post" id="login">
      <p>
        <input type="text" name="username" placeholder="ユーザー名" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username) : ''; ?>">
      </p>
      <p>
        <input type="text" name="email" placeholder="メールアドレス" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
      </p>
      <p>
        <input type="password" name="password" placeholder="パスワード" id="inputfinish">
      </p>
      <p class="err"><?= h($app->getErrors('login')); ?></p>
      <div class="btn" onclick="document.getElementById('login').submit();">ログイン</div>
      <p class="fs12"><a href="/signup.php">新規登録はこちら</a></p>
      <p class="fs12"><a href="/indexnolog.php">ログインせずに遊ぶ方はこちら</a></p>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div>

  <script src="jquery.js"></script>
  <script src="sub.js"></script>
</body>
</html>
