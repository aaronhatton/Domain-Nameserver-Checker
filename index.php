<?php

	ini_set('max_execution_time',90000); //300 seconds = 5 minutes
	error_reporting(0);
	
	$domainlist_file = file_get_contents("domains.csv");
	
	foreach (explode("\r",$domainlist_file) as $csv_row) {
		
		$csv_row = str_getcsv($csv_row);
		
		$domain = $csv_row[0];
		$company = $csv_row[1];
		
		$domain = preg_replace('/\s+/','',$domain);
			
		if (dns_get_record ($domain,DNS_NS) == false) {
			
			echo($domain . ",Domain Error," . $company . "<br />");
			
		} else {
			
			$dns_check = dns_get_record ($domain,DNS_NS);
			
		}
		
		foreach ($dns_check as $dns_check) {
					
			echo $dns_check["host"];
			
			if ($dns_check["target"] == "old.server.com") {
				
				echo ",To Be Transferred";
				echo "," . $company . "<br />";
				
			} elseif ($dns_check["target"] == "new.server.com") {
				
				echo ",Transferred";
				echo "," . $company . "<br />";
				
			} else {
				
				echo ",Investigate";
				echo "," . $company . ",";
				echo $dns_check["target"] . "<br />";
				
			}
						
		}
	}
?>