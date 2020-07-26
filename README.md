# Open Payments Search
This Laravel app is used to import and search through the 2019 Open Paments dataset located here 
https://openpaymentsdata.cms.gov/dataset/General-Payment-Data-Detailed-Dataset-2019-Reporti/p2ve-2ws5

___

# Requirements
- PHP > 7.2.5
- MySQL (tested with V8.0.21)
- Composer

Note: This was tested with the php.ini memory_limit set to 1024M. Although Laravel specifies a minimum PHP version of 7.2.5, PHP version 7.4.8 was used to create this application. Development was done on MacOS and has not been tested with Windows or Linux.
___

# Installation and Use
Clone the repository and cd into the root directory to perform the following:

1. Copy the .env file to the project root directory.

2. Install the composer dependencies  
`composer install` 

3. Create the open_payments_search database (SQL also located in /sql/create_db.sql)  
`php artisan CreateDb:OpenPaymentSearch`

4. Run the migration to create the database tables   
`php artisan migrate`

5. Seed the data_sources table  
`php artisan db:seed --class=DataSourcesSeeder`

6. Start the laravel server:  
`php artisan serve`

7. Proceed to Initial Data Import section below. The 1st option is the fastest and recommended for importing the dataset

Note: To ensure fast searching it's important that the DB is indexed with the `php artisan UpdateDb:AddIndexes` command. It is recommended to run this command after the initial dataset import because indexing will likely slow down the import, but you can run it prior to the import if you choose.

___

# Initial Dataset Import

There are several was to import the data set
1. Import csv with MySQL INFILE command (recommended)
2. Import csv with Laravel Artisan command
3. Import from Laravel command to make API requests

A local import of the CSV (#1 and #2) is suggested over API calls for the initial dataset import. API calls are intended for fetching additional data after the dataset has been loaded.

## **Import Option 1 - Importing csv with MySQL Infile command (fastest)**

First download the CSV. To download the dataset please vist [this link](https://dev.socrata.com/foundry/openpaymentsdata.cms.gov/p2ve-2ws5) and on the right side in the "Download & Export" section click on the "Export dataset as CSV" link.

Next open the MySQL command line in your terminal and connect to the database that was created in the installation section:  
`use open_payments_search`

Copy and paste the following command to enable INFILE command loading:  
`SET GLOBAL local_infile=1;`

Next, open the file located at 'sql_files/initial_data_import.sql'. Copy/paste to a text editor and change the filepath to where your csv is downloaded. Copy/paste the command into your MySQL terminal to import the dataset. This may take 20+ minutes.

**IMPORTANT - loading of the dataset must be completed before continuing to the next steps**

Navigate back to the project root directory and enter the following command to add indexes to the database. This may take a few minutes:  
`php artisan UpdateDb:AddIndexes`

Finally, enter the following command to indicate to the app that data has been loaded:  
`php artisan UpdateDb:UpdateImportHistory`

## **Import Option 2 - Importing csv with Laravel Artisan command**

First download the CSV. To download the dataset please vist [this link](https://dev.socrata.com/foundry/openpaymentsdata.cms.gov/p2ve-2ws5) and on the right side in the "Download & Export" section click on the "Export dataset as CSV" link. The application checks the storage/import_data directory for the csv with the default filename of 'General_Payment_Data___Detailed_Dataset_2019_Reporting_Year.csv', but you can specify a filepath too.

To import the csv by specifying a filepath:  
`php artisan Import:FromFile --filepath='/path/to/file.csv'`

To import the csv from the default location (storage/import_data):  
`php artisan Import:FromFile`

Finally, add the DB indexes with the following command. This may take a few minutes:  
`php artisan UpdateDb:AddIndexes`

## **Import Option 3 - Importing with API calls** 

This method is only recommended to fetch additional data once an initial import has been completed due to the speed of it and rate limiting of the API, however it can be used to import the entire dataset.

To use this option enter the following command:  
`php artisan Import:FromApi`

Finally, add the DB indexes with the following command. This may take a few minutes:  
`php artisan UpdateDb:AddIndexes`

___
# Fetching New Data

To fetch new data run the following command from the root directory:  
`php artisan Import:FromApi`

Because the process may be time consuming, in a production environment if a user wishes to manually check for updates this command could be called by a Laravel Scheduled job or by another queue/worker service such as RabbitMQ.