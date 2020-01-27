'use strict';

$(function() {

  var words = [];
  const htmlWords = [
    '&lt;!DOCTYPE html&gt;',
    '&lt;div&gt;',
    'class',
    '&lt;/div&gt;',
    '&lt;meta&gt;',
    '&lt;body&gt;',
    '&lt;/body&gt;',
    '&lt;head&gt;',
    '&lt;/head&gt;',
    '&lt;header&gt;',
    '&lt;/header&gt;',
    '&lt;footer&gt;',
    '&lt;/footer&gt;',
    '&lt;form&gt;',
    '&lt;/form&gt;',
    '&lt;p&gt;',
    '&lt;/p&gt;',
    '&lt;span&gt;',
    '&lt;/span&gt;',
    '&lt;table&gt;',
    '&lt;/table&gt;',
    '&lt;td&gt;',
    '&lt;/td&gt;',
  ]
  const cssWords = [
    'color',
    'background',
    'attachment',
    'image',
    'position',
    'repeat',
    'font',
    'font-size',
    'font-family',
    'font-weight',
    'adjust',
    'variant',
    'style',
    'height',
    'align',
    'text',
    'line',
    'decoration',
    'underline',
    'space',
    'width',
    'break',
    'box-shadow',
    'max-width',
    'min-width',
    'margin-top',
    'margin-bottom',
    'margin-left',
    'margin-right',
    'padding-top',
    'padding-bottom',
    'padding-left',
    'padding-right',
    'border-top',
    'border-bottom',
    'border-left',
    'border-right',
    'overflow',
    'display',
    'float',
    'z-index',
    'direction',
    'unicode-bidi',
    'writing-mode',
    'table-layout',
    'caption-side',
    'empty-cells',
    'content',
    'outline',
    'cursor',
    'pointer',
    'scroll',
    'filter',
    'blur',
  ];
  const jsWords = [
    'document',
    'getElementById',
    'getElementsByClassName',
    'const',
    'let',
    'var',
    'function',
    'click',
    'split',
    'charAt',
    'replace',
    'indexOf',
    'trim',
    'length',
    'write',
    'match',
    'querySelector',
    'querySelectorAll',
    'parentNode',
    'children',
    'dataset',
    'className',
    'classList',
    'createElement',
    'appendChild',
    'insertBefore',
    'cloneNode',
    'removeChild',
    'value',
    'focus',
    'select',
    'addEventListener',
    'preventDefault',
    'console.log()',
  ];
  const phpWords = [
    '$this',
    'public',
    'private',
    'protected',
    'function',
    'namespace',
    '&lt;?php ?&gt;',
    'require_once',
    'require',
    'include',
    'include_once',
    'execute',
    'query',
    'prepare',
    'extends',
    'isset',
    '$_GET[]',
    '$_POST[]',
    '$_SERVER[]',
    'header',
    'location',
    'exit',
    'return',
    'throw new',
    'catch',
    'fetch',
    'fetchAll',
    'setFetchMode',
    'empty',
    '->',
    'switch',
    'case',
    'break',
    'if',
    'PDO::FETCH_CLASS',
    '__DIR__',
    'password_hash',
    'strlen',
    'mb_strlen',
    'array',
    'try',
    'filter_var',
    'session_regenerate_id',
    'object',
    'password_verify',
    'PASSWORD_DEFAULT',
    'echo',
  ]

  var startTime;
  var elapsedTime;

  var timeoutId;
  var time2Id;
  var time1Id;
  var timeMaskId;

  var totalChars = 0;
  var missCount = 0;

  var htmlPrevScore = 0;
  var cssPrevScore = 0;
  var jsPrevScore = 0;
  var phpPrevScore = 0;

  var isPlaying = false;
  var displayedHowModal = false;
  var displayedFinModal = false;

  var which = 0;
  var whichType = '';
  const theNumOfQs = 1;

  function displayGame() {
    totalChars = 0;
    missCount = 0;

    switch (which) {
      case 0:
      words = htmlWords;
      whichType = 'HTML';
      break;
      case 1:
      words = cssWords;
      whichType = 'CSS';
      break;
      case 2:
      words = jsWords;
      whichType = 'JavaScript';
      break;
      case 3:
      words = phpWords;
      whichType = 'PHP';
      break;
    }
    words.sort(function() {
      return Math.random() - Math.random();
    });

    $('#play > table').empty();
    for(var i = 0; i < theNumOfQs; i++) {
      $("#play > table").append(
        `<tr>
        <td width="5%">${i+1}.</td>
        <td class="example example_${i}" width="30%">`
        + words[i] +
        `</td><td width="1%"></td>
        <td width="64%">
        <textarea rows="1" class="answer answer_${i}" type="text" placeholder="` + words[i] + `"></textarea>
        <p class="pointnum point point_${i}">GOOD!</p>
        <p class="pointnum misspoint misspoint_${i}">-5</p>
        </td>
        </tr>`
      );
      totalChars += words[i].length;
    }
    nextAnswer();
  }

  function countUp() {
    elapsedTime = new Date(Date.now() - startTime);
    const min = ('0' + elapsedTime.getMinutes()).slice(-1);
    const sec = ('0' + elapsedTime.getSeconds()).slice(-2);
    const ms = ('0' + elapsedTime.getMilliseconds()).slice(-1);
    $('#time').text(`${min}:${sec}.${ms}`);
    timeoutId = setTimeout(function() {
      countUp();
    }, 10);
  }

  function nextAnswer() {
    $('textarea.answer')
    .prop('readonly', true)
    .prop('disabled', true)
    .addClass('noinput');

    $(document).on("keydown", ".answer", function(e) {
      var i = $('.answer').index(this);
      if ( e.keyCode === 13 ) {
        if (!isPlaying) {
          return false;
        }
        if ( $(this).val() === $(`.example_${i}`).text() ) {
          if ( $(`.answer`).get(`${i+1}`) ) {
            $(`.answer_${i+1}`)
            .prop('readonly', false)
            .removeClass('noinput')
            .prop('disabled', false)
            .addClass('input')
            .focus();
            $(`.answer_${i}`)
            .prop('readonly', true)
            .addClass('noinput')
            .prop('disabled', true)
            .removeClass('input');
            $(`.point_${i}`).css('display', 'block').fadeOut(500);
            $("#game").animate({
              scrollTop: `${i}` * 50
            }, 300, "swing");
          } else {
            finishGame();
          }
        } else {
          $(`.misspoint_${i}`).css('display', 'block').fadeOut(500);
          $(this).addClass('miss');
          missCount++;
        }
        return false;
      } else {
        $(this).removeClass('miss');
      }
    });
  }

  function startGame() {
    isPlaying = true;
    $('#open').fadeOut(200);
    $('.example').text('****');
    $('.answer').text('****');
    $('#count3').show().fadeOut(1000);
    time2Id = setTimeout(function() {
      $('#count2').show().fadeOut(1000);
    }, 1000);
    time1Id = setTimeout(function() {
      $('#count1').show().fadeOut(1000);
    }, 2000);

    timeMaskId = setTimeout(function() {
      $('#mask').fadeOut(200);
      displayGame();
      $('.answer:eq(0)')
      .prop('readonly', false)
      .prop('disabled', false)
      .removeClass('noinput')
      .focus();
      startTime = Date.now();
      countUp();
    }, 3000);
  }

  function finishGame() {
    isPlaying = false;
    displayedFinModal = true;
    $('.answer').prop('disabled', true)
    $('#close, #mask').fadeIn();
    $("#game").animate({
      scrollTop: 0
    }, 300, "swing");

    clearTimeout(timeoutId);
    var scoreText = (totalChars / elapsedTime) * 20000 - missCount;
    if (scoreText > 0) {
      $('#score').text((scoreText).toFixed(1));
    } else {
      $('#score').text('0');
    }
    $('#hiddenscore').attr('value', $('#score').text());
    $('#hiddenwhich').attr('value', which);
    $('#key').text((1000 * (totalChars + theNumOfQs) / elapsedTime).toFixed(1));
    $('#share-a').attr('href', `http://twitter.com/share?url=http://192.168.33.10:8000&text=今回のTyProGameの結果は${whichType}で${$('#score').text()}点でした！&hashtags=typrogame`);

    switch (which) {
      case 0:
      if (htmlPrevScore) {
        $('#previousScore').text(htmlPrevScore);
      } else {
        $('#previousScore').text('---');
      }
      htmlPrevScore = $('#score').text();
      break;
      case 1:
      if (cssPrevScore) {
        $('#previousScore').text(cssPrevScore);
      } else {
        $('#previousScore').text('---');
      }
      cssPrevScore = $('#score').text();
      break;
      case 2:
      if (jsPrevScore) {
        $('#previousScore').text(jsPrevScore);
      } else {
        $('#previousScore').text('---');
      }
      jsPrevScore = $('#score').text();
      break;
      case 3:
      if (phpPrevScore) {
        $('#previousScore').text(phpPrevScore);
      } else {
        $('#previousScore').text('---');
      }
      phpPrevScore = $('#score').text();
      break;
    }
  }

  function restartGame() {
    displayedFinModal = false;
    $('#close').fadeOut(200);
    $('#open, #mask').fadeIn(200);
    displayGame();
  }

  $(document).on("keydown", "body", function(e) {
    if ( e.keyCode === 27 ) { // esc key
      if (!isPlaying) {
        return;
      } else {
        restartGame();
        $("#game").animate({
          scrollTop: 0
        }, 300, "swing");
        isPlaying = false;
        clearTimeout(timeoutId);
        clearTimeout(time2Id);
        clearTimeout(time1Id);
        clearTimeout(timeMaskId);
      }
    }
    if (e.keyCode === 32) { // space key
      if (!isPlaying && !displayedFinModal && !displayedHowModal) {
        startGame();
        return false;
      }
      if (displayedFinModal) {
        restartGame();
        return false;
      }
    }
  });

  $('#start').on('click', () => {
    startGame();
  });

  $('#restart').on('click', () => {
    restartGame();
  });

  $('#how').on('click', () => {
    displayedHowModal = true;
    $('#how-modal').fadeIn(200);
    $("#how-modal").animate({
      scrollTop: 0
    }, 0).animate({
      scrollTop: 30
    }, 200).animate({
      scrollTop: 0
    }, 200);
  });

  $('#x, #back').on('click', () => {
    displayedHowModal = false;
    $('#how-modal').fadeOut(200);
  });

  $('#html-btn').on('click', () => {
    $('.select-btn').removeClass('selected');
    $('#html-btn').addClass('selected');
    which = 0;
  });
  $('#css-btn').on('click', () => {
    $('.select-btn').removeClass('selected');
    $('#css-btn').addClass('selected');
    which = 1;
  });
  $('#js-btn').on('click', () => {
    $('.select-btn').removeClass('selected');
    $('#js-btn').addClass('selected');
    which = 2;
  });
  $('#php-btn').on('click', () => {
    $('.select-btn').removeClass('selected');
    $('#php-btn').addClass('selected');
    which = 3;
  });

  $('#register').on('click', () => {
    $('#addrank').submit();
  });

  $('#title-btn').on('click', () => {
    $('#title-form').submit();
  });
  $('#logout-btn').on('click', function() {
    $('#logout-form').submit();
  });
  $('#profile-btn').on('click', function() {
    $('#profile-form').submit();
  });
  $('#rank-btn').on('click', () => {
    $('#rank-form').submit();
  });
  $('#login-btn').on('click', () => {
    $('#login-form').submit();
  });
  $('#signup-btn').on('click', () => {
    $('#signup-form').submit();
  });
  $(document).mouseover(function(e) {
    if($(e.target).closest('#alpha, #fake-mask').length) {
      $('#fake-mask').show();
    } else {
      $('#fake-mask').hide();
    }
  });


  $('.show-tab-btn').on('click', e => {
    var tabBtn = $(e.target).find('.tab-btn');
    var e = $(e.target);
    if (tabBtn.is(':hidden')) {
      for (var j = 0; j < tabBtn.length; j++) {
        e.find(`.tab-btn:eq(${j})`).slideDown(200);
      }
      e.find('span.closing').hide();
      e.find('span.opening').show();
    } else {
      for (var j = tabBtn.length - 1; j >= 0; j--) {
        e.find(`.tab-btn:eq(${j})`).slideUp(200);
      }
      e.find('span.closing').show();
      e.find('span.opening').hide();
    }
  });
  $('.show-tab-btn span').on('click', e => {
    var tabBtn = $(e.target).parent().find('.tab-btn');
    var showTabBtn = $(e.target).parent();
    if (tabBtn.is(':hidden')) {
      for (var j = 0; j < tabBtn.length; j++) {
        showTabBtn.find(`.tab-btn:eq(${j})`).slideDown(200);
      }
      showTabBtn.find('span.closing').hide();
      showTabBtn.find('span.opening').show();
    } else {
      for (var j = tabBtn.length - 1; j >= 0; j--) {
        showTabBtn.find(`.tab-btn:eq(${j})`).slideUp(200);
      }
      showTabBtn.find('span.closing').show();
      showTabBtn.find('span.opening').hide();
    }
  });
  $(document).on('click touchend', e => {
    if (!$(e.target).closest('.show-tab-btn, .tab-btn').length) {
      $('span.closing').show();
      $('span.opening').hide();
      $('.tab-btn').hide();
    }
  });

  displayGame();

});
