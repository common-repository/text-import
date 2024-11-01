<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

require_once('../core/functions.php');

$_REQUEST['dir'] = urldecode($_REQUEST['dir']);

//$flag = false;
$level = 0;

function rec($cur_path, $path) {
	
	global $level;
	
	$dir  = array_shift($path);
	//$dir .= '/';
	
	$files = scandir($root . $cur_path);
	//print_r($files);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($root . $cur_path . $file) && $file != '.' && $file != '..' && is_dir($root . $cur_path . $file) ) {
				if($level == 0 && $file != CONTENT_DIR) {
					continue;
				}
				$flag = true;
				$expanded  = 'collapsed';
				$selected = '';
				if($file == $dir) {
					$expaned  = 'expanded';
					if(count($path) <= 1) {
						$selected = ' class="selected"';
					}
				}
				echo "<li class=\"directory " . $expanded . "\"><a href=\"#\"" . $selected . " rel=\"" . htmlentities($root . $cur_path . $file) . "/\">" . htmlentities($file) . "</a>";
				
				if($file == $dir) {
					$level++;
					rec($root . $cur_path . $file . '/', $path);
					$level--;
				}
				echo "</li>";
			}			
		}
		echo "</ul>";	
	}
}

if(isset($_REQUEST['cur_dir'])) {
	$cur_dir = CONTENT_DIR . '/' . urldecode($_REQUEST['cur_dir']);
	
	$path = split('\/', $cur_dir);

	array_shift($path);
	$root = realpath($_REQUEST['dir'] . '/../') . '/';
	
	rec($root, $path);
	
	
	exit;
}

if( file_exists($root . $_REQUEST['dir']) ) {
	$files = scandir($root . $_REQUEST['dir']);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($root . $_REQUEST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_REQUEST['dir'] . $file) ) {
				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_REQUEST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
			}
		}
		// All files
/*		foreach( $files as $file ) {
			if( file_exists($root . $_REQUEST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_REQUEST['dir'] . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_REQUEST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		}*/
		echo "</ul>";	
	}
}

?>