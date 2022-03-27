SELECT distinct mp.* 
    FROM
        wp_mailpoet_subscribers mp
        JOIN wp_mailpoet_subscriber_segment seg on seg.subscriber_id = mp.id                     
WHERE mp.status IN ('inactive', 'unsubscribed')
    AND seg.segment_id in (18,19)
    AND mp.updated_at >= DATE_ADD(now(), INTERVAL -7 DAY)
