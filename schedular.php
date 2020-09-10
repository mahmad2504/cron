<?php require_once __DIR__.'/vendor/autoload.php';

use GO\Scheduler;
date_default_timezone_set('Asia/Karachi');
// Create a new scheduler
$scheduler = new Scheduler();
//$scheduler->php('D:\xampp\htdocs\test2\index.php')->everyMinute();;
$scheduler->raw('cd c:/xampp/htdocs/resource_planner && php artisan import',[],'RMO')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/support_sla && php artisan sync:database',[],'SUPPORT')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/localshipments && php artisan sync',[],'LOCALSHIPMENTS')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/sos && php artisan sync:calendar',[],'Sprint Calendar')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/sos && php artisan sync:risk',[],'Risk Calendar')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/scriptwallet && php artisan zaahmad:updateepics',[],'IESD Update Epics')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/scriptwallet && php artisan zaahmad:updatesupportmatric',[],'IESD Support')->inForeground()->everyMinute();
$scheduler->raw('cd c:/xampp/htdocs/scriptwallet && php artisan indos:checkaptupdate',[],'INDOS APT Update Check')->inForeground()->everyMinute();

//$scheduler->raw('trello.bat',[],'Trello')->inForeground()->daily('07:00');



// ... configure the scheduled jobs (see below) ...

// Let the scheduler execute jobs which are due.
$i=1;
while(1)
{
	
	echo "\e[104m"."Run #".$i++."\e[0m\r\n";
	$jobs = $scheduler->run();
	foreach($jobs as $job)
	{
		echo "\e[92mJob ".$job->getId()."\e[0m\r\n";
		//echo "Updating ".$job->getId()."\r\n";
		$output = $job->getOutput();
		if($output)
			foreach($output as $message)
				echo $message."\r\n";
		
	}
	echo "Finished\r\n"; 
	
	//$scheduler->clearJobs();
	//var_dump($jobs);
	sleep(60);
}

