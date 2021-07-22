<?php
// -------------------------------------------------------------
// Elohim.net - Admin page
// -------------------------------------------------------------
?>

<h1>Elohim.net - Admin page</h1>

<?php
    global $wpdb;

    $url_add_new = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&id_import=new';
    $url_add_resume = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&id_import=resume';
    $url_help = admin_url( 'admin.php' ) . '?page=elohimnet_plugin_help';
    $url_admin = admin_url( 'admin.php' ) . '?page=elohimnet_plugin';
    $url_log = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&id_import=';
    $url_imported = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=imported&id_import=';
    $url_valid = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=valid&id_import=';
    $url_new = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=new&id_import=';
    $url_deleted = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=deleted&id_import=';
    $url_updated = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=updated&id_import=';
    $url_bad = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=bad&id_import=';
    $url_unsub = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=unsub&id_import=';
    $url_refused = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=refused&id_import=';
    $url_inactive = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=inactive&id_import=';
    $url_real = admin_url( 'admin.php' ) . '?page=elohimnet_plugin&tag=real&id_import=';

    ?>

<!-- Top-level menu -->
<div id="general" class="wrap">
<h2>Imports from Elohim.net
    <a class="add-new-h2" href="<?php echo $url_add_new ?>">New Import</a>
    <a class="add-new-h2" href="<?php echo $url_add_resume ?>">Resume last import</a>
</h2>

<?php
// ---------------------------------------------------------------
// Lancer une importation
// ---------------------------------------------------------------
if ( isset( $_GET['id_import'] ) && ( 'new' == $_GET['id_import'] ) ) {
    do_action( 'do_import' );
}

// ---------------------------------------------------------------
// Reprendre une importation
// ---------------------------------------------------------------
if ( 'resume' == $_GET['id_import'] ) {
    do_action( 'do_resume' );
}

