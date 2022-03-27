<?php
// -------------------------------------------------------------
// Elohim.net - Setting page
// -------------------------------------------------------------
?>

<h1>Elohim.net - Settings</h1>

<!-- Top-level menu --> 
<div id="general" class="wrap"> 
<h2>Settings</h2>
</div>

<?php
if ( isset( $_POST['country'] ) ) {
    do_action( 'do_save_settings' );

    echo 'Successful update';
}

$options = get_option( 'elohimnet_options', array() );

?>
<form method="post" action="<?php echo admin_url( 'admin.php' ) . '?page=elohimnet_plugin_settings'; ?>">
    <input type="hidden" name="action" value="save_settings" />

    <h2>Your country</h2>

    <table>
        <tr>
            <td>
                <input type="radio" name="country" value="ca" <?php echo ('ca' === $options['country'] ? 'checked' : ''); ?>> Canada
                <input type="radio" name="country" value="mx" <?php echo ('mx' === $options['country'] ? 'checked' : ''); ?>> Mexico
                <input type="radio" name="country" value="us" <?php echo ('us' === $options['country'] ? 'checked' : ''); ?>> United-States
            </td>
        </tr>
    </table>

    <h2>Mailpoet lists id</h2>

    <table>
        <tr>
            <td>English  </td>
            <td><input type="text" name="id_EN_list" value="<?php echo esc_html( $options['id_EN_list'] ); ?>" maxlength="2" size="4"/></td>
        </tr>
        <tr>
            <td>French  </td>
            <td><input type="text" name="id_FR_list" value="<?php echo esc_html( $options['id_FR_list'] ); ?>" maxlength="2" size="4"/></td>
        </tr>
        <tr>
            <td>Spanish  </td>
            <td><input type="text" name="id_ES_list" value="<?php echo esc_html( $options['id_ES_list'] ); ?>" maxlength="2" size="4"/></td>
        </tr>
    </table>

    <h2>Unsubscribe</h2>

    <table>
        <tr>
            <td>Automatique?</td>
            <td>
                <input type="radio" name="unsubscribe" value="no"  <?php echo ('no'  === $options['unsubscribe'] ? 'checked' : ''); ?>> No
                <input type="radio" name="unsubscribe" value="yes" <?php echo ('yes' === $options['unsubscribe'] ? 'checked' : ''); ?>> Yes
            </td>
        </tr>
    </table>

    <h2>Schedule</h2>
    <table>
        <tr>
            <td>Day of execution (let empty to deactivate)</td>
            <td><input type="text" name="elohimnet_cron" value="<?php echo esc_html( $options['elohimnet_cron'] ); ?>" maxlength="1" size="1"/></td>
        </tr>
        <tr>
            <td>Send import report to </td>
            <td><input type="text" name="email_report" value="<?php echo esc_html( $options['email_report'] ); ?>" maxlength="256" size="100"/></td>
        </tr>
        <tr>
            <td>Send unsubscribers to </td>
            <td><input type="text" name="email_unsubscribers" value="<?php echo esc_html( $options['email_unsubscribers'] ); ?>" maxlength="256" size="100"/></td>
        </tr>
        <tr>
            <td>Send inactives to </td>
            <td><input type="text" name="email_inactives" value="<?php echo esc_html( $options['email_inactives'] ); ?>" maxlength="256" size="100"/></td>
        </tr>
    </table>

    <br>
    <input type="submit" value="Submit" class="button-primary"/>
</form>
