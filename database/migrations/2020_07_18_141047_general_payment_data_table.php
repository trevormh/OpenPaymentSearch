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
            $table->longText("Change_Type");
            $table->longText("Covered_Recipient_Type");
            $table->longText("Teaching_Hospital_CCN");
            $table->longText("Teaching_Hospital_ID");
            $table->longText("Teaching_Hospital_Name");
            $table->longText("Physician_Profile_ID");
            $table->longText("Physician_First_Name");
            $table->longText("Physician_Middle_Name");
            $table->longText("Physician_Last_Name");
            $table->longText("Physician_Name_Suffix");
            $table->longText("Recipient_Primary_Business_Street_Address_Line1");
            $table->longText("Recipient_Primary_Business_Street_Address_Line2");
            $table->longText("Recipient_City");
            $table->longText("Recipient_State");
            $table->longText("Recipient_Zip_Code");
            $table->longText("Recipient_Country");
            $table->longText("Recipient_Province");
            $table->longText("Recipient_Postal_Code");
            $table->longText("Physician_Primary_Type");
            $table->longText("Physician_Specialty");
            $table->longText("Physician_License_State_code1");
            $table->longText("Physician_License_State_code2");
            $table->longText("Physician_License_State_code3");
            $table->longText("Physician_License_State_code4");
            $table->longText("Physician_License_State_code5");
            $table->longText("Submitting_Applicable_Manufacturer_or_Applicable_GPO_Name");
            $table->longText("Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_ID");
            $table->longText("Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Name");
            $table->longText("Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_State");
            $table->longText("Applicable_Manufacturer_or_Applicable_GPO_Making_Payment_Country");
            $table->decimal("Total_Amount_of_Payment_USDollars",8,2); // number data type: https://dev.socrata.com/docs/datatypes/number.html#2.1,
            $table->dateTime("Date_of_Payment",0); // floating timestamp data type : https://dev.socrata.com/docs/datatypes/floatingtimestamp.html#2.1,
            $table->decimal("Number_of_Payments_Included_in_Total_Amount",8,2); // number data type: https://dev.socrata.com/docs/datatypes/number.html#2.1,
            $table->longText("Form_of_Payment_or_Transfer_of_Value");
            $table->longText("Nature_of_Payment_or_Transfer_of_Value");
            $table->longText("City_of_Travel");
            $table->longText("State_of_Travel");
            $table->longText("Country_of_Travel");
            $table->longText("Physician_Ownership_Indicator");
            $table->longText("Third_Party_Payment_Recipient_Indicator");
            $table->longText("Name_of_Third_Party_Entity_Receiving_Payment_or_Transfer_of_Valu"); // MySQL only allows for 64 characters field names, shortened length to 64 chars
            $table->longText("Charity_Indicator");
            $table->longText("Third_Party_Equals_Covered_Recipient_Indicator");
            $table->longText("Contextual_Information");
            $table->longText("Delay_in_Publication_Indicator");
            $table->longText("Record_ID");
            $table->longText("Dispute_Status_for_Publication");
            $table->longText("Related_Product_Indicator");
            $table->longText("Covered_or_Noncovered_Indicator_1");
            $table->longText("Indicate_Drug_or_Biological_or_Device_or_Medical_Supply_1");
            $table->longText("Product_Category_or_Therapeutic_Area_1");
            $table->longText("Name_of_Drug_or_Biological_or_Device_or_Medical_Supply_1");
            $table->longText("Associated_Drug_or_Biological_NDC_1");
            $table->longText("Covered_or_Noncovered_Indicator_2");
            $table->longText("Indicate_Drug_or_Biological_or_Device_or_Medical_Supply_2");
            $table->longText("Product_Category_or_Therapeutic_Area_2");
            $table->longText("Name_of_Drug_or_Biological_or_Device_or_Medical_Supply_2");
            $table->longText("Associated_Drug_or_Biological_NDC_2");
            $table->longText("Covered_or_Noncovered_Indicator_3");
            $table->longText("Indicate_Drug_or_Biological_or_Device_or_Medical_Supply_3");
            $table->longText("Product_Category_or_Therapeutic_Area_3");
            $table->longText("Name_of_Drug_or_Biological_or_Device_or_Medical_Supply_3");
            $table->longText("Associated_Drug_or_Biological_NDC_3");
            $table->longText("Covered_or_Noncovered_Indicator_4");
            $table->longText("Indicate_Drug_or_Biological_or_Device_or_Medical_Supply_4");
            $table->longText("Product_Category_or_Therapeutic_Area_4");
            $table->longText("Name_of_Drug_or_Biological_or_Device_or_Medical_Supply_4");
            $table->longText("Associated_Drug_or_Biological_NDC_4");
            $table->longText("Covered_or_Noncovered_Indicator_5");
            $table->longText("Indicate_Drug_or_Biological_or_Device_or_Medical_Supply_5");
            $table->longText("Product_Category_or_Therapeutic_Area_5");
            $table->longText("Name_of_Drug_or_Biological_or_Device_or_Medical_Supply_5");
            $table->longText("Associated_Drug_or_Biological_NDC_5");
            $table->integer("Program_Year"); // number data type, but assuming year will be integer
            $table->dateTime("Payment_Publication_Date",0); // floating timestamp data type : https://dev.socrata.com/docs/datatypes/floatingtimestamp.html#2.1,
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