// ---------------------------------------------------------------
// Afficher le tableau des importations
// ---------------------------------------------------------------
if ( ( ! isset( $_GET['id_import'] ) ) || ( 'resume' == $_GET['id_import'] ) ) {
    $query = 'select id_import, date_extraction, nb_import, nb_valid, nb_new, nb_deleted, nb_updated, nb_bad, nb_unsub_returned, nb_unsub_returned_refused, nb_mailpoet_inactive, nb_mailpoet_active from elohimnet_import order by id_import desc';
    $imports = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>List of imports</h3>
    <a href="<?php echo $url_help ?>" target="_blank">Help</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 30px">Id</th>
                <th style="width: 150px">Date</th>
                <th>Imported</th>
                <th>Valid</th>
                <th>New</th>
                <th>Unsubscribed</th>
                <th>Updated</th>
                <th>Unsubscriptions to send to Elohim.net</th>
                <th><?php echo '<a href="' . $url_refused . '">'?>Unsubscribers not applied by Elohim.net</th>
                <th><?php echo '<a href="' . $url_bad . '">'?>Bounced, Invalid & Unsubscribed in Mailpoet</th>
                <th><?php echo '<a href="' . $url_inactive . '">'?>Inactive in Mailpoet</th>
                <th><?php echo '<a href="' . $url_real . '">'?>Subscribed in Mailpoet</th>
            </tr>
        </thead>

        <?php
            // Display imports
            if ( $imports ) {
                foreach ( $imports as $import ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td><a href="' . $url_log . $import['id_import'] . '">' . $import['id_import'] . '</a></td>';
                    echo '<td>' . $import['date_extraction'] . '</td>';
                    echo '<td><a href="' . $url_imported . $import['id_import'] . '">' . $import['nb_import'] . '</a></td>';
                    echo '<td><a href="' . $url_valid . $import['id_import'] . '">' . $import['nb_valid'] . '</a></td>';
                    echo '<td><a href="' . $url_new . $import['id_import'] . '">' . $import['nb_new'] . '</a></td>';
                    echo '<td><a href="' . $url_deleted . $import['id_import'] . '">' . $import['nb_deleted'] . '</a></td>';
                    echo '<td><a href="' . $url_updated . $import['id_import'] . '">' . $import['nb_updated'] . '</a></td>';
                    echo '<td><a href="' . $url_unsub . $import['id_import'] . '">' . $import['nb_unsub_returned'] . '</a></td>';
                    echo '<td>' . $import['nb_unsub_returned_refused'] . '</td>';
                    echo '<td>' . $import['nb_bad'] . '</td>';
                    echo '<td>' . $import['nb_mailpoet_inactive'] . '</td>';
                    echo '<td>' . $import['nb_mailpoet_active'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No imports found</td></tr>';
            }
        ?>
    </table>
<?php
}

// ---------------------------------------------------------------
// Afficher le log
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( ! isset( $_GET['tag'] ) ) ) {
    $query = 'SELECT id_import, comment, date_log FROM elohimnet_log WHERE id_import=' . $_GET['id_import'];
    $logs = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Execution log</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th style="width: 100px">Date</th>
                <th style="width: 500px">Comment</th>
            </tr>
        </thead>

        <?php
            if ( $logs ) {
                foreach ( $logs as $log ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $log['id_import'] . '</td>';
                    echo '<td>' . $log['date_log'] . '</td>';
                    echo '<td>' . $log['comment'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No log found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Imported
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'imported' ) ) {
    $query = 'SELECT id_import, email, language, type, firstname, lastname, nickname, town, state, level, gender, transmission, Followstatus FROM elohimnet_import_email WHERE id_import=' . $_GET['id_import'] . ' ORDER BY email';
    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Imported</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $result['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No imported found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Valid
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'valid' ) ) {
    $query = 'SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus FROM elohimnet_email_data d JOIN elohimnet_email_valid v ON v.email = d.email WHERE v.id_import=' . $_GET['id_import'] . ' ORDER BY d.email';
    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Valid</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No imported found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - New
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'new' ) ) {
    $query = 'SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus FROM elohimnet_email_data d JOIN elohimnet_import_new n ON n.email = d.email WHERE n.id_import=' . $_GET['id_import'] . ' ORDER BY d.email';
    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>New</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No new email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Unsubscribed
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'deleted' ) ) {
    $query = 'SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus FROM elohimnet_email_data d JOIN elohimnet_import_deleted de ON de.email = d.email WHERE de.id_import=' . $_GET['id_import'] . ' ORDER BY d.email';
    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Unsubscribed</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No deleted email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Updated
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'updated' ) ) {
    $query = 'SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus FROM elohimnet_email_data d JOIN elohimnet_import_updated u ON u.email = d.email WHERE u.id_import=' . $_GET['id_import'] . ' ORDER BY d.email';
    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Updated</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No updated email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Bad
// ---------------------------------------------------------------
if ( ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'bad' ) ) {
    $options = get_option( 'elohimnet_options', array() );

    $list = '';

    switch ( $options['country']) {
       case 'ca':
          $list = $options['id_FR_list'] . ',' . $options['id_EN_list'];
          break;
       case 'mx':
          $list = $options['id_ES_list'];
          break;
       case 'us':
          $list = $options['id_EN_list'];
          break;
    }

    $query = "SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus
                FROM
                    wp_mailpoet_subscribers mp
                    JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = mp.id
                    JOIN elohimnet_email_data d on d.email = mp.email
                WHERE mp.status Not in ('subscribed', 'inactive')
                    AND seg.segment_id in (" . $list . ")
                ORDER BY d.email";

    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Bounced, Invalid & Unsubscribed in Mailpoet</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No bad email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Unsubscribers returned to Elohim.net
// ---------------------------------------------------------------
if ( ( isset( $_GET['id_import'] ) ) && ( is_numeric( $_GET['id_import'] ) ) && ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'unsub' ) ) {
    $query = "SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus
                FROM
                    elohimnet_unsubscribers_return_to_elohim_net u
                    JOIN elohimnet_email_data d
                    on d.email = u.email
                    WHERE u.id_import=" . $_GET['id_import'] . " ORDER BY d.email";

    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Unsubscriptions to send to Elohim.net</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th style="width: 20px">Id</th>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $_GET['id_import'] . '</td>';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No unsubscribers email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Unsubscribers returned to Elohim.net refused
// ---------------------------------------------------------------
if ( ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'refused' ) ) {
    $query = "SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus
                FROM
                        elohimnet_unsubscribers_return_to_elohim_net ret
                        JOIN elohimnet_import_email ie on ie.email = ret.email
                        JOIN elohimnet_email_data d on d.email = ret.email
                    WHERE ie.FollowStatus Not in ('Email bounced','Not interested')
                    AND ie.type in ('M','S','R','P','XM','XR','XS')
                    AND ie.id_import = (SELECT MAX(id_import) From elohimnet_import)
                ORDER BY d.email";

    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Unsubscribers not applied by Elohim.net</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No unsubscribers email found</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Inactive subscribers in Mailpoet
// ---------------------------------------------------------------
if ( ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'inactive' ) ) {
    $options = get_option( 'elohimnet_options', array() );

    $list = '';

    switch ( $options['country']) {
       case 'ca':
          $list = $options['id_FR_list'] . ',' . $options['id_EN_list'];
          break;
       case 'mx':
          $list = $options['id_ES_list'];
          break;
       case 'us':
          $list = $options['id_EN_list'];
          break;
    }

    $query = "SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus
                FROM
                    wp_mailpoet_subscribers sub
                    JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = sub.id
                    JOIN elohimnet_email_data d on d.email = sub.email
                    WHERE seg.segment_id in (" . $list . ") And sub.status = 'inactive'
                    ORDER BY d.email";

    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Inactive in Mailpoet</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No inactive subscribers found in Mailpoet</td></tr>';
            }
        ?>
    </table>

    <?php
}

