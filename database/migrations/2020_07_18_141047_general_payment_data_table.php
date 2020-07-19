<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GeneralPaymentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_payment_data', function (Blueprint $table) {
            $table->id();
            $table->longtext("change_type")->nullable();
            $table->longtext("covered_recipient_type")->nullable();
            $table->longtext("teaching_hospital_ccn")->nullable();
            $table->longtext("teaching_hospital_id")->nullable();
            $table->longtext("teaching_hospital_name")->nullable();
            $table->longtext("physician_profile_id")->nullable();
            $table->longtext("physician_first_name")->nullable();
            $table->longtext("physician_middle_name")->nullable();
            $table->longtext("physician_last_name")->nullable();
            $table->longtext("physician_name_suffix")->nullable();
            $table->longtext("recipient_primary_business_street_address_line1")->nullable();
            $table->longtext("recipient_primary_business_street_address_line2")->nullable();
            $table->longtext("recipient_city")->nullable();
            $table->longtext("recipient_state")->nullable();
            $table->longtext("recipient_zip_code")->nullable();
            $table->longtext("recipient_country")->nullable();
            $table->longtext("recipient_province")->nullable();
            $table->longtext("recipient_postal_code")->nullable();
            $table->longtext("physician_primary_type")->nullable();
            $table->longtext("physician_specialty")->nullable();
            $table->longtext("physician_license_state_code1")->nullable();
            $table->longtext("physician_license_state_code2")->nullable();
            $table->longtext("physician_license_state_code3")->nullable();
            $table->longtext("physician_license_state_code4")->nullable();
            $table->longtext("physician_license_state_code5")->nullable();
            $table->longtext("submitting_applicable_manufacturer_or_applicable_gpo_name")->nullable();
            $table->longtext("applicable_manufacturer_or_applicable_gpo_making_payment_id")->nullable();
            $table->longtext("applicable_manufacturer_or_applicable_gpo_making_payment_name")->nullable();
            $table->longtext("applicable_manufacturer_or_applicable_gpo_making_payment_state")->nullable();
            $table->longtext("applicable_manufacturer_or_applicable_gpo_making_payment_country")->nullable();
            $table->decimal("total_amount_of_payment_usdollars",8,2)->nullable(); // number data type: https://dev.socrata.com/docs/datatypes/number.html#2.1
            $table->datetime("date_of_payment",0)->nullable(); // floating timestamp data type : https://dev.socrata.com/docs/datatypes/floatingtimestamp.html#2.1
            $table->decimal("number_of_payments_included_in_total_amount",8,2)->nullable(); // number data type: https://dev.socrata.com/docs/datatypes/number.html#2.1
            $table->longtext("form_of_payment_or_transfer_of_value")->nullable();
            $table->longtext("nature_of_payment_or_transfer_of_value")->nullable();
            $table->longtext("city_of_travel")->nullable();
            $table->longtext("state_of_travel")->nullable();
            $table->longtext("country_of_travel")->nullable();
            $table->longtext("physician_ownership_indicator")->nullable();
            $table->longtext("third_party_payment_recipient_indicator")->nullable();
            $table->longtext("name_of_third_party_entity_receiving_payment_or_transfer_of_valu")->nullable(); // mysql only allows for 64 characters field names, shortened length to 64 char
            $table->longtext("charity_indicator")->nullable();
            $table->longtext("third_party_equals_covered_recipient_indicator")->nullable();
            $table->longtext("contextual_information")->nullable();
            $table->longtext("delay_in_publication_indicator")->nullable();
            $table->longtext("record_id")->nullable();
            $table->longtext("dispute_status_for_publication")->nullable();
            $table->longtext("related_product_indicator")->nullable();
            $table->longtext("covered_or_noncovered_indicator_1")->nullable();
            $table->longtext("indicate_drug_or_biological_or_device_or_medical_supply_1")->nullable();
            $table->longtext("product_category_or_therapeutic_area_1")->nullable();
            $table->longtext("name_of_drug_or_biological_or_device_or_medical_supply_1")->nullable();
            $table->longtext("associated_drug_or_biological_ndc_1")->nullable();
            $table->longtext("covered_or_noncovered_indicator_2")->nullable();
            $table->longtext("indicate_drug_or_biological_or_device_or_medical_supply_2")->nullable();
            $table->longtext("product_category_or_therapeutic_area_2")->nullable();
            $table->longtext("name_of_drug_or_biological_or_device_or_medical_supply_2")->nullable();
            $table->longtext("associated_drug_or_biological_ndc_2")->nullable();
            $table->longtext("covered_or_noncovered_indicator_3")->nullable();
            $table->longtext("indicate_drug_or_biological_or_device_or_medical_supply_3")->nullable();
            $table->longtext("product_category_or_therapeutic_area_3")->nullable();
            $table->longtext("name_of_drug_or_biological_or_device_or_medical_supply_3")->nullable();
            $table->longtext("associated_drug_or_biological_ndc_3")->nullable();
            $table->longtext("covered_or_noncovered_indicator_4")->nullable();
            $table->longtext("indicate_drug_or_biological_or_device_or_medical_supply_4")->nullable();
            $table->longtext("product_category_or_therapeutic_area_4")->nullable();
            $table->longtext("name_of_drug_or_biological_or_device_or_medical_supply_4")->nullable();
            $table->longtext("associated_drug_or_biological_ndc_4")->nullable();
            $table->longtext("covered_or_noncovered_indicator_5")->nullable();
            $table->longtext("indicate_drug_or_biological_or_device_or_medical_supply_5")->nullable();
            $table->longtext("product_category_or_therapeutic_area_5")->nullable();
            $table->longtext("name_of_drug_or_biological_or_device_or_medical_supply_5")->nullable();
            $table->longtext("associated_drug_or_biological_ndc_5")->nullable();
            $table->integer("program_year")->nullable(); // number data type, but assuming year will be integer
            $table->datetime("payment_publication_date",0)->nullable(); // floating timestamp data type : https://dev.socrata.com/docs/datatypes/floatingtimestamp.html#2.1
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_payment_data');
    }
}
