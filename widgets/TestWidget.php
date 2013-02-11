<?php
/**
 * Example Widget Class
 */
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors',1);

class TestWidget extends WP_Widget {
    /** constructor -- name this the same as the class above */
    function __construct(){
        parent::__construct(false, 'Guardian RSS Widget', array('description' => 'To be included with the "Guardian RSS Project Plugin"! A control that allows you to specify a custom search term for the RSS feed. The default is "Fish"'));  
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    //AFAIK, controls the *ON PAGE* widget form. Has a list of args supplied with it that makes it cleaner to format ($before_title etc)
    function widget($args, $instance) {
      //explode the array into all the variables it contains ($beforeWidget/$afterWidget = $before+after divs)
      extract($args);

      //set the title
      $title = "Search term";

      echo($before_widget);
        echo($before_title.$title.$after_title);
        //widget content here
        echo("<forn action='update.php'>");
          echo("<input id='searchInput' name='searchInput' type='text' value='".get_option('searchTerm')."' />");
          echo("<br />");
          echo("<button id='searchButton' name='searchButton' type='submit'>Submit search</button>");
         echo("</form>");
      echo($after_widget);
    }
 
    /** @see WP_Widget::update -- do not rename this */
    //AFAIK is called when a button from the widget form below is activated
    function update($new_instance, $old_instance) { 

      return $instance; 
    }
 
    /** @see WP_Widget::form -- do not rename this */
    //AFAIK, controls the widget menu form.
    function form($instance) {  
        $search = esc_attr(@$instance['search']);
        if (!$search) {
          $search = get_option('searchTerm');
        }
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('search'); ?>"><?php _e('Search Term'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('search'); ?>" name="<?php echo $this->get_field_name('search'); ?>" type="text" value="<?php echo $search; ?>" />
        </p>
        <? 
    }
 
} // end class example_widget
add_action('widgets_init', create_function('', 'return register_widget("TestWidget");'));
?>