<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../lib/Controller.php');
$app = new MyApp\Controller\Index_notLoggedIn();
$app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TyProGame</title>
  <meta name="description" content="プログラミング言語のタイピングが練習できるTyProGameです。">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="icon" sizes="16x16" href="favicon-16x16.ico">
</head>

<body>

  <div id="wrapper">

    <header>

      <div id="title-btn">TyProGame</div>
      <form action="index.php" method="post" id="title-form" style="display:none"></form>

      <ul id="header-wrapper">
        <li id="rank-btn">ランキング</li>
        <form action="" method="post" id="rank-form">
          <input type="text" name="rank-input" value="" style="display:none">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <li id="login-btn">ログイン</li>
        <form action="" method="post" id="login-form">
          <input type="text" name="login-input" value="" style="display:none">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <li id="signup-btn">新規登録</li>
        <form action="" method="post" id="signup-form">
          <input type="text" name="signup-input" value="" style="display:none">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
      </ul>

    </header>


    <div id="game-wrapper">

      <div id="game">

        <div id="open" class="modal">
          <p id="start" class="btn">始める<br><span class="fs12">(Spaceキー)</span></p>
          <p id="how" class="btn hover">遊び方</p>
          <div id="select-game">
            <div id="html-btn" class="select-btn btn selected">HTML</div>
            <div id="css-btn" class="select-btn btn">CSS</div>
            <div id="js-btn" class="select-btn btn">J<span class="fs12">ava</span>S<span class="fs12">cript</span></div>
            <div id="php-btn" class="select-btn btn">PHP</div>
          </div>
        </div>


        <div id="close" class="modal" style="display:none">
          <p>Score&nbsp;:
            <span class="letter" id="score">0</span>
            (前回:<span id="previousScore">0</span>)
          </p>
          <p>Speed&nbsp;:
            <span class="letter" id="key">0</span>&nbsp;key/sec
          </p>
          <p>Time&nbsp;&nbsp;:
            <span class="letter" id="time">0</span>
          </p>

          <div id="alpha">
            <div id="fake-register" class="fs12 hover">この点数を登録する</div>
            <div id="fake-share" class="fs12 hover"><i class="fab fa-twitter"></i>Twitterでシェア</div>
            <div id="fake-mask" style="display:none">
              ログインが必要です
            </div>
          </div>

          <p id="restart" class="btn hover">もう一度<br><span class="fs12">(Spaceキー)</span></p>
        </div>


        <div id="how-modal" class="modal" style="display:none">
          <p id="x">×</p>
          <p>遊び方</p>
          <p><br>下の例のようにタイプしましょう！</p>
          <table>
            <tr>
              （例）
            </tr>
            <tr>
              <td>1. あいうえお</td>
              <td>&nbsp;&nbsp;&nbsp;</td>
              <td class="sample">あいうえお</td>
            </tr>
            <tr>
              <td>2. かきくけこ</td>
              <td>&nbsp;&nbsp;&nbsp;</td>
              <td class="sample">かきく<span id="caret">|</span></td>
            </tr>
            <tr>
              <td>3. さしすせそ</td>
              <td>&nbsp;&nbsp;&nbsp;</td>
              <td class="sample"></td>
            </tr>
          </table>
          <p>
            * HTML, CSS, JavaScript, PHP から選べます<br>
            * Enterキーで次の問題に進めます<br>
            * 全部で20問あります<br>
            * escキーでやり直しできます<br>
            * 英字入力にしてください
          </p>
          <div id="back" class="btn hover">もどる</div>
        </div>

        <div id="play">
          <table></table>
        </div>


        <div id="mask"></div>


        <div id="count-wrapper">
          <div id="count3" class="count" style="display:none">3</div>
          <div id="count2" class="count" style="display:none">2</div>
          <div id="count1" class="count" style="display:none">1</div>
        </div>

      </div>
    </div>

    <footer>
      <p>typrogame</p>
    </footer>

  </div>

  <script src="jquery.js"></script>
  <script src="index.js"></script>
</body>
</html>
