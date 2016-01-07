<?php
	/**
	 * This php file serves to update a local git repo that is acting as the 
	 * production copy of a Web site. It is set up to fire whenever someone
	 * pushes changes to the master branch of the repository. 
	 * The file checks that it is called from github as a webhook post pull
	 * It also assumes the directory in which this file resides contains a 
	 * git repository cloned from the corresponding github repo.
	 * (C) 2015 Jonathon E. Cihlar
	 */

		// examine the payload - if there is one proceed
	if ($_REQUEST['payload']) {
		
            // decode the payload
        $payload = json_decode ($_REQUEST['payload'], true);
        
        echo "Pulling repository named: ".$payload['repository']['full_name']."\n";
        echo "Triggered by user: ".$payload['sender']['login']."\n";
	echo "Running git fetch origin.\n";
	echo "Results:\n";
	echo shell_exec('git fetch --all');
	
		// when deploying use the git reset --hard origin/master command
        echo "Running git reset --hard origin/master\n";
        echo "Results:\n";
        echo shell_exec('git reset --hard origin/master');
		// change permissions
	echo "Changing permissions on repo files to 0775: ".shell_exec('chmod -R 0775 *')."\n";
		/** IMPORTANT: change the group in this line **/
	echo "Changing group on repo files to www-data:senncodingclub".shell_exec('chown -R www-data:senncodingclub *')."\n";
    }
	else {
		echo "No payload was provided. No action taken.\n";	
	}
?>