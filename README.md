# Open Payments Search
This Laravel app is used to import and through the 2019 Open Paments dataset located here 
https://openpaymentsdata.cms.gov/dataset/General-Payment-Data-Detailed-Dataset-2019-Reporti/p2ve-2ws5

___

## Requirements
- PHP > 7.2
- MySQL (tested with V8.0.21)
- Composer

Note: Development was done on MacOS and has not been tested with Windows or Linux.
___
## Installation
Clone the repository and cd into the root directory to perform the following:

1. Copy the .env file to the project root directory.

2. Create the open_payments_search database  
`php artisan CreateDb:OpenPaymentSearch`

3. Run the migration to create the data_sources, import_history and general_payment_data tables  
`php artisan migrate`

4. Seed the data_sources table  
`php artisan db:seed --class=DataSourcesSeeder`

5. Start the server with  
`php artisan serve`

6. Install the comoser dependencies  
`composer install` 

___

## Initial Data Import

There are several was to import the data set
1. Import with MySQL INFILE command (fastest)
2. Import with Laravel Artisan command
3. Import from Laravel command to make API requests

Because it is large file a local import of the CSV  (#1 and #2) is suggested over API calls.

### **Import Option 1 - Importing with MySQL Infile command (Fastest)**

This option is the the fastest, but slightly more involved because it involves using the MySQL  command line.

First download the CSV. To download the dataset please vist [this link](https://dev.socrata.com/foundry/openpaymentsdata.cms.gov/p2ve-2ws5) and on the right side in the "Download & Export" section click on the "Export dataset as CSV" link.

Next open the MySQL command line in your terminal and connect to the database:  
`use open_payments_search`

Copy and paste the following command to enable INFILE command loading:  
`SET GLOBAL local_infile=1;`

Open the 'initial_data_import.sql' file located in the sql_scripts directory ('sql_scripts/initial_data_import.sql') and update the filepath on the first line to point to the CSV which you downloaded. Copy/paste the command into your MySQL terminal to import the dataset. This may take 20+ minutes due to the size of the dataset.

**IMPORTANT - loading of the dataset must be completed before continuing to the next steps**

 After the dataset is loaded into MySQL (may take 15+ minutes) either close the MySQL terminal or open a new terminal session and cd to the root directory of this repository and enter the following command to add indexes to the database:  
`php artisan UpdateDb:AddIndexes`

Finally, enter the following command to indicate to the app that data has been loaded:  
`php artisan UpdateDb:UpdateImportHistory`

### **Import Option 2 - Importing with Laravel Artisan command**

First download the CSV. To download the dataset please vist [this link](https://dev.socrata.com/foundry/openpaymentsdata.cms.gov/p2ve-2ws5) and on the right side in the "Download & Export" section click on the "Export dataset as CSV" link.

**Note: If you would like to import without specifying a filepath it must be located in the 'storage/import_data' directory and named 'General_Payment_Data___Detailed_Dataset_2019_Reporting_Year.csv'**

To import with specifying a filepath:  
`php artisan Import:FromFile --filepath='/path/to/file.csv'`

To import from the default location:
`php artisan Import:FromFile`

### **Import Option 3 - Importing with API calls** 

API calls can be used to import the entire dataset, but this method is primarily intended to be used for fetching additional data once the initial import is completed as it is the slowest of the 3 data importing methods. To run use this option to import data, enter the followin command

`php artisan Import:FromApi`

___
## Fetching New Data

To fetch new data run the following command from the root directory:  
`php artisan Import:FromApi`

In a production environment this would be set up as a Laravel Scheduled job triggered by a cron. Because the process may be time consuming, in order to access manual updates by users without command line access, a form submission by a user could create a scheduled job with a service such as RabbitMQ worker.