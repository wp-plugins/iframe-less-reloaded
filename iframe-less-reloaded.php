<?php
/*
Plugin Name: iFrame-less Reloaded
Plugin URI: http://gingerbreaddesign.co.uk/wordpress/iframe-less-reloaded
Description: Request a URL, and display it's contents on-page (not in an IFrame) - based on iFrame-less by Fiach Reid (http://wordpressiframe.omadataobjects.com/) 
Author: Todd Halfpenny
Version: 0.0.1
Author URI: gingerbreaddesign.co.uk/todd
*/


/**
 * gingerIFrameless Class
 */
class gingerIFrameless extends WP_Widget {
    /** constructor */
    function gingerIFrameless() {
        parent::WP_Widget(false, $name = 'iFrame-less Reloaded');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $url = apply_filters('widget_title', $instance['url']);
	$request = new WP_Http;
	$result = $request->request( htmlspecialchars_decode($url) );
	$contents = $result['body'];
	
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $contents )
                        echo $before_title . $contents . $after_title; ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['url'] = strip_tags($new_instance['url']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
	if ( $instance) {
		$url = esc_attr($instance['url']);
		}
	else {
		$url = "";
		}
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Url:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
        </p>
        <?php 
    }

} // class gingerIFrameless


// register gingerIFrameless widget
add_action('widgets_init', create_function('', 'return register_widget("gingerIFrameless");'));

?>