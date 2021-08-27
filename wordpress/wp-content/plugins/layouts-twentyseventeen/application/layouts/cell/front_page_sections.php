<?php
/**
 * 2017 front page sections cell
 */


/**
 * Cell abstraction. Defines the cell with Layouts.
 */
class WPDDL_Integration_Layouts_Cell_Front_Page_Sections extends WPDDL_Cell_Abstract {
	protected $id = '2017-front-page-sections';

	protected $factory = 'WPDDL_Integration_Layouts_Cell_Front_Page_Sections_Cell_Factory';
}


/**
 * Represents the actual cell.
 */
class WPDDL_Integration_Layouts_Cell_Front_Page_Sections_Cell extends WPDDL_Cell_Abstract_Cell {
	protected $id = '2017-front-page-sections';

	/**
	 * Each cell has it's view, which is a file that is included when the cell is being rendered.
	 *
	 * @return string Path to the cell view.
	 */
	protected function setViewFile() {
		return dirname( __FILE__ ) . '/view/front_page_sections.php';
	}
}


/**
 * Cell factory.
 */
class WPDDL_Integration_Layouts_Cell_Front_Page_Sections_Cell_Factory extends WPDDL_Cell_Abstract_Cell_Factory {
	protected $name = 'Front Page Sections';
	protected $description = 'Displays content sections for selected pages in theme options.';

	protected $cell_class = 'WPDDL_Integration_Layouts_Cell_Front_Page_Sections_Cell';

	protected function setCellImageUrl() {
		$this->cell_image_url = DDL_ICONS_SVG_REL_PATH . 'generic-cell.svg';
	}

	protected function _dialog_template() {
		ob_start();
		?>

		<div class="ddl-form menu-cell">
			<p class="toolset-alert toolset-alert-info">
				<?php
				_e('You can create an even better version of this feature using Toolset. To learn more, visit the page about <a href="https://wp-types.com/documentation/user-guides/toolset-twenty-seventeen-integration/creating-improved-front-page-sections-using-Toolset/" target="_blank">creating improved Front Page Sections</a>.', 'ddl-layouts');
				?>
			</p>
		</div>

		<?php
		return ob_get_clean();
	}
}