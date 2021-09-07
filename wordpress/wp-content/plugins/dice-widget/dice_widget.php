<?php
/**
 * Plugin Name: Dice Roller
 * Plugin URI: http://www.korpg.com/blog/dice-roller-wordpress-widget/
 * Description: A widget that rolls random numbers of the form NdX+/-M or NeX+/-M as set in the admin widget panel.
 * Version: 1.4
 * Author: Kevin Oedekoven
 * Author URI: http://www.korpg.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'load_dice_widget' );

/**
 * Register our widget.
 */
function load_dice_widget()
{
	register_widget( 'Dice_Widget' );
}

/**
 * Dice Widget class.
 */
class Dice_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Dice_Widget()
	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Dice', 'description' => __('A widget that rolls random numbers of the form NdX+/-M.', 'Dice') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'dice-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'dice-widget', __('Dice', 'Dice'), $widget_ops, $control_ops );
	}

	/**
	 * Display the widget on the screen.
	 */
	function widget( $args, $instance )
	{
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$roll = $instance['roll'];
		$ex_count = $instance['ex_count'];
		$result = $instance['result'];
		$N = $instance['N'];
		$X = $instance['X'];
		$M = $instance['M'];
		$E = $instance['E'];
		$i = $instance['i'];
		$R = $instance['R'];
		$B_link = $instance['B_link'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* result = NdX+M */
		/* roll and i are used to explode dice */
		/* R is used for reroll on 1 */
		if ( $R=='yes' ) //Reroll
			{
			if ( $E=='yes' ) //Reroll and Explode
				{
				for ($i=1; $i<=$N; $i++)
					{
					$roll = rand(2,$X);
					$result = $result + $roll;
					while ($roll == $X)
						{
						$roll = rand(2,$X);
						$result = $result + $roll;
						$ex_count++;
						}
					}
				}
			else //Just Reroll
				{
				for ($i=1; $i<=$N; $i++)
					{
					$roll = rand(2,$X);
					$result = $result + $roll;
					}
				}
			}
		else //Keep
			{
			if ( $E=='yes' ) //Keep and Explode
				{
				for ($i=1; $i<=$N; $i++)
					{
					$roll = rand(1,$X);
					$result = $result + $roll;
					while ($roll == $X)
						{
						$roll = rand(1,$X);
						$result = $result + $roll;
						$ex_count++;
						}
					}
				}
			else //Just Keep
				$result = rand($N,$N*$X);
			}
		//Add modifier M
		$result = $result+$M;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display result from widget settings if one was generated from inputs. */
		if ( $result )
			{
			if ( $E=='yes')
				{
				if ($M==0)
					printf( '<p>' . __('Result: %de%d = %d (%d explosions)', 'Dice') . '</p>', $N, $X, $result, $ex_count );
				else
					printf( '<p>' . __('Result: %de%d%+d = %d (%d explosions)', 'Dice') . '</p>', $N, $X, $M, $result, $ex_count );
				printf( '</center>' );
				}
			else
				{
				if ($M==0)
					printf( '<p>' . __('Result: %dd%d = %d', 'Dice') . '</p>', $N, $X, $result );
				else
					printf( '<p>' . __('Result: %dd%d%+d = %d', 'Dice') . '</p>', $N, $X, $M, $result );
				}
			}

		/* Display a link to the widget page at korpg.com */
		if ( $B_link=='yes' )
			printf('<hr><em><center><a href="http://www.korpg.com" rel="nofollow">korpg</a></center></em>');

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['result'] = $new_instance['result'];
		$instance['roll'] = $new_instance['roll'];
		$instance['N'] = $new_instance['N'];
		$instance['X'] = $new_instance['X'];
		$instance['M'] = $new_instance['M'];
		$instance['E'] = $new_instance['E'];
		$instance['R'] = $new_instance['R'];
		$instance['i'] = $new_instance['i'];
		$instance['ex_count'] = $new_instance['ex_count'];
		$instance['B_link'] = $new_instance['B_link'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Dice', 'dice'), 'N' => __('1', 'dice'), 'result' => __(0, 'dice'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Number of dice N: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'N' ); ?>"><?php _e('Number of dice:', 'dice'); ?></label>
			<input id="<?php echo $this->get_field_id( 'N' ); ?>" name="<?php echo $this->get_field_name( 'N' ); ?>" value="<?php echo $instance['N']; ?>" style="width:25%;" />
		</p>

		<!-- Dice X: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'X' ); ?>"><?php _e('Die to roll:', 'X'); ?></label>
			<select id="<?php echo $this->get_field_id( 'X' ); ?>" name="<?php echo $this->get_field_name( 'X' ); ?>" class="widefat" style="width:25%;">
				<option <?php if ( '4' == $instance['X'] ) echo 'selected="selected"'; ?>>4</option>
				<option <?php if ( '6' == $instance['X'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '8' == $instance['X'] ) echo 'selected="selected"'; ?>>8</option>
				<option <?php if ( '10' == $instance['X'] ) echo 'selected="selected"'; ?>>10</option>
				<option <?php if ( '12' == $instance['X'] ) echo 'selected="selected"'; ?>>12</option>
				<option <?php if ( '20' == $instance['X'] ) echo 'selected="selected"'; ?>>20</option>
				<option <?php if ( '100' == $instance['X'] ) echo 'selected="selected"'; ?>>100</option>
			</select>
		</p>
		<!-- Modifier N: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'M' ); ?>"><?php _e('Modifier:', 'dice'); ?></label>
			<input id="<?php echo $this->get_field_id( 'M' ); ?>" name="<?php echo $this->get_field_name( 'M' ); ?>" value="<?php echo $instance['M']; ?>" style="width:25%;" />
		</p>
		<!-- Explode E: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'E' ); ?>"><?php _e('Explode Dice on maximum roll:', 'dice'); ?></label>
 	        	<select id="<?php echo $this->get_field_id( 'E' ); ?>" name="<?php echo $this->get_field_name( 'E' ); ?>" class="widefat" style="width:25%;">
				<option <?php if ( 'no' == $instance['E'] ) echo 'selected="selected"'; ?>>no</option>
				<option <?php if ( 'yes' == $instance['E'] ) echo 'selected="selected"'; ?>>yes</option>
			</select>
		</p>
		<!-- Reroll R: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'R' ); ?>"><?php _e('Reroll Dice on minimum roll:', 'dice'); ?></label>
 	        	<select id="<?php echo $this->get_field_id( 'R' ); ?>" name="<?php echo $this->get_field_name( 'R' ); ?>" class="widefat" style="width:25%;">
				<option <?php if ( 'no' == $instance['R'] ) echo 'selected="selected"'; ?>>no</option>
				<option <?php if ( 'yes' == $instance['R'] ) echo 'selected="selected"'; ?>>yes</option>
			</select>
		</p>

		<!-- Display Backlink B_link: Checkbox -->
		<p>
			<label for="<?php echo $this->get_field_id( 'B_link' ); ?>"><?php _e('Show Backlink to korpg:', 'dice'); ?></label>
			<select id="<?php echo $this->get_field_id( 'B_link' ); ?>" name="<?php echo $this->get_field_name( 'B_link' ); ?>" class="widefat" style="width:25%;">
				<option <?php if ( 'no' == $instance['B_link'] ) echo 'selected="selected"'; ?>>no</option>
				<option <?php if ( 'yes' == $instance['B_link'] ) echo 'selected="selected"'; ?>>yes</option>
			</select>
		</p>
	<?php
	}
}

?>