SELECT PropertyLocality AS Suburb,
       COUNT(PropertyLocality) AS [Number of Sales]
  FROM [2022]
 WHERE SettlementDate LIKE "2022%" AND 
       PercentInterestOfSale = 0
 GROUP BY Suburb
 ORDER BY "Number of Sales" DESC;
