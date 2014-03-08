 
SELECT spcdc.id AS record_number,spcdc.building_id as building_id, bld.name AS building_name, spcdc.floor_id as floor_id,flr.name AS floor_name,spcdc.flat_id as flat_id, flt.name AS flat_name, spcdc.room_id as room_id,rom.name AS room_name,spcdc.device_id as device_id, dvc.name AS device_name, spcdc.equipment1_id as equipment1_id,eqpmt.name AS equipment_name1,spcdc.equipment2_id as equipment2_id, eqpmt1.name AS equipment_name2, spcdc.equipment3_id as equipment3_id, eqpmt2.name AS equipment_name3, spcdc.equipment4_id as equipment4_id, eqpmt3.name AS equipment_name4, spcdc.equipment5_id as equipment5_id, eqpmt4.name AS equipment_name5, spcdc.equipment6_id as equipment6_id, eqpmt5.name AS equipment_name6, spcdc.equipment7_id as equipment7_id, eqpmt6.name AS equipment_name7, spcdc.equipment8_id as equipment8_id, eqpmt7.name AS equipment_name8
FROM parallel_comm_device_configuration spcdc, building bld, floor flr, flat flt, room rom, device dvc, equipment eqpmt, equipment eqpmt1, equipment eqpmt2, equipment eqpmt3, equipment eqpmt4, equipment eqpmt5, equipment eqpmt6, equipment eqpmt7
WHERE spcdc.building_id = bld.id
AND spcdc.floor_id = flr.id
AND spcdc.flat_id = flt.id
AND spcdc.room_id = rom.id
AND spcdc.device_id = dvc.id
AND spcdc.equipment1_id = eqpmt.id
AND spcdc.equipment2_id = eqpmt1.id
AND spcdc.equipment3_id = eqpmt2.id
AND spcdc.equipment4_id = eqpmt3.id
AND spcdc.equipment5_id = eqpmt4.id
AND spcdc.equipment6_id = eqpmt5.id
AND spcdc.equipment7_id = eqpmt6.id
AND spcdc.equipment8_id = eqpmt7.id