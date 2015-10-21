$(function() {

  $('#m_btn').on('click', function() {
    $('#m_menu').sidebar('toggle');
  });

  $('#back').on('click', function() {
    $('#m_menu').sidebar('hide');
  });

  $('#m_menu a').on('click', function() {
    $('#m_menu').sidebar('hide');
  });
});
