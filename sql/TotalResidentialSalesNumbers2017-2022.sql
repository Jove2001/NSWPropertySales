SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*) AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2017%"
UNION
SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*)  AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2018%"
UNION
SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*) AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2019%"
UNION
SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*) AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2020%"
UNION
SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*) AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2021%"
UNION
SELECT substr(SettlementDate, 0, 5) AS Year,
       COUNT(*) AS [Total number of residential sales]
  FROM NSWPropertySales
 WHERE NatureOfProperty = "R" AND 
       PercentInterestOfSale = 0 AND 
       SettlementDate LIKE "2022%";
