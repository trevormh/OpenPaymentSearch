ALTER TABLE general_payment_data
ADD INDEX(physician_first_name),
ADD INDEX(physician_last_name),
ADD INDEX(submitting_applicable_manufacturer_or_applicable_gpo_name),
ADD INDEX(date_of_payment),
ADD INDEX(recipient_state),
ADD INDEX(recipient_city),
ADD INDEX(total_amount_of_payment_usdollars),
ADD INDEX(payment_publication_date);