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
?>

<div class="main">
  <ul>
	<li class="heading">
	  <span>Level</span>
	  <span>Members</span>
	  <span>Income</span>
	  <span>% of Income</span>
	</li>
	<?php
	foreach ( $member_stats->stats() as $level ) {
		?>
	  <li>
		<span><?php echo esc_html( $level['label'] ); ?></span>
		<span><?php echo esc_html( $level['total'] ); ?></span>
		<span><?php echo esc_html( $level['income'] ); ?></span>
		<span><?php echo esc_html( $level['income_per'] ); ?></span>
	  </li>
		<?php
	}
	?>
  </ul>
</div>
<div class="sub">
  <p style="display: flex;">
	<span style="width: 50%; text-align: left;"><strong>Total Members</strong> <?php echo esc_html( $member_stats->total_active_members() ); ?></span>
	<span style="width: 50%; text-align: right;"><strong>Est. Monthly Income</strong> <?php echo esc_html( $member_stats->total_monthly_income() ); ?></span>
  </p>
</div>
