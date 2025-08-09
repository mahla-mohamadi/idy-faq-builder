var $ = jQuery;

$(document).ready(function() {
  $('.accordion-item .line').on('click', function() {
    const item = $(this).closest('.accordion-item');
    const icon = item.find('.svg');
    const isOpen = item.hasClass('active');
    const content = item.find('.accordion-content'); // Assuming you have this element

    // Close all other accordion items
    $('.accordion-item').not(item).removeClass('active')
      .find('.accordion-content').stop(true, true).slideUp(300);
    $('.accordion-item').not(item).find('.svg').html(`
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
        <path d="M5 12h14"/>
        <path d="M12 5v14"/>
      </svg>
    `);

    // Toggle current item
    if (!isOpen) {
      item.addClass('active');
      content.stop(true, true).slideDown(300);
      icon.html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus">
          <path d="M5 12h14"/>
        </svg>
      `);
    } else {
      item.removeClass('active');
      content.stop(true, true).slideUp(300);
      icon.html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
          <path d="M5 12h14"/>
          <path d="M12 5v14"/>
        </svg>
      `);
    }
  });
});