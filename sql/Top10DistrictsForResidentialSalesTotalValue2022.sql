-- Find the top 10 districts by residential sales total value in 2022,
-- where the complete interest of the property was sold and settlement occurred in 2022.

SELECT DistrictCodes.District AS [Council district],
       SUM(NSWPropertySales.PurchasePrice) AS [Total sales value]
  FROM NSWPropertySales
       JOIN
       DistrictCodes ON NSWPropertySales.DistrictCode = DistrictCodes.DistrictCode
 WHERE NSWPropertySales.NatureOfProperty IS "R" AND 
       NSWPropertySales.SettlementDate LIKE "2022%" AND 
       NSWPropertySales.PercentInterestOfSale IS "0"
 GROUP BY DistrictCodes.District
 ORDER BY SUM(NSWPropertySales.PurchasePrice) DESC
 LIMIT 10;
