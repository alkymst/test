
<div id="popup1" class="modal-box">
  <a href="#" class="js-modal-close close">×</a>
  <div class="modal-body">

    <?php $main_image = get_field('main_image') ? get_field('main_image') : get_field('main_image', 'option'); ?>
    <?php if (isset($main_image['url'])) { ?>
      <div class="left" style="background-image: url('<?php echo $main_image['url']; ?>');">&nbsp;</div>
    <?php
    } ?>

    <?php $form_text = get_field('form_text') ? get_field('form_text') : get_field('form_text', 'option'); ?>
    <div class="right">
      <?php echo $form_text; ?>
      <?php
        $form = get_field('form_id') ? get_field('form_id') : get_field('form_id', 'option');
        $form_ID = isset($form['id']) ? $form['id'] : 1;
      ?>
      <?php echo do_shortcode('[gravityform id="'.$form_ID.'" name="General Contact" title="false" description="false" ajax="true"]'); ?>
    </div>

  </div>
</div>




