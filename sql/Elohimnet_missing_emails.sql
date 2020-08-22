-- #1
-- Nombre de subscribers qui sont associés au segment 18 (EN)
-- TOTAL : 1081
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 18

-- #2
-- Nombre de subscribers qui ont le statut 'subscribed' et qui sont associés au segment 18 (EN)
-- TOTAL : 413
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 18
  And sub.status = 'subscribed'

-- #3
-- Nombre de subscribers qui ont le statut différent de 'subscribed' et qui sont associés au segment 18 (EN)
-- TOTAL : 668
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 18
  And sub.status <> 'subscribed'

-- #4
-- Nombre de subscribers qui sont associés au segment 19 (FR)
-- TOTAL : 1076
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 19

-- #5
-- Nombre de subscribers qui ont le statut 'subscribed' et qui sont associés au segment 19 (FR)
-- TOTAL : 416
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 19
  And sub.status = 'subscribed'

-- #6
-- Nombre de subscribers qui ont le statut différent de 'subscribed' et qui sont associés au segment 19 (FR)
-- TOTAL : 660
Select sub.*
From 
    ca_mailpoet_subscribers sub

    Join ca_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 

Where seg.segment_id = 19
  And sub.status <> 'subscribed'

-- #7
-- Nombre de subscribers réel
-- TOTAL : 2184
Select count(*) from elohimnet_import_new

-- #8
-- Nombre de subscribers réel qui ne sont pas dans Mailpoet (BAD)
-- TOTAL : 1174 
Select sub.email, ca.email
From 
    elohimnet_import_new sub

    Left Join wp_mailpoet_subscribers ca
    on ca.email = sub.email

Where ca.email is NULL

-- #9
-- Nombre de subscribers EN réel qui ne sont pas dans Mailpoet
-- TOTAL : 759
Select d.*
From 
    elohimnet_import_new sub

    Join elohimnet_email_data d 
    on d.email = sub.email

    Left Join ca_mailpoet_subscribers ca
    on ca.email = sub.email

Where ca.email is NULL
  And d.language <> 'fr'

-- #10
-- Nombre de subscribers FR réel qui ne sont pas dans Mailpoet
-- TOTAL : 415
Select d.*
From 
    elohimnet_import_new sub

    Join elohimnet_email_data d 
    on d.email = sub.email

    Left Join ca_mailpoet_subscribers ca
    on ca.email = sub.email

Where ca.email is NULL
  And d.language = 'fr'
  And sub.id_import = 1

-- #11
-- Nombre de unsubscribers retournés à Elohim.net qui sont encore actifs dans Elohim.net
-- TOTAL : 26 
Select distinct  d.*
From 
    elohimnet_unsubscribers_return_to_elohim_net ret 

    Join elohimnet_import_new new 
    on new.email = ret.email

    Join elohimnet_email_data d 
    on d.email = ret.email

-- #12
-- Nombre de unsubscribers retournés à Elohim.net 
-- TOTAL : 
Select distinct  d.*
From 
    elohimnet_unsubscribers_return_to_elohim_net

-- #13
-- Nombre de subscribers qui sont dans les listes Elohim.net de Mailpoet mais
-- qui ne viennent pas de Elohim.net
-- TOTAL : 12
Select count(distinct sub.email)
From 
    wp_mailpoet_subscribers sub
    Join wp_mailpoet_subscriber_segment seg
    on seg.subscriber_id = sub.id 
    Left Join elohimnet_email_data d 
    on d.email = sub.email
Where seg.segment_id in (18,19)
And seg.status = 'subscribed'
And sub.status = 'subscribed'
And d.email is NULL

-- #14
-- Nombre datavalidation
SELECT count(distinct new.email)
FROM
    elohimnet_import_new new
    JOIN wp_mailpoet_subscribers mp
    on mp.email = new.email
WHERE mp.status = 'unconfirmed'
INTO n_bad;

