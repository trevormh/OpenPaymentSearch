LOAD DATA LOCAL INFILE '/Users/Trevor/software_dev/vagrant/OpenPaymentsSearch/storage/import_data/General_Payment_Data___Detailed_Dataset_2019_Reporting_Year.csv'
INTO TABLE general_payment_data
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
IGNORE 1 LINES
(change_type,covered_recipient_type,teaching_hospital_ccn,teaching_hospital_id,teaching_hospital_name,physician_profile_id,physician_first_name,physician_middle_name,physician_last_name,physician_name_suffix,recipient_primary_business_street_address_line1,recipient_primary_business_street_address_line2,recipient_city,recipient_state,recipient_zip_code,recipient_country,recipient_province,recipient_postal_code,physician_primary_type,physician_specialty,physician_license_state_code1,physician_license_state_code2,physician_license_state_code3,physician_license_state_code4,physician_license_state_code5,submitting_applicable_manufacturer_or_applicable_gpo_name,applicable_manufacturer_or_applicable_gpo_making_payment_id,applicable_manufacturer_or_applicable_gpo_making_payment_name,applicable_manufacturer_or_applicable_gpo_making_payment_state,applicable_manufacturer_or_applicable_gpo_making_payment_country,total_amount_of_payment_usdollars,date_of_payment,number_of_payments_included_in_total_amount,form_of_payment_or_transfer_of_value,nature_of_payment_or_transfer_of_value,city_of_travel,state_of_travel,country_of_travel,physician_ownership_indicator,third_party_payment_recipient_indicator,name_of_third_party_entity_receiving_payment_or_transfer_of_valu,charity_indicator,third_party_equals_covered_recipient_indicator,contextual_information,delay_in_publication_indicator,record_id,dispute_status_for_publication,related_product_indicator,covered_or_noncovered_indicator_1,indicate_drug_or_biological_or_device_or_medical_supply_1,product_category_or_therapeutic_area_1,name_of_drug_or_biological_or_device_or_medical_supply_1,associated_drug_or_biological_ndc_1,covered_or_noncovered_indicator_2,indicate_drug_or_biological_or_device_or_medical_supply_2,product_category_or_therapeutic_area_2,name_of_drug_or_biological_or_device_or_medical_supply_2,associated_drug_or_biological_ndc_2,covered_or_noncovered_indicator_3,indicate_drug_or_biological_or_device_or_medical_supply_3,product_category_or_therapeutic_area_3,name_of_drug_or_biological_or_device_or_medical_supply_3,associated_drug_or_biological_ndc_3,covered_or_noncovered_indicator_4,indicate_drug_or_biological_or_device_or_medical_supply_4,product_category_or_therapeutic_area_4,name_of_drug_or_biological_or_device_or_medical_supply_4,associated_drug_or_biological_ndc_4,covered_or_noncovered_indicator_5,indicate_drug_or_biological_or_device_or_medical_supply_5,product_category_or_therapeutic_area_5,name_of_drug_or_biological_or_device_or_medical_supply_5,associated_drug_or_biological_ndc_5,program_year,payment_publication_date,@dummy,@dummy);