<?
	//set your js and css paths
	$jspath = '/var/www/vhosts/yourdomain.com/httpdocs/yourjsfolder/js/';
	$csspath = '/var/www/vhosts/yourdomain.com/httpdocs/yourcssfolder/css/';
	
	$minJSFileName = 'production.min.js';
	$minCSSFileName = 'production.min.css';
	
	unlink($jspath.$minJSFileName);
	unlink($csspath.$minCSSFileName);

	
	//make concatinated javascript file
	//make the produciton.js file
	$jsFileName = "allthe.js";
	$jsFileHandle = fopen($jsFileName, 'w') or die("can't open file");
	
	
	//iterate through all js folders
	if ($handle = opendir($jspath)) {
			echo "Reading .js files:\n";
			/* This is the correct way to loop over the directory. */
			while (false !== ($filename = readdir($handle))) {
				//if its a js file open it
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if ($ext == 'js') {
					echo "$filename\n";
					//open the file
					$fh = fopen($jspath.$filename, 'r') or die("Can't open file");
					//append contents to the allthe.js
					$theData = fread($fh, filesize($jspath.$filename));
					fwrite($jsFileHandle,$theData);
					fclose($fh);
				}
			}
			closedir($handle);
		}	
	fclose($jsFileHandle);
	//compress it 
	exec('java -jar yuicompressor-2.4.7.jar --type js allthe.js -o '.$jspath.$minJSFileName );
	
	//delete concatenated file
	unlink($jsFileName);
	
	
	//concate all the css files--------------------------------------------------------------------------------
	//make the produciton.js file
	$cssFileName = "allthe.css";
	$cssFileHandle = fopen($cssFileName, 'w') or die("can't open file");
	
	
	//iterate through all js folders
	if ($handle = opendir($csspath)) {
			echo "Reading .css files:\n";
			/* This is the correct way to loop over the directory. */
			while (false !== ($filename = readdir($handle))) {
				//if its a js file open it
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if ($ext == 'css') {
					echo "$filename\n";
					//open the file
					$fh = fopen($csspath.$filename, 'r') or die("Can't open file");
					//append contents to the allthe.js
					$theData = fread($fh, filesize($csspath.$filename));
					fwrite($cssFileHandle,$theData);
					fclose($fh);
				}
			}
			closedir($handle);
		}	
	fclose($cssFileHandle);
	//compress it 
	exec('java -jar yuicompressor-2.4.7.jar --type css allthe.css -o '.$csspath.$minCSSFileName );
	
	//delete concatenated file
	unlink($cssFileName);


?>