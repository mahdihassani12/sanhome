<?php
if ( ! class_exists( 'RECRM_initiate' ) ) {

	/**
	 * Initiate plugin's module
	 */
	class RECRM_initiate {

		public function __construct() {
			$this->initiate_modules();
		}

		public function initiate_modules(){
			require_once dirname( __FILE__ ) . '/helper-functions.php';
			require_once dirname( __FILE__ ) . '/class-recrm-post-types.php';
			require_once dirname( __FILE__ ) . '/class-recrm-admin-menu.php';
			require_once dirname( __FILE__ ) . '/class-settings-api.php';
			require_once dirname( __FILE__ ) . '/class-recrm-settings.php';
			require_once dirname( __FILE__ ) . '/class-recrm-meta-boxes.php';
			require_once dirname( __FILE__ ) . '/class-recrm-custom-columns.php';
			require_once dirname( __FILE__ ) . '/class-recrm-get-posts-from-form.php';

			if ( function_exists( 'inspiry_is_realhomes_registered' ) ) {
				if ( inspiry_is_realhomes_registered() ) {
					require_once dirname( __FILE__ ) . '/plugin-update.php';   // plugin update functions
				}
			}
		}

	}

	new RECRM_initiate();
}

