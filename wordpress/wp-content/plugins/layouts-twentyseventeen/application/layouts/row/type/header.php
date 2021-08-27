<?php

class WPDDL_Integration_Layouts_Row_Type_Header
	extends WPDDL_Integration_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = '2017_header';
		$this->name = 'Header';
		$this->desc = '<b>Twenty Seventeen</b> header row';

		$this->setCssId( 'mast-head' );
		$this->addCssClass( 'site-header' );
		$this->enableSameHeightColumns();

		parent::setup();
	}

	public function htmlOpen( $markup, $args, $row = null, $renderer = null ) {

		if( $args['mode'] === $this->id ) {

			$el_css = 'full-bg';

			$css_classes = $this->getCssClasses();

			$el_css .= ! empty( $css_classes )
				? ' ' . implode( $css_classes, ' ' )
				: '';

			$el_css .= isset( $args['additionalCssClasses'] )
				? ' '.$args['additionalCssClasses']
				: '';

			$el_id = isset( $args['cssId'] ) && ! empty( $args['cssId'] )
				? ' id="' . $args['cssId'] . '"'
				: ' id="' . $this->getCssId() . '"';

			ob_start();
			echo '<header ' . $el_id . ' class="' . $el_css . '" role="banner" '.$this->renderDataAttributes($row, $renderer).'>';
			echo '<div class="' . $args['row_class'] . $args['type'] . '">';

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {
			$output = '</div></header><!-- #masthead -->';
		}

		return $output;
	}
}