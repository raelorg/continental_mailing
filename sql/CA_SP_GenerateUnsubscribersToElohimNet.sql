BEGIN

    Drop Table If EXISTS Unsubscribers_to_export;
    Create Table Unsubscribers_to_export
    SELECT distinct s.email, s.updated_at, s.status
    FROM wp_mailpoet_subscribers s 
    LEFT JOIN unsubscribers_return_to_elohim_net el
      ON el.email = s.email
    JOIN import_email_list m
      ON m.email = s.email
    WHERE s.status IN ('unsubscribed', 'bounced')
      AND el.email IS NULL
      AND s.updated_at >= '2017-11-01';
      
    SELECT s.email, s.updated_at, s.status
    FROM Unsubscribers_to_export s
    INTO OUTFILE 'C:/Users/louke/OneDrive/Mailing/CSV/CA-Unsubscribers.csv' 
    FIELDS ENCLOSED BY '"' 
    TERMINATED BY ';' 
    ESCAPED BY '"' 
    LINES TERMINATED BY '
';     

    INSERT INTO unsubscribers_return_to_elohim_net (email, comment)
    SELECT distinct s.email, s.status
    FROM wp_mailpoet_subscribers s 
    LEFT JOIN unsubscribers_return_to_elohim_net el
      ON el.email = s.email
    JOIN import_email_list m
      ON m.email = s.email
    WHERE s.status IN ('unsubscribed', 'bounced')
      AND el.email IS NULL
      AND s.updated_at >= '2017-11-01';

END