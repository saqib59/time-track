<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
    $pages          = get_pages();
    $selected_pages = get_option( 'track_time_selected_pages', [] );
?>
<div class="wrap">
    <h1><?php _e( 'Track Time Settings', 'track-time' ); ?></h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'track_time_settings_group' ); ?>
        <?php do_settings_sections( 'track_time_settings_group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e( 'Select Pages to Track', 'track-time' ); ?></th>
                <td>
                    <input type="checkbox" id="select_all" /> <?php _e( 'Select All', 'track-time' ); ?><br>
                    <?php foreach ( $pages as $page ) { ?>
                        <input type="checkbox" name="track_time_selected_pages[]" value="<?php echo $page->ID; ?>" <?php echo in_array( $page->ID, $selected_pages ) ? 'checked' : ''; ?> /> <?php echo $page->post_title; ?><br>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
