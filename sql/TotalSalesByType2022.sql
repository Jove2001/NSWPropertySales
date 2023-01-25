-- Find total number sales by type of property

SELECT PrimaryPurpose AS [Type of Property],
       COUNT( * ) AS [Total Sales]
  FROM [2022]
 WHERE SettlementDate LIKE "2022%" AND 
       PercentInterestOfSale IS 0
 GROUP BY NatureOfProperty;
