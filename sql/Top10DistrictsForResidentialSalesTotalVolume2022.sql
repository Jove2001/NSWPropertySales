-- Find the top 10 districts by residential sales volume in 2022
-- where the complete interest in the property was sold and settlement occurred in 2022.

SELECT DistrictCodes.District AS [Council district],
       COUNT( * ) AS [Number of residential properties sold]
  FROM NSWPropertySales
       JOIN
       DistrictCodes ON NSWPropertySales.DistrictCode = DistrictCodes.DistrictCode
 WHERE NSWPropertySales.NatureOfProperty IS "R" AND 
       NSWPropertySales.SettlementDate LIKE "2022%"
 GROUP BY DistrictCodes.District
 ORDER BY COUNT( * ) DESC
 LIMIT 10;