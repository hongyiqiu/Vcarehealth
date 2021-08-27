<?php

class WPDDL_Integration_Layouts_Row_Type_Content
	extends WPDDL_Integration_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = '2017_content';
		$this->name = 'Content';
		$this->desc = '<b>Twenty Seventeen</b> content row';

		$this->setCssId( 'content' );
		$this->addCssClass( 'site-content' );
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
			echo '<div class="site-content-contain">';
			echo '<div ' . $el_id . ' class="' . $el_css . '" '.$this->renderDataAttributes($row, $renderer).'>';
			echo '<div class="wrap">';
			echo '<div class="' . $args['row_class'] . $args['type'] . '">';

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {
			$output = '</div></div></div><!-- #content -->';
			//$output = '</div></div>';
			$output .= '</div><!-- .site-content-contain content -->';
		}

		return $output;
	}
}