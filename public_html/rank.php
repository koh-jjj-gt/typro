<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../lib/Controller.php');
$app = new MyApp\Controller\Rank();
$app->run();
if ($app->me()) {
  $arrayOfSessionMe = (array)$app->me();
} else {
  $arrayOfSessionMe = array(
    'username' => '',
    'htmlscore' => 0,
    'cssscore' => 0,
    'jsscore' => 0,
    'phpscore' => 0
  );
}
$which = $app->which;
switch ($which) {
  case 0:
  $highestscore = $arrayOfSessionMe['htmlscore'];
  $whatRank = 'HTML';
  break;
  case 1:
  $highestscore = $arrayOfSessionMe['cssscore'];
  $whatRank = 'CSS';
  break;
  case 2:
  $highestscore = $arrayOfSessionMe['jsscore'];
  $whatRank = 'JavaScript';
  break;
  case 3:
  $highestscore = $arrayOfSessionMe['phpscore'];
  $whatRank = 'PHP';
  break;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
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
        <li id="languages-btn" class="show-tab-btn">
          言語
          <span class="closing">▼</span>
          <span class="opening">▲</span>
          <ul id="languages-tab" class="tab">
            <li id="select-html" class="language tab-btn">HTML</li>
            <li id="select-css" class="language tab-btn">CSS</li>
            <li id="select-js" class="language tab-btn">JavaScript</li>
            <li id="select-php" class="language tab-btn">PHP</li>
            <form id="which-form" method="post" action="">
              <input id="which-input" type="text" name="which" value="">
            </form>
          </ul>
        </li>

        <li id="username-btn" class="show-tab-btn"
          <?php if ($arrayOfSessionMe['username'] === '') : ?>
            <?= ' style="display:none"'; ?>
          <?php endif; ?>>
          <?= h($app->me()->username); ?>
          <span class="closing">▼</span>
          <span class="opening">▲</span>
          <ul id="user-tab" class="tab">
            <li id="profile-btn" class="user-btn tab-btn">プロフィール</li>
            <li id="logout-btn" class="user-btn tab-btn">ログアウト</li>
            <form action="profile.php" method="post" id="profile-form" style="display:none">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
            <form action="logout.php" method="post" id="logout-form" style="display:none">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
          </ul>
        </li>
      </ul>
    </header>


    <div id="rank-wrapper">

      <div id="what-rank">
        <?= h($whatRank); ?>
        Top100
      </div>

      <div id="avg-wrapper">
        参加者: <span id="num-of-ppl">0</span>名&nbsp;&nbsp;&nbsp;
        平均点: <span id="avg-score">0.0</span>点
      </div>

      <div id="ranklist">

        <div id="rank-info-title">
          <span class="spn span-rank span-rank-title">ランク</span>
          <span class="spn span-user span-user-title">ユーザー名</span>
          <span class="spn span-score span-score-title">スコア&nbsp;</span>
        </div>

        <div id="rank-infos">
          <?php foreach ($app->getValues()->users as $user) : ?>
            <div class="rank-info"
            <?php if ($arrayOfSessionMe['username'] === h($user->username)) : ?>
              <?= ' id="myrank"'; ?>
            <?php endif; ?>>
            <span class="spn span-rank"><?= h($user->ranking); ?></span>
            <span class="spn span-user"><?= h($user->username); ?></span>
            <span class="spn span-score">
              <?php
              switch ($which) {
                case 0: echo h($user->htmlscore); break;
                case 1: echo h($user->cssscore); break;
                case 2: echo h($user->jsscore); break;
                case 3: echo h($user->phpscore); break;
              } ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>

    </div>

  </div>

  <footer>
    <p>typrogame</p>
  </footer>

</div>

<script src="jquery.js"></script>
<script src="sub.js"></script>
</body>
</html>
