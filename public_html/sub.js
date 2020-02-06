'use strict';

$(function() {


  // signup.php, login.php
  $(document).on("keydown", "#inputfinish", function(e) {
    if ( e.keyCode === 13 ) {
      $('form').submit();
    }
  });


  // rank.php, profile.php
  $('#title-btn').on('click', function() {
    $('#title-form').submit();
  });
  $('#logout-btn').on('click', function() {
    $('#logout-form').submit();
  });


  // rank.php
  $('#profile-btn').on('click', function() {
    $('#profile-form').submit();
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
  $('#select-html').on('click', function() {
    $('#which-input').attr('value', '0');
    $('#which-form').submit();
  });
  $('#select-css').on('click', function() {
    $('#which-input').attr('value', '1');
    $('#which-form').submit();
  });
  $('#select-js').on('click', function() {
    $('#which-input').attr('value', '2');
    $('#which-form').submit();
  });
  $('#select-php').on('click', function() {
    $('#which-input').attr('value', '3');
    $('#which-form').submit();
  });
  var totalScore = 0;
  $('.span-score').each(function(i, e) {
    var score = $(e).text();
    if ($.isNumeric(score)) {
      totalScore += score * 1;
    }
  });
  var numOfPpl = $('.span-rank').last().text();
  $('#num-of-ppl').text(numOfPpl);
  $('#avg-score').text( (totalScore / numOfPpl).toFixed(1) );



  // profile.php
  $('.pre-reset-btn').on('click', function() {
    $('#reset-mask').fadeIn();
    $(this).parent().find('.modal').fadeIn();
    $('.cancel-btn').focus();
  });
  $('.cancel-btn').on('click', function() {
    $('#reset-mask').fadeOut();
    $(this).parent().parent().find('.modal').fadeOut();
  });
  $('#rank-btn').on('click', () => {
    $('#rank-form').submit();
  });

});
