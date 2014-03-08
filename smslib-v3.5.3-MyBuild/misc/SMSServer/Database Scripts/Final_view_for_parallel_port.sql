SELECT spcdc.id AS record_number, bld.name AS building_name, flr.name AS floor_name, flt.name AS flat_name, rom.name AS room_name, dvc.name AS device_name, eqpmt.name AS equipment_name1, eqpmt1.name AS equipment_name2, eqpmt2.name AS equipment_name3, eqpmt3.name AS equipment_name4, eqpmt4.name AS equipment_name5, eqpmt5.name AS equipment_name6, eqpmt6.name AS equipment_name7, eqpmt7.name AS equipment_name8
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