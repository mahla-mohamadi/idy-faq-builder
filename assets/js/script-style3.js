var $ = jQuery;
$('.accordion-item .accordion-header').on('click', function() {
  // Close all other accordion items
  $('.accordion-item').not($(this).parent()).removeClass('active');
  $('.accordion-item').not($(this).parent()).find('.accordion-content').stop(true, true).slideUp(300);
  
  // Toggle current item
  $(this).parent().toggleClass('active');
  $(this).parent().find('.accordion-content').stop(true, true).slideToggle(300);
});