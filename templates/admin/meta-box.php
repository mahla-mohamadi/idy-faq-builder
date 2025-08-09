<div class="idy-faq-admin-container">
    <?php 
        $options = get_option('my_plugin_settings');
        $current_template = $options['faq_template'] ?? 'default';
    ?>
    <div class="template-notice">
        <p>Current display template: <strong><?php echo esc_html(ucfirst($current_template)); ?></strong></p>
        <p>Change template in <a href="<?php echo admin_url('admin.php?page=idy-faq-builder-settings'); ?>">plugin settings</a></p>
    </div>
    <div class="faq-items-wrapper sortable-faqs">
        <?php if (!empty($faqs)) : ?>
            <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-item-card " data-index="<?php echo $index; ?>">
                    <div class="faq-item-header handle">
                        <span class="item-number"><?php echo $index + 1; ?></span>
                        <button type="button" class="remove-faq">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                    </div>
                    <div class="faq-item-content">
                        <div class="form-group">
                            <label for="faq_question_<?php echo $index; ?>">سوال</label>
                            <input type="text" 
                                   id="faq_question_<?php echo $index; ?>"
                                   name="faq_question[]" 
                                   value="<?php echo esc_attr($faq['question'] ?? ''); ?>"
                                   placeholder="سوال را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="faq_answer_<?php echo $index; ?>">جواب</label>
                            <textarea id="faq_answer_<?php echo $index; ?>"
                                      name="faq_answer[]" 
                                      placeholder="پاسخ سوال را وارد کنید"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- Empty starter field -->
            <div class="faq-item-card">
                <div class="faq-item-header">
                    <span class="item-number">1</span>
                    <button type="button" class="remove-faq" disabled>
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </div>
                <div class="faq-item-content">
                    <div class="form-group">
                        <label for="faq_question_0">سوال</label>
                        <input type="text" 
                               id="faq_question_0"
                               name="faq_question[]" 
                               placeholder="سوال را وارد کنید">
                    </div>
                    <div class="form-group">
                        <label for="faq_answer_0">جواب</label>
                        <textarea id="faq_answer_0"
                                  name="faq_answer[]" 
                                  placeholder="پاسخ سوال را وارد کنید"></textarea>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <button type="button" class="add-faq button button-primary">
        <span><svg width="18" height="18" viewBox="2 2 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5v15m7.5-7.5h-15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span><span>افزودن سوال جدید</span>
    </button>
</div>