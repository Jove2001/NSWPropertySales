# NSWPropertySales
<p>This program adds NSW property sales data for 2017-2022 to an SQLite3 database (NSWSalesData.db), and creates CSV datasets from the included SQL scripts.</p>
<p>Data downloaded from Valuer General NSW Valuation Portal: https://valuation.property.nsw.gov.au/embed/propertySalesInformation</p>

<p><b>WARNING: This operation may 1-2 hrs to complete depending on the speed of your drive</b></p>
<p>1. Needs PHP installed</p>
<p>2. Needs SQLite3 and PDO driver enabled
<p>3. Run on a fast SSD drive for best performance</p>
<p>4. Create the database file with <code>php createdb.php</code></p>
<p>5. Run the SQL scripts and create the CSV datasets with <code>php createdataset.php</code></p>

<p>This software is the original academic work of Ian McEwaine s3863018@student.rmit.edu.au<br>
It has been prepared as market research material for COSC2454 Professional Computing Practice, RMIT University</p>
<p>@ Ian McElwaine 2023</p>