// ---------------------------------------------------------------
// Afficher - Real subscribers in Mailpoet
// ---------------------------------------------------------------
if ( ( isset( $_GET['tag']) ) && ( $_GET['tag'] === 'real' ) ) {
    $options = get_option( 'elohimnet_options', array() );

    $list = '';

    switch ( $options['country']) {
       case 'ca':
          $list = $options['id_FR_list'] . ',' . $options['id_EN_list'];
          break;
       case 'mx':
          $list = $options['id_ES_list'];
          break;
       case 'us':
          $list = $options['id_EN_list'];
          break;
    }

    $query = "SELECT d.email, d.language, d.type, d.firstname, d.lastname, d.nickname, d.town, d.state, d.level, d.gender, d.transmission, d.Followstatus
                FROM
                    wp_mailpoet_subscribers sub
                    JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = sub.id
                    JOIN elohimnet_email_data d on d.email = sub.email
                    WHERE seg.segment_id in (" . $list . ") And sub.status = 'subscribed' And seg.status = 'subscribed' ORDER BY d.email";

    $results = $wpdb->get_results( $query, ARRAY_A );
    ?>

    <h3>Subscribed in Mailpoet</h3>
    <a href="<?php echo $url_admin ?>">Return</a>
    <p></p>

    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th>Email</th>
                <th>Language</th>
                <th>Type</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Nickname</th>
                <th>Town</th>
                <th>State</th>
                <th>Level</th>
                <th>Gender</th>
                <th>Transmission</th>
                <th>Follow Status</th>
            </tr>
        </thead>

        <?php
            if ( $results ) {
                foreach ( $results as $result ) {
                    echo '<tr style="background: #FFF">';
                    echo '<td>' . $result['email'] . '</td>';
                    echo '<td>' . $result['language'] . '</td>';
                    echo '<td>' . $result['type'] . '</td>';
                    echo '<td>' . $result['firstname'] . '</td>';
                    echo '<td>' . $result['lastname'] . '</td>';
                    echo '<td>' . $result['nickname'] . '</td>';
                    echo '<td>' . $result['town'] . '</td>';
                    echo '<td>' . $result['state'] . '</td>';
                    echo '<td>' . $result['level'] . '</td>';
                    echo '<td>' . $result['gender'] . '</td>';
                    echo '<td>' . $result['transmission'] . '</td>';
                    echo '<td>' . $result['Followstatus'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background: #FFF">';
                echo '<td colspan="3">No subscribers found in Mailpoet</td></tr>';
            }
        ?>
    </table>

    <?php
}
?>
<br />
</div>
