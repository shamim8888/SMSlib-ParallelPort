CREATE VIEW parallel_port_view1 AS
             SELECT spcdc.id as record_number, bld.name as building_name, flr.name as floor_name, flt.name as flat_name, rom.name as room_name,dvc.name as lpt_comm_device_name, eqpmt.name as equipment_name1, eqpmt.name as equipment_name2, eqpmt.name as equipment_name3, eqpmt.name as equipment_name4, eqpmt.name as equipment_name5, eqpmt.name as equipment_name6, eqpmt.name as equipment_name7, eqpmt.name as equipment_name8
	  
             FROM smsserver_parallel_comm_device_configuration spcdc
INNER JOIN building bld ON bld.id = spcdc.building_id
INNER JOIN  floor flr ON flr.id = spcdc.floor_id 
INNER JOIN flat flt ON flt.id = spcdc.flat_id 
INNER JOIN room rom ON rom.id = spcdc.room_id 
INNER JOIN device dvc ON dvc.id = spcdc.lpt_comm_device_id 
INNER JOIN equipment eqpmt ON eqpmt.id = spcdc.equipment1_id  AND eqpmt.id = spcdc.equipment2_id AND eqpmt.id = spcdc.equipment3_id AND eqpmt.id  = spcdc.equipment4_id AND eqpmt.id = spcdc.equipment5_id AND eqpmt.id = spcdc.equipment6_id AND eqpmt.id = spcdc.equipment7_id AND  eqpmt.id = spcdc.equipment8_id 