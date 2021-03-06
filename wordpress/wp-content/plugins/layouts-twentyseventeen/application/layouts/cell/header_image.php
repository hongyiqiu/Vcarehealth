<?php
/**
 * 2017 header image cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Header_Image extends WPDDL_Cell_Abstract {
	protected $id = '2017-header-image';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Header_Image_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Header_Image_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2017-header-image';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/header_image.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Header_Image_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Header Image';
	protected $description = 'Displays header image.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Header_Image_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'layouts-imagebox-cell.svg';
	}
}