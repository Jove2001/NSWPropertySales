-- Find total number sales by type of property

SELECT PrimaryPurpose AS [Type of Property],
       COUNT( * ) AS [Total Sales]
  FROM [2020]
 WHERE SettlementDate LIKE "2020%" AND 
       PercentInterestOfSale IS 0
 GROUP BY NatureOfProperty;
