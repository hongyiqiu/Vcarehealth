<?php
/**
 * 2017 top menu cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Top_Menu extends WPDDL_Cell_Abstract {
	protected $id = '2017-top-menu';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Top_Menu_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Top_Menu_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2017-top-menu';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/top_menu.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Top_Menu_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Top Menu';
	protected $description = 'Displays top navigation.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Top_Menu_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-menu-cell.svg';
	}
}