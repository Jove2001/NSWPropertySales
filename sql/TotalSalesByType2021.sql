-- Find total number sales by type of property

SELECT PrimaryPurpose AS [Type of Property],
       COUNT( * ) AS [Total Sales]
  FROM [2021]
 WHERE SettlementDate LIKE "2021%" AND 
       PercentInterestOfSale IS 0
 GROUP BY NatureOfProperty;
