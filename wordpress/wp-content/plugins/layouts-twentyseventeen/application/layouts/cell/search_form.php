<?php
/**
 * 2017 search form cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Search_Form extends WPDDL_Cell_Abstract {
	protected $id = '2017-search-form';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Search_Form_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Search_Form_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2017-search-form';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/search_form.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Search_Form_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Search Form';
	protected $description = 'Displays site search form.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Search_Form_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = plugins_url( '/../../../public/img/search-form.svg', __FILE__ );
	}
}