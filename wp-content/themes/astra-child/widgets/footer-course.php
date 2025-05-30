<?php

class Astra_Child_Custom_Widget_Footer_Course extends WP_Widget {
		public function __construct() {
				parent::__construct(
						'astra_child_custom_widget_footer_course',
						__('Footer Course', 'astra-child'),
						array('description' => __('Footer Course', 'astra-child'))
				);
		}

		public function widget($args, $instance) {
			echo $args['before_widget'];

			echo '<h4 class="widget-title">Khóa học</h4>';
			echo '<div class="list">
				<a href="#">Khóa học giao tiếp tiếng anh</a>
				<a href="#">Khóa học giao tiếp tiếng anh</a>
				<a href="#">Khóa học giao tiếp tiếng anh</a>
				<a href="#">Khóa học giao tiếp tiếng anh</a>
			</div>';

			echo $args['after_widget'];
	}
	
}
