<?php
class Simple_Membership_Stats_Analytics {

	/**
	 * Holding values
	 * @var array()
	 */
	private $members  = array();
	private $levels   = array();
	private $payments = array();
	/**
	 * Statistics
	 * @var [type]
	 */
	private $level_statistics = array();
	private $active_members   = 0;
	private $most_popular     = '';

	/**
	 * Format settings
	 * @var [type]
	 */
	private $fmt;
	private $currency = 'EUR';

	public function __construct() {
		$this->set_subscribers();
		$this->set_member_analytics();
		// Formatting for currency
		$this->fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
		$this->fmt->setTextAttribute( NumberFormatter::CURRENCY_CODE, $this->currency );
		$this->fmt->setAttribute( NumberFormatter::FRACTION_DIGITS, 2 );
		// Set statistics data
		$this->calculate_level_statistics();
		$this->calculate_most_popular_level();
	}

	public function stats() {
		$sort = $this->sort_by_sub_value( $this->level_statistics, 'total', false );
		return $sort;
	}

	public function total_active_members() {
		return count( $this->members );
	}

	public function total_monthly_income() {
		return $this->fmt->formatCurrency( array_sum( $this->payments ), $this->currency );
	}

	public function total_monthly_income_int() {
		return array_sum( $this->payments );
	}

	public function most_popular_level() {
		return $this->most_popular;
	}

	private function set_member_analytics() {
		// Dump users
		foreach ( $this->members as $member ) {
			$this->set_user_membership_data( $member );
		}
	}

	private function calculate_level_statistics() {
		foreach ( $this->levels as $level_name => $level ) {
			$total          = count( $level['users'] );
			$percent        = round( $total * 100 / $this->total_active_members() );
			$gross_income   = array_sum( $level['payments'] );
			$inc_percentage = round( $gross_income * 100 / array_sum( $this->payments ) );
			if ( $gross_income > 0 ) {
				// Only add values to the table if they bring in income
				$this->level_statistics[] = array(
					'label'      => $level_name,
					'total'      => $total,
					'percentage' => $percent . '%',
					'income'     => $this->fmt->formatCurrency( $gross_income, $this->currency ),
					'income_per' => $inc_percentage . '%',
				);
			}
		}
	}

	private function calculate_most_popular_level() {
		$sort = $this->sort_by_sub_value( $this->level_statistics, 'total', false );
		if ( ! empty( $sort ) ) {
			$this->most_popular = $sort[0]['label'];
		}
	}

	private function set_subscribers() {
		// Query subscribers
		$this->members = $this->get_all_active_members();
	}

	private function set_user_membership_data( $member ) {
		// var_dump( $member );
		$level_name   = SwpmMembershipLevelUtils::get_membership_level_name_by_level_id( $member->membership_level );
		$last_payment = 0;
		if ( ! empty( $member->subscr_id ) ) {
			$last_payment = $this->get_last_payment( $member->subscr_id );
		}
		$this->levels[ $level_name ]['users'][]    = $member->member_id;
		$this->levels[ $level_name ]['payments'][] = $last_payment;
		$this->payments[]                          = $last_payment;
	}

	private function get_all_active_members() {
		//Retrieves all the SWPM user records for the given membership level
		global $wpdb;
		$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}swpm_members_tbl WHERE account_state = %s", 'active' ) );
		return $result;
	}


	private function get_last_payment( $subscr_id ) {
		global $wpdb;
		$get_last_payment = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}swpm_payments_tbl WHERE subscr_id = %s ORDER BY txn_date DESC LIMIT 1",
				$subscr_id
			),
			OBJECT
		);
		return intval( $get_last_payment[0]->payment_amount );
	}

	/**
	* @param array $array
	* @param string $value
	* @param bool $asc - ASC (true) or DESC (false) sorting
	* @param bool $preserve_keys
	* @return array
	* */
	private function sort_by_sub_value( $array, $value, $asc = true, $preserve_keys = false ) {
		if ( is_object( reset( $array ) ) ) {
			$preserve_keys ? uasort(
				$array,
				function ( $a, $b ) use ( $value, $asc ) {
					return $a->{$value} == $b->{$value} ? 0 : ( $a->{$value} <=> $b->{$value} ) * ( $asc ? 1 : -1 );
				}
			) : usort(
				$array,
				function ( $a, $b ) use ( $value, $asc ) {
					return $a->{$value} == $b->{$value} ? 0 : ( $a->{$value} <=> $b->{$value} ) * ( $asc ? 1 : -1 );
				}
			);
		} else {
			$preserve_keys ? uasort(
				$array,
				function ( $a, $b ) use ( $value, $asc ) {
					return $a[ $value ] == $b[ $value ] ? 0 : ( $a[ $value ] <=> $b[ $value ] ) * ( $asc ? 1 : -1 );
				}
			) : usort(
				$array,
				function ( $a, $b ) use ( $value, $asc ) {
					return $a[ $value ] == $b[ $value ] ? 0 : ( $a[ $value ] <=> $b[ $value ] ) * ( $asc ? 1 : -1 );
				}
			);
		}
		return $array;
	}

}
