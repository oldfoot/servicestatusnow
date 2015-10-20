CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_mq_count_queue_type`(IN pType VARCHAR(15))
BEGIN
	SELECT count(*) as total FROM mq_master WHERE type = pType AND status = 'new';
    END