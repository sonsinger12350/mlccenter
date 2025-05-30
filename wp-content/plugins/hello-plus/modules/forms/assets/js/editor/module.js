import Component from './component';
import FieldsMapControl from './fields-map-control';
import FieldsRepeaterControl from './fields-repeater-control';

export default class FormsModule extends elementorModules.editor.utils.Module {
	onElementorInit() {
		const ReplyToField = require( './reply-to-field' );

		this.replyToField = new ReplyToField();

		// Form fields
		const AcceptanceField = require( './fields/acceptance' ),
			TelField = require( './fields/tel' );

		this.Fields = {
			tel: new TelField( 'ehp-form' ),
			acceptance: new AcceptanceField( 'ehp-form' ),
		};

		elementor.addControlView( 'Fields_map', FieldsMapControl );
		elementor.addControlView( 'form-fields-repeater', FieldsRepeaterControl );

		elementorPromotionsData.collect_submit = window.ehpFormsPromotionData;
	}

	onElementorInitComponents() {
		$e.components.register( new Component( { manager: this } ) );
	}
}
