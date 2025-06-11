<?php

use Elementor\Icons_Manager;

class Astra_Child_Custom_Widget_Footer_Contact_Info extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'astra_child_custom_widget_footer_contact_info',
			__('Footer Contact Info', 'astra-child'),
			array('description' => __('Footer Contact Info', 'astra-child'))
		);
	}

	public function form($instance)
	{
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php _e('Địa chỉ:', 'astra-child'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>"
				name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text"
				value="<?php echo esc_attr($instance['address']); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('working_time')); ?>"><?php _e('Thời gian làm việc:', 'astra-child'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('working_time')); ?>"
				name="<?php echo esc_attr($this->get_field_name('working_time')); ?>" type="text"
				value="<?php echo esc_attr($instance['working_time']); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('hotline')); ?>"><?php _e('Hotline:', 'astra-child'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('hotline')); ?>"
				name="<?php echo esc_attr($this->get_field_name('hotline')); ?>" type="text"
				value="<?php echo esc_attr($instance['hotline']); ?>">
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		return [
			'address' => !empty($new_instance['address']) ? sanitize_text_field($new_instance['address']) : '',
			'working_time' => !empty($new_instance['working_time']) ? sanitize_text_field($new_instance['working_time']) : '',
			'hotline' => !empty($new_instance['hotline']) ? sanitize_text_field($new_instance['hotline']) : '',
		];
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		echo '<h4 class="widget-title">'.pll__('Thông tin liên hệ').'</h4>';
		// Hiển thị địa chỉ với icon bản đồ
		if (!empty($instance['address'])) {
			echo '<div class="icon">';
			Icons_Manager::render_icon(['value' => 'fas fa-map-marked-alt', 'library' => 'fa-solid'], ['aria-hidden' => 'true']);
			echo '<span>' . esc_html($instance['address']) . '</span>';
			echo '</div>';
		}

		// Hiển thị thời gian làm việc với icon đồng hồ
		if (!empty($instance['working_time'])) {
			echo '<div class="icon">';
			Icons_Manager::render_icon(['value' => 'far fa-clock', 'library' => 'fa-solid'], ['aria-hidden' => 'true']);
			echo '<span>' . esc_html($instance['working_time']) . '</span>';
			echo '</div>';
		}

		// Hiển thị hotline với icon điện thoại
		if (!empty($instance['hotline'])) {
			echo '<div class="icon">';
			Icons_Manager::render_icon(['value' => 'fas fa-phone-alt', 'library' => 'fa-solid'], ['aria-hidden' => 'true']);
			echo '<span>' . esc_html($instance['hotline']) . '</span>';
			echo '</div>';
		}

		echo $args['after_widget'];
	}
}
