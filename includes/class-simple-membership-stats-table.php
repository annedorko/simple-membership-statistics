<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class Simple_Membership_Stats_Table extends WP_List_Table {
	public $data;

	public function set_data( $data ) {
		$this->data = $data;
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'label':
			case 'total':
			case 'income':
			case 'income_per':
			case 'percentage':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public function get_columns() {
		$columns = array(
			'label'      => 'Level',
			'total'      => '# Members',
			'percentage' => '% of All Members',
			'income'     => 'Est. Monthly Income',
			'income_per' => '% of Income',
		);
		return $columns;
	}

	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = array();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $this->data;
	}
}
