<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Membership_Stats
 * @subpackage Simple_Membership_Stats/admin/partials
 */

 $member_stats = new Simple_Membership_Stats_Analytics();
 $stats_table  = new Simple_Membership_Stats_Table();
 $stats_table->set_data( $member_stats->stats() );
?>
<div class="wrap">
<h2>Overview</h2>
<table class="form-table" role="presentation">
  <tr>
  <th scope="row"><label>Total Members</label></th>
  <td><?php echo esc_html( $member_stats->total_active_members() ); ?></td>
  </tr>
  <tr>
  <th scope="row"><label>Est. Monthly Income</label></th>
  <td><?php echo esc_html( $member_stats->total_monthly_income() ); ?></td>
  </tr>
</table>

<?php
$stats_table->prepare_items();
$stats_table->display();
?>
</div>
