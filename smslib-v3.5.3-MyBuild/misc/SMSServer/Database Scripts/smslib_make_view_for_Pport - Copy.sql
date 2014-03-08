CREATE VIEW course_details AS
             SELECT cp.school_id, cp.syear, cp.marking_period_id, cp.period_id, c.subject_id,
	     cp.course_id, cp.course_period_id, cp.teacher_id, cp.secondary_teacher_id, c.title AS course_title,
	     cp.title AS cp_title, cp.grade_scale_id, cp.mp, cp.credits
             FROM smsserver_parallel_comm_device_configuration spcdc, building bld, floor flr, flat flt,room rom, device dvc, equipment eqpmt WHERE spcdc.building_id = bld.id and spcdc.floor_id = flr.id and spcdc.flat_id = flt.id and spcdc.room_id = rom.id and spcdc.device_id = dvc.id and spcdc.equipment_id = eqpmt.id