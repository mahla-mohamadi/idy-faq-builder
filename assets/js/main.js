jQuery(document).ready(function($) {
    // Initialize sortable functionality
    $('.sortable-faqs').sortable({
        handle: '.handle',
        axis: 'y',
        placeholder: 'faq-item-placeholder',
        forcePlaceholderSize: true,
        opacity: 0.7,
        start: function(event, ui) {
            ui.item.addClass('dragging');
        },
        stop: function(event, ui) {
            ui.item.removeClass('dragging');
            updateItemNumbers();
        },
        update: function(event, ui) {
            // This fires when the order changes
        }
    });

    // Update item numbers after reordering
    function updateItemNumbers() {
        $('.faq-item-card').each(function(index) {
            $(this).find('.item-number').text(index + 1);
            $(this).attr('data-index', index);
        });
    }

    // Add new FAQ item (updated to maintain sortable)
    $('.add-faq').click(function(e) {
        e.preventDefault();
        
        const lastNumber = $('.faq-item-card').length;
        const $newItem = $('.faq-item-card:first').clone();
        
        // ... (keep existing clone logic) ...
        
        $('.sortable-faqs').append($newItem);
        $newItem.find('input, textarea').val('');
        updateItemNumbers();
        
        // Make new item sortable
        $('.sortable-faqs').sortable('refresh');
    });

    // Remove FAQ item (updated to maintain sortable)
    $(document).on('click', '.remove-faq:not(:disabled)', function(e) {
        e.preventDefault();
        
        if ($('.faq-item-card').length > 1) {
            $(this).closest('.faq-item-card').fadeOut(300, function() {
                $(this).remove();
                updateItemNumbers();
                $('.sortable-faqs').sortable('refresh');
            });
        }
    });
});