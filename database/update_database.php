SELECT * FROM tbl_program where name not like '%PLM%' And is_active = '1' and level_id in (1,2,5);

UPDATE tbl_program
SET name = CONCAT(name, ' (RLM)')
WHERE name NOT LIKE '%PLM%'
  AND is_active = '1'
  AND level_id IN (1,2,5);