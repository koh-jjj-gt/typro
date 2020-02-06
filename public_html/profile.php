<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../lib/Controller.php');
$app = new MyApp\Controller\Profile();
$app->run();
$arrayOfSessionMe = (array)$_SESSION['me'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TyProGame</title>
  <meta name="description" content="プログラミング言語のタイピングが練習できるTyProGameです。">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="sub.css">
  <link rel="icon" sizes="16x16" href="favicon-16x16.ico">
</head>

<body>

  <div id="wrapper">

    <header>
      <div id="title-btn">TyProGame</div>
      <form action="index.php" method="post" id="title-form" style="display:none"></form>

      <ul id="header-wrapper">
        <li id="rank-btn">ランキング</li>
        <form action="rank.php" method="post" id="rank-form" style="display:none"></form>

        <li id="logout-btn">ログアウト</li>
        <form action="logout.php" method="post" id="logout-form" style="display:none">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
      </ul>
    </header>

    <div id="edit-wrapper">
      <div id="contents">
        <article id="user-edit">
          <h1 id="profile">プロフィール</h1>

          <section>
            <h2 class="edit-title">ハイスコア</h2>
            <form action="" method="post" class="reset-html">
              <ul>
                <li>
                  <div class="current-score-h">HTML</div>
                  <div class="current-score-c"><?= h($arrayOfSessionMe['htmlscore']); ?></div>
                  <div id="html-modal" class="modal">
                    <strong>本当にHTMLのスコアをリセットしますか？</strong>
                    <button type="submit" class="reset-btn">する</button>
                    <button type="button" class="cancel-btn reset-btn">しない</button>
                  </div>
                  <button type="button" class="pre-reset-btn hover">リセット</button>
                  <input type="hidden" name="reset-html" value="">
                </li>
              </ul>
            </form>

            <form action="" method="post" class="reset-css">
              <ul>
                <li>
                  <div class="current-score-h" id="pos1">CSS</div>
                  <div class="current-score-c"><?= h($arrayOfSessionMe['cssscore']); ?></div>
                  <div id="css-modal" class="modal">
                    <strong>本当にCSSのスコアをリセットしますか？</strong>
                    <button type="submit" class="reset-btn">する</button>
                    <button type="button" class="cancel-btn reset-btn">しない</button>
                  </div>
                  <button type="button" class="pre-reset-btn hover">リセット</button>
                  <input type="hidden" name="reset-css" value="">
                </li>
              </ul>
            </form>

            <form action="" method="post" class="reset-js">
              <ul>
                <li>
                  <div class="current-score-h">JavaScript</div>
                  <div class="current-score-c"><?= h($arrayOfSessionMe['jsscore']); ?></div>
                  <div id="js-modal" class="modal">
                    <strong>本当にJavaScriptのスコアをリセットしますか？</strong>
                    <button type="submit" class="reset-btn">する</button>
                    <button type="button" class="cancel-btn reset-btn">しない</button>
                  </div>
                  <button type="button" class="pre-reset-btn hover">リセット</button>
                  <input type="hidden" name="reset-js" value="">
                </li>
              </ul>
            </form>

            <form action="" method="post" class="reset-php">
              <ul>
                <li>
                  <div class="current-score-h">PHP</div>
                  <div class="current-score-c"><?= h($arrayOfSessionMe['phpscore']); ?></div>
                  <div id="php-modal" class="modal">
                    <strong>本当にPHPのスコアをリセットしますか？</strong>
                    <button type="submit" class="reset-btn">する</button>
                    <button type="button" class="cancel-btn reset-btn">しない</button>
                  </div>
                  <button type="button" class="pre-reset-btn hover">リセット</button>
                  <input type="hidden" name="reset-php" value="">
                </li>
              </ul>
            </form>
          </section>

          <section>
            <h2 class="edit-title">ユーザー名</h2>
            <form action="" method="post" id="edit-username">
              <ul>
                <li>
                  <div class="current-username-h">現在のユーザー名</div>
                  <div class="current-username-c"><?= h($arrayOfSessionMe['username']); ?></div>
                </li>
                <li>
                  <label for="new-username" id="pos2">新しいユーザー名</label>
                  <input type="text" name="new-username" id="new-username" class="edit-input">
                  <p>
                    (20文字以内)<br>
                    <p class="err"><?= h($app->getErrors('username')); ?></p>
                    <div id="mixdata_response"></div>
                  </p>
                </li>
              </ul>
              <button type="submit" class="edit-btn"  id="pos3">変更</button>
            </form>
          </section>

          <section>
            <h2 class="edit-title">メールアドレス</h2>
            <form action="" method="post" id="edit-email">
              <ul>
                <li>
                  <label for="current-email">現在のメールアドレス</label>
                  <input type="text" name="current-email" id="current-email" class="edit-input" value="<?= isset($app->getValues()->curEmail) ? h($app->getValues()->curEmail) : ''; ?>">
                </li>
                <li>
                  <label for="new-email">新しいメールアドレス</label>
                  <input type="text" name="new-email" id="new-email" class="edit-input" value="<?= isset($app->getValues()->newEmail) ? h($app->getValues()->newEmail) : ''; ?>">
                  <p>
                    (半角英数記号)<br>
                    <p class="err"><?= h($app->getErrors('email')); ?></p>
                  </p>
                </li>
              </ul>
              <button type="submit" class="edit-btn">変更</button>
            </form>
          </section>

          <section>
            <h2 class="edit-title">パスワード</h2>
            <form action="" method="post" id="edit-password">
              <ul>
                <li>
                  <label for="current-password">現在のパスワード</label>
                  <input type="password" name="current-password" id="current-password" class="edit-input" maxlength="16">
                </li>
                <li>
                  <label for="new-password">新しいパスワード</label>
                  <input type="password" name="new-password" id="new-password" class="edit-input" maxlength="16">
                  <p>
                    (半角英数字4～16文字)<br>
                    <p class="err"><?= h($app->getErrors('password')); ?></p>
                  </p>
                </li>
              </ul>
              <button type="submit" class="edit-btn">変更</button>
            </form>
          </section>

        </article>
      </div>
    </div>

    <div id="reset-mask" style="display:none;"></div>
    <a href="/profile.php" id="a" style="display:none;"></a>

    <footer>
      <p>typrogame</p>
    </footer>

  </div>


  <script>
  const addUrlParam = function(path, key, value, save) {
    if (!path || !key || !value) return '';
    var addParam      = key + '=' + value,
    paths         = path.split('/'),
    fullFileName  = paths.pop(),
    fileName      = fullFileName.replace(/[\?#].+$/g, ''),
    dirName       = path.replace(fullFileName, ''),
    hashMatches   = fullFileName.match(/#([^#]+)$/),
    paramMatches  = fullFileName.match(/\?([^\?]+)$/),
    hash          = '',
    param         = '',
    params        = [],
    fullPath      = '',
    hitParamIndex = -1;
    if (hashMatches && hashMatches[1]) {
      hash = hashMatches[1];
    }
    if (paramMatches && paramMatches[1]) {
      param = paramMatches[1].replace(/#[^#]+$/g, '').replace('&', '&');
    }
    fullPath = dirName + fileName;
    if (param === '') {
      param = addParam;
    } else if (save) {
      params = param.split('&');
      for (var i = 0, len = params.length; i < len; i++) {
        if (params[i].match(new RegExp('^' + key + '='))) {
          hitParamIndex = i;
          break;
        }
      }
      if (hitParamIndex > -1) {
        params[hitParamIndex] = addParam;
        param = params.join('&');
      } else {
        param += '&' + addParam;
      }
    } else {
      param += '&' + addParam;
    }
    fullPath += '?' + param;
    if (hash !== '') fullPath += '#' + hash;
    return fullPath;
  }
  const newUsername = document.getElementById('new-username');
  const curEmail = document.getElementById('current-email');
  const newEmail = document.getElementById('new-email');
  const curPassword = document.getElementById('current-password');
  const newPassword = document.getElementById('new-password');
  let a = document.getElementById('a');
  hrefAttrValue = a.getAttribute('href');

  const scroll = function(i) {
    var setUrlValue = addUrlParam(hrefAttrValue, 'pos', i, true);
    a.setAttribute('href', setUrlValue);
    a.click();
  }

  const scroll2 = function() {
    if (newUsername === document.activeElement) {
      <?php
      if((isset($_GET['pos']) && $_GET['pos'] !== '1') || !(isset($_GET['pos']))) {
        ?>
        scroll(1);
        <?php
      }
      ?>
    } else if (curEmail === document.activeElement || newEmail === document.activeElement) {
      <?php
      if((isset($_GET['pos']) && $_GET['pos'] !== '2') || !(isset($_GET['pos']))) {
        ?>
        scroll(2);
        <?php
      }
      ?>
    } else if (curPassword === document.activeElement || newPassword === document.activeElement) {
      <?php
      if((isset($_GET['pos']) && $_GET['pos'] !== '3') || !(isset($_GET['pos']))) {
        ?>
        scroll(3);
        <?php
      }
      ?>
    }
  }

  document.addEventListener('click', function() {
    scroll2();
  });

  <?php
  if (isset($_GET['pos'])) {
    if ($_GET['pos'] === '1') {
      ?>
      document.getElementById("pos1").scrollIntoView(true);
      newUsername.focus();
      <?php
    }
    if ($_GET['pos'] === '2') {
      ?>
      document.getElementById("pos2").scrollIntoView(true);
      curEmail.focus();
      <?php
    }
    if ($_GET['pos'] === '3') {
      ?>
      document.getElementById("pos3").scrollIntoView(true);
      curPassword.focus();
      <?php
    }
  }
  ?>
  </script>
  <script src="jquery.js"></script>
  <script src="sub.js"></script>
</body>
</html>
