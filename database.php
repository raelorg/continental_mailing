<?php

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class cDatabase {

    function __construct() {
    }

    function create_elohimnet_import() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import` (
                `id_import` int(11) NOT NULL AUTO_INCREMENT,
                `date_extraction` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `nb_import` int(11) NOT NULL DEFAULT 0,
                `nb_valid` int(11) NOT NULL DEFAULT 0,
                `nb_new` int(11) NOT NULL DEFAULT 0,
                `nb_deleted` int(11) NOT NULL DEFAULT 0,
                `nb_updated` int(11) NOT NULL DEFAULT 0,
                `nb_bad` int(11) NOT NULL DEFAULT 0,
                `nb_unsub_returned` int(11) NOT NULL DEFAULT 0,
                `nb_unsub_returned_refused` int(11) NOT NULL DEFAULT 0,
                `nb_mailpoet_inactive` int(11) NOT NULL DEFAULT 0,
                `nb_mailpoet_active` int(11) NOT NULL DEFAULT 0,
                PRIMARY KEY  (`id_import`)
            ) $charset_collate;";

        dbDelta( $query );    
    }

    function create_elohimnet_import_email() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import_email` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                `language` varchar(100) DEFAULT NULL,
                `type` varchar(100) DEFAULT NULL,
                `firstname` varchar(100) DEFAULT NULL,
                `lastname` varchar(100) DEFAULT NULL,
                `nickname` varchar(100) DEFAULT NULL,
                `town` varchar(100) DEFAULT NULL,
                `state` varchar(100) DEFAULT NULL,
                `level` varchar(100) DEFAULT NULL,
                `gender` varchar(100) DEFAULT NULL,
                `transmission` varchar(100) DEFAULT NULL,
                `datestamp` varchar(100) DEFAULT NULL,
                `FollowStatus` varchar(2048) DEFAULT NULL,
                PRIMARY KEY (`id_import`,`email`)
            ) $charset_collate;";

        dbDelta( $query );    
    }

    function create_elohimnet_import_email_list() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import_email_list` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                `list` varchar(100) NOT NULL,
                PRIMARY KEY (`id_import`,`email`,`list`)
            ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_import_deleted() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import_deleted` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                PRIMARY KEY (`id_import`,`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_import_new() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import_new` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                PRIMARY KEY (`id_import`,`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_import_updated() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_import_updated` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                PRIMARY KEY (`id_import`,`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_unsubscribers_return_to_elohim_net() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_unsubscribers_return_to_elohim_net` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                `comment` varchar(50) DEFAULT NULL,
                PRIMARY KEY (`id_import`,`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_email_data() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_email_data` (
                `email` varchar(100) NOT NULL,
                `language` varchar(100) DEFAULT NULL,
                `type` varchar(100) DEFAULT NULL,
                `firstname` varchar(100) DEFAULT NULL,
                `lastname` varchar(100) DEFAULT NULL,
                `nickname` varchar(100) DEFAULT NULL,
                `town` varchar(100) DEFAULT NULL,
                `state` varchar(100) DEFAULT NULL,
                `level` varchar(100) DEFAULT NULL,
                `gender` varchar(100) DEFAULT NULL,
                `transmission` varchar(100) DEFAULT NULL,
                `datestamp` varchar(100) DEFAULT NULL,
                `FollowStatus` varchar(2048) DEFAULT NULL,
                PRIMARY KEY (`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_valid_email() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_email_valid` (
                `id_import` int(11) NOT NULL,
                `email` varchar(100) NOT NULL,
                PRIMARY KEY (`id_import`,`email`)
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_elohimnet_log() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS `elohimnet_log` (
                `id_import` int(11) NOT NULL,
                `comment` varchar(1024) DEFAULT NULL,
                `date_log` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) $charset_collate;";

        dbDelta( $query );
    }

    function create_SP_CompareImport() {
        global $wpdb;

        $query = "
        DROP PROCEDURE IF EXISTS `SP_CompareImport`;
        ";
        $wpdb->query( $query );

        $query = "
        CREATE PROCEDURE `SP_CompareImport` ()  NO SQL
        BEGIN
            DECLARE id_actuel INT;
            DECLARE id_precedent INT;
        
            SELECT MAX(id_import) From elohimnet_import INTO id_actuel;
            SELECT MAX(id_import) - 1 From elohimnet_import INTO id_precedent;
        
            Insert into elohimnet_import_new (id_import, email)
            Select 
                id_actuel as id_import, nouveau.email
            From
            (
                Select 
                    actuel.email
                From 
                    elohimnet_import_email actuel
                    Left Join elohimnet_import_email precedent
                    on precedent.email = actuel.email And precedent.id_import = id_precedent
           
                Where 
                    actuel.id_import = id_actuel
                And precedent.email is null
                And actuel.FollowStatus Not in ('Email bounced','Not interested')
                And actuel.type in ('M','S','R','P','XM','XR','XS')
                ) as nouveau;
        
            Insert into elohimnet_import_deleted (id_import, email)
            Select id_actuel as id_import, deleted.email
            From
            (
                Select 
                    precedent.email
                From 
                    elohimnet_import_email precedent
                    Left Join elohimnet_import_email actuel
                        on actuel.email = precedent.email And actuel.id_import = id_actuel
           
                Where 
                    precedent.id_import = id_precedent
                And actuel.email is null
                And precedent.FollowStatus Not in ('Email bounced','Not interested')
                And precedent.type in ('M','S','R','P','XM','XR','XS')
            ) as deleted;
        
            Insert into elohimnet_import_updated (id_import, email)
                Select 
                    distinct id_actuel as id_import, actuel.email
                From
                    elohimnet_import_email actuel
                    Join elohimnet_import_email precedent
                        on precedent.email = actuel.email
                    Join elohimnet_import_email_list iel
                        on iel.id_import In (id_actuel, id_precedent)
                Where 
                    (  (actuel.firstname <> precedent.firstname)
                    Or (actuel.lastname <> precedent.lastname)
                    Or (actuel.language <> precedent.language)
                    Or (actuel.type <> precedent.type)
                    Or (actuel.nickname <> precedent.nickname)
                    Or (actuel.town <> precedent.town)
                    Or (actuel.state <> precedent.state)
                    Or (actuel.level <> precedent.level)
                    Or (actuel.gender <> precedent.gender)
                    Or (actuel.transmission <> precedent.transmission)
                    Or (actuel.FollowStatus <> precedent.FollowStatus) )
                    And precedent.FollowStatus Not in ('Email bounced','Not interested')
                    And precedent.type in ('M','S','R','P','XM','XR','XS')
                    And actuel.FollowStatus Not in ('Email bounced','Not interested')
                    And actuel.type in ('M','S','R','P','XM','XR','XS')
                    And precedent.id_import = id_precedent
                    And actuel.id_import = id_actuel;
                   
            Delete From elohimnet_import_email_list Where id_import < id_precedent;
            Delete From elohimnet_import_email Where id_import < id_precedent;
        
        END
        ";

        $wpdb->query( $query );
    }

    // ----------------------------------------------------------------------------------------
    // Charger tous les emails valides dans la table elohimnet_import_new
    // > Cette procédure est appelée seulement lors de la première importation. 
    // ----------------------------------------------------------------------------------------
    function create_SP_LoadAllAsNew() {
        global $wpdb;

        $query = "
        DROP PROCEDURE IF EXISTS `SP_LoadAllAsNew`;
        ";
        $wpdb->query( $query );

        $query = "
        CREATE PROCEDURE `SP_LoadAllAsNew` ()  NO SQL
        BEGIN
            DECLARE id_actuel INT;
        
            SELECT MAX(id_import) From elohimnet_import INTO id_actuel;
        
            Insert into elohimnet_import_new (id_import, email)
            Select 
                distinct id_actuel as id_import, ie.email
            From
                elohimnet_import_email ie
                Join elohimnet_import_email_list iel
                  on iel.id_import = ie.id_import
            Where
                ie.FollowStatus Not in ('Email bounced','Not interested')
            And ie.type in ('M','S','R','P','XM','XR','XS')
            And ie.id_import = id_actuel;
        END
        ";

        $wpdb->query( $query );
    }

    // ----------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------
    function create_SP_UpdateImport() {
        global $wpdb;

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
    
        $query = "
        DROP PROCEDURE IF EXISTS `SP_UpdateImport`;
        ";
        $wpdb->query( $query );

        $query = "
        CREATE PROCEDURE `SP_UpdateImport` ()  NO SQL
        BEGIN
            DECLARE id_actuel INT;
            DECLARE n_import INT DEFAULT 0;
            DECLARE n_valid INT DEFAULT 0;
            DECLARE n_new INT DEFAULT 0;
            DECLARE n_deleted INT DEFAULT 0;
            DECLARE n_updated INT DEFAULT 0;
            DECLARE n_bad INT DEFAULT 0;
            DECLARE n_unsub_returned INT DEFAULT 0;
            DECLARE n_unsub_returned_refused INT DEFAULT 0;
            DECLARE n_mailpoet_inactive INT DEFAULT 0;
            DECLARE n_mailpoet_active INT DEFAULT 0;
        
            SELECT MAX(id_import) From elohimnet_import INTO id_actuel;
        
            SELECT count(*) FROM elohimnet_import_email WHERE id_import = id_actuel INTO n_import;
            SELECT count(*) FROM elohimnet_import_new WHERE id_import = id_actuel INTO n_new;
            SELECT count(*) FROM elohimnet_import_deleted WHERE id_import = id_actuel INTO n_deleted;
            SELECT count(*) FROM elohimnet_import_updated WHERE id_import = id_actuel INTO n_updated;

            SELECT count(*) 
            FROM 
                elohimnet_import_email ie
            WHERE 
                ie.id_import = id_actuel 
            AND ie.FollowStatus Not in ('Email bounced','Not interested')
            AND ie.type in ('M','S','R','P','XM','XR','XS')
            AND EXISTS (SELECT * FROM elohimnet_import_email_list iel WHERE iel.id_import = ie.id_import) 
            INTO n_valid;

            SELECT COUNT(*) 
                FROM
                    elohimnet_import_new n
                    JOIN wp_mailpoet_subscribers mp on mp.email = n.email
                    JOIN elohimnet_email_data d on d.email = n.email
                    JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = mp.id                     
            WHERE mp.status Not in ('subscribed', 'inactive')
                AND seg.segment_id in (" . $list . ")
            INTO n_bad;

            SELECT count(distinct email)
            FROM
                elohimnet_unsubscribers_return_to_elohim_net
            WHERE id_import = id_actuel
            INTO n_unsub_returned;

            SELECT count(distinct ret.email)
            FROM 
                elohimnet_unsubscribers_return_to_elohim_net ret 
                JOIN elohimnet_email_valid v on v.email = ret.email
                WHERE ret.id_import <> id_actuel 
            INTO n_unsub_returned_refused;

            UPDATE elohimnet_import
            SET nb_import=n_import, nb_valid=n_valid, nb_new=n_new, nb_deleted=n_deleted, nb_updated=n_updated, nb_bad=n_bad, nb_unsub_returned=n_unsub_returned, nb_unsub_returned_refused=n_unsub_returned_refused
            WHERE id_import = id_actuel;
        END
        ";

        $wpdb->query( $query );
    }

    // ----------------------------------------------------------------------------------------
    // Charger tous les emails valides dans la table elohimnet_valid_email
    // ----------------------------------------------------------------------------------------
    function create_SP_LoadValidEmail() {
        global $wpdb;

        $query = "
        DROP PROCEDURE IF EXISTS `SP_LoadValidEmail`;
        ";

        $wpdb->query( $query );

        $query = "
        CREATE PROCEDURE `SP_LoadValidEmail` ()  NO SQL
        BEGIN
            DECLARE id_actuel INT;
        
            SELECT MAX(id_import) From elohimnet_import INTO id_actuel;
        
            Insert into elohimnet_email_valid ( id_import, email )
            Select 
                distinct id_actuel, ie.email
            From
                elohimnet_import_email ie
                Join elohimnet_import_email_list iel
                  on iel.id_import = ie.id_import
            Where
                ie.FollowStatus Not in ('Email bounced','Not interested')
            And ie.type in ('M','S','R','P','XM','XR','XS');
        END
        ";

        $wpdb->query( $query );
    }

    function create_SP_unsubscribers_to_Elohimnet() {
        global $wpdb;

        $query = "
        DROP PROCEDURE IF EXISTS `SP_unsubscribers_to_Elohimnet`;
        ";

        $wpdb->query( $query );

        $query = "
        CREATE PROCEDURE `SP_unsubscribers_to_Elohimnet` ()  NO SQL
        BEGIN
            DECLARE id_actuel INT;
            
            SELECT MAX(id_import) From elohimnet_import INTO id_actuel;

            INSERT INTO elohimnet_unsubscribers_return_to_elohim_net (id_import, email, comment)
            SELECT distinct m.id_import, s.email, s.status
            FROM 
                wp_mailpoet_subscribers s 
                LEFT JOIN elohimnet_unsubscribers_return_to_elohim_net el
                ON el.email = s.email
                JOIN elohimnet_import_email_list m
                ON m.email = s.email
            WHERE s.status IN ('unsubscribed', 'bounced')
                AND el.email IS NULL
                AND m.id_import = id_actuel
                AND s.updated_at >= '2017-11-01';
        END
        ";

        $wpdb->query( $query );
    }

    // Trigger non actif. Je le garde comme exemple.
    function create_U_elohimnet_import() {
        global $wpdb;

        $query = "
        DROP TRIGGER IF EXISTS `U_elohimnet_import`;
        ";

        $wpdb->query( $query );

        $query = "
        CREATE TRIGGER U_elohimnet_import
            BEFORE UPDATE 
            ON elohimnet_import 
            FOR EACH ROW 
        BEGIN 
            DECLARE n_bad INT DEFAULT 0;
        
            SELECT count(*)
            FROM
                elohimnet_import_new n
                JOIN wp_mailpoet_subscribers mp on mp.email = n.email
                JOIN elohimnet_email_data d on d.email = n.email
                JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = mp.id 
            WHERE mp.status Not in ('subscribed', 'inactive')
            ORDER BY d.email
            INTO n_bad;

            SET NEW.nb_bad = n_bad;
        END
        ";

        $wpdb->query( $query );
    }

    public function create_tables() {
        $this->create_elohimnet_import();
        $this->create_elohimnet_import_email();
        $this->create_elohimnet_import_email_list();
        $this->create_elohimnet_import_deleted();
        $this->create_elohimnet_import_new();
        $this->create_elohimnet_import_updated();
        $this->create_elohimnet_unsubscribers_return_to_elohim_net();
        $this->create_elohimnet_email_data();
        $this->create_elohimnet_valid_email();
        $this->create_elohimnet_log();
    }

    public function create_stored_procedure() {
        $this->create_SP_LoadAllAsNew();
        $this->create_SP_CompareImport();
        $this->create_SP_UpdateImport();
        $this->create_SP_LoadValidEmail();
        $this->create_SP_unsubscribers_to_Elohimnet();
    }

}