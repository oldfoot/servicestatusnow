CREATE DEFINER=`servicestatusnow`@`%` PROCEDURE `sp_core_pricing`()
BEGIN
SELECT *
					FROM core_admin_pricing				
					WHERE Category IN ('Free','Professional')
					ORDER BY FIND_IN_SET(TYPE, 'Monthly Payment,Annual Payment,Minimum Subscription,You Save'),
					FIND_IN_SET(Category, 'Free,Professional');
    END