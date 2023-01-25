SELECT PropertyLocality AS Suburb,
       COUNT(PropertyLocality) AS [Number of Sales]
  FROM [2020]
 WHERE SettlementDate LIKE "2020%" AND 
       PercentInterestOfSale = 0
 GROUP BY Suburb
 ORDER BY "Number of Sales" DESC;
