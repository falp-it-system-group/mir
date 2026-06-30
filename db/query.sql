-- 172.25.115.167 mis_db

SELECT Machine_Name, 
       SUBSTRING(Machine_Name, CHARINDEX('TRD', Machine_Name), 6) AS Next_3_Chars
FROM t_sys_info 
WHERE IP_Address = '172.25.115.223' 
  AND Machine_Name LIKE '%TRD%';