SELECT PropertyLocality AS Suburb,
       COUNT(PropertyLocality) AS [Number of Sales]
  FROM [2021]
 WHERE SettlementDate LIKE "2021%" AND 
       PercentInterestOfSale = 0
 GROUP BY Suburb
 ORDER BY "Number of Sales" DESC;
