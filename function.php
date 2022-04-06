<?php
/*
Name: SQL2Migration
Author: Muhammad Hassan
URL: https://pk.linkedin.com/in/exeideas
Version: 1.0
Copyright: (c) 2022 Muhammad Hassan
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


/*
<div class="alert alert-primary d-flex align-items-center my-3" role="alert">
	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
		<use xlink:href="#info-fill"/>
	</svg>
	<div>
		An example alert with an icon
	</div>
</div>
<div class="alert alert-success d-flex align-items-center my-3" role="alert">
	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
		<use xlink:href="#check-circle-fill"/>
	</svg>
	<div>
		An example success alert with an icon
	</div>
</div>
<div class="alert alert-warning d-flex align-items-center my-3" role="alert">
	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
		<use xlink:href="#exclamation-triangle-fill"/>
	</svg>
	<div>
		An example warning alert with an icon
	</div>
</div>
<div class="alert alert-danger d-flex align-items-center my-3" role="alert">
	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
		<use xlink:href="#x-circle-fill"/>
	</svg>
	<div>
		An example danger alert with an icon
	</div>
</div>
*/

/**************************************************
// Function: GenerateMigration 
**************************************************/
if($_POST["Function"] == "GenerateMigration" ){
	// Check File Size Max 25MB
	if ($_FILES["sqlFile"]["size"] >= 26214400) {
		echo '<div class="alert alert-danger d-flex align-items-center my-3" role="alert">
			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
				<use xlink:href="#x-circle-fill"/>
			</svg>
			<div>
				Sorry, Your File Is Greater Than 25MB Limit.
			</div>
		</div>';
		die();
		exit();
	}
	
	// Allow Certain File Formats
	$getFileNameArray = explode('.', $_FILES["sqlFile"]["name"]);
	$file_extension = end($getFileNameArray);
	if($file_extension != "sql") {
		echo '<div class="alert alert-danger d-flex align-items-center my-3" role="alert">
			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
				<use xlink:href="#x-circle-fill"/>
			</svg>
			<div>
				Sorry, Only SQL File Is Allowed.
			</div>
		</div>';
		die();
		exit();
	}
	
	/*
	**	START: Main Converter Code
	*/
	
	// Get SQL File Content In Variable
	$fileContent = file_get_contents($_FILES["sqlFile"]['tmp_name']);
	// Remove All Text Before The First Occurance Of "CREATE TABLE"
	$fileContent = substr($fileContent,strpos($fileContent,"CREATE TABLE"));
	//print_r($fileContent);
	
	// Get SQL File Content Line By Line In An Array
	$sqlFileArray = file($_FILES["sqlFile"]['tmp_name']);
	array_splice($sqlFileArray, 0, getFirstIndexOfArray_Prefix($sqlFileArray, "CREATE TABLE"));	// Remove All Arrays Before The First Occurance Of "CREATE TABLE" In Element Value
	array_splice($sqlFileArray, getLastIndexOfArray_Prefix($sqlFileArray, ") ENGINE=")+1);	// Remove All Arrays After The Last Occurance Of ") ENGINE=" In Element Value

	// Loop Over Number Of Tables TO Make Table Wise Nested Array
	$temp_sqlFileArray = $sqlFileArray;
	$noOfTables = getCountIndexOfArray_Prefix($sqlFileArray, "CREATE TABLE");
	$allTables = array();
	for ($i = 0; $i < $noOfTables; $i++) {
		// Get The Length(No Of Array Index) Of Current Table
		$currentTableIndexCount = getFirstIndexOfArray_Prefix($temp_sqlFileArray, ") ENGINE=") + 1 - getFirstIndexOfArray_Prefix($temp_sqlFileArray, "CREATE TABLE");
		// Get First Table From Full Array Only Without Changing Original Array (array_slice)
		$singleTableArray = array_slice($temp_sqlFileArray, getFirstIndexOfArray_Prefix($temp_sqlFileArray, "CREATE TABLE"), $currentTableIndexCount);
		array_push($allTables, $singleTableArray);	// Add Current Table Array In All Table Array
		// Remove Current Extracted Table From Full Array With Changing Original Array (array_splice)
		array_splice($temp_sqlFileArray, getFirstIndexOfArray_Prefix($temp_sqlFileArray, "CREATE TABLE"), $currentTableIndexCount);
	}

	// Empty The Output Folder
	$files = glob('migrations/*'); // Get all file names
	foreach($files as $file){ // Iterate files
		if(is_file($file)) {
			unlink($file); // Delete file
		}
	}
	// Empty The Output Folder
	
	// https://www.w3schools.com/mysql/mysql_datatypes.asp
	$sqlDatatypes = array("char","varchar","binary","varbinary","tinyblob","tinytext","text","blob","mediumtext","mediumblob","longtext","longblob","enum","set","bit","tinyint","bool","boolean","smallint","mediumint","int","integer","bigint","float","float","double","decimal","dec","date","datetime","timestamp","time","year");
	
	/*
	** Create And Write All Database Table Migrations
	*/
	$i = 1;
	foreach ($allTables as $singleTableArray) {
		// Loop Over All Array One By One
		$singleTableArray[0];
		$finalContentToWrite = "";
		$tableName = strtok(substr($singleTableArray[0],strpos($singleTableArray[0],"`")+1),"`");	// Get String Between `` Characters
		//echo $tableName."<br/>";
		array_shift($singleTableArray);
		array_pop($singleTableArray);
		$finalContentToWrite = '<?php
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class '.makeClassName($tableName).''.$i.' extends Migration {
	
		/**
		* Run the migrations.
		*
		* @return void
		*/
		public function up()
		{
			Schema::create("'.$tableName.'", function(Blueprint $table)
			{
				';
			$j = 1;
			foreach ($singleTableArray as $singleTableLine) {
				// Remove Start/End Spaces
				$singleTableLine = trim($singleTableLine);
				// Check If Current Line Is PRIMARY KEY
				if(strpos($singleTableLine, "PRIMARY KEY") !== false){
					$PK = true;
					break;
				} else {
					// Get The Column Name Of The Row
					$columnName = strtok(substr($singleTableLine,strpos($singleTableLine,"`")+1),"`");	// Get String Between `` Characters
					$singleTableLine = substr($singleTableLine,strlen($columnName)+2,strlen($singleTableLine));	// Remove Table Name With Inverted Commas
					// Get The Column Size Of The Row
					$columnSize = strtok(substr($singleTableLine,strpos($singleTableLine,"(")+1),")");	// Get String Between `` Characters
					if(is_numeric($columnSize[0])) {
						$columnSize = ',"'.$columnSize.'"';	//$table->string('status', '255');
					} else if (startsWith($columnSize,"'")) {
						$columnSize = ',['.$columnSize.']';	//$table->enum('status', ['Pending', 'Wait', 'Active']);
					} else {
						$columnSize = '';
					} 
					// Get The Old And New DataType Of The Row
					if(strpos($singleTableLine, " char") !== false){
						$mySQLDataType = "char";
						$currentDataType = "char";
					} else if(strpos($singleTableLine, " varchar") !== false){
						$mySQLDataType = "varchar";
						$currentDataType = "string";
					} else if(strpos($singleTableLine, " binary") !== false){
						$mySQLDataType = "binary";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " varbinary") !== false){
						$mySQLDataType = "varbinary";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " tinyblob") !== false){
						$mySQLDataType = "tinyblob";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " tinytext") !== false){
						$mySQLDataType = "tinytext";
						$currentDataType = "string";
					} else if(strpos($singleTableLine, " text") !== false){
						$mySQLDataType = "text";
						$currentDataType = "text";
					} else if(strpos($singleTableLine, " blob") !== false){
						$mySQLDataType = "blob";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " mediumtext") !== false){
						$mySQLDataType = "mediumtext";
						$currentDataType = "mediumText";
					} else if(strpos($singleTableLine, " mediumblob") !== false){
						$mySQLDataType = "mediumblob";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " longtext") !== false){
						$mySQLDataType = "longtext";
						$currentDataType = "longText";
					} else if(strpos($singleTableLine, " longblob") !== false){
						$mySQLDataType = "longblob";
						$currentDataType = "binary";
					} else if(strpos($singleTableLine, " enum") !== false){
						$mySQLDataType = "enum";
						$currentDataType = "enum";
					} else if(strpos($singleTableLine, " set") !== false){
						$mySQLDataType = "set";
						$currentDataType = "set";
					} else if(strpos($singleTableLine, " bit") !== false){
						$mySQLDataType = "bit";
						$currentDataType = "boolean";
					} else if(strpos($singleTableLine, " tinyint") !== false){
						$mySQLDataType = "tinyint";
						$currentDataType = "tinyInteger";
					} else if(strpos($singleTableLine, " bool") !== false){
						$mySQLDataType = "bool";
						$currentDataType = "boolean";
					} else if(strpos($singleTableLine, " boolean") !== false){
						$mySQLDataType = "boolean";
						$currentDataType = "boolean";
					} else if(strpos($singleTableLine, " smallint") !== false){
						$mySQLDataType = "smallint";
						$currentDataType = "smallInteger";
					} else if(strpos($singleTableLine, " mediumint") !== false){
						$mySQLDataType = "mediumint";
						$currentDataType = "mediumInteger";
					} else if(strpos($singleTableLine, " int") !== false){
						$mySQLDataType = "int";
						$currentDataType = "integer";
					} else if(strpos($singleTableLine, " integer") !== false){
						$mySQLDataType = "integer";
						$currentDataType = "integer";
					} else if(strpos($singleTableLine, " bigint") !== false){
						$mySQLDataType = "bigint";
						$currentDataType = "bigInteger";
					} else if(strpos($singleTableLine, " float") !== false){
						$mySQLDataType = "float";
						$currentDataType = "double";
					} else if(strpos($singleTableLine, " double") !== false){
						$mySQLDataType = "double";
						$currentDataType = "double";
					} else if(strpos($singleTableLine, " decimal") !== false){
						$mySQLDataType = "decimal";
						$currentDataType = "decimal";
					} else if(strpos($singleTableLine, " dec") !== false){
						$mySQLDataType = "dec";
						$currentDataType = "decimal";
					} else if(strpos($singleTableLine, " date") !== false){
						$mySQLDataType = "date";
						$currentDataType = "date";
					} else if(strpos($singleTableLine, " datetime") !== false){
						$mySQLDataType = "datetime";
						$currentDataType = "dateTime";
					} else if(strpos($singleTableLine, " timestamp") !== false){
						$mySQLDataType = "timestamp";
						$currentDataType = "timestamp";
					} else if(strpos($singleTableLine, " time") !== false){
						$mySQLDataType = "time";
						$currentDataType = "time";
					} else if(strpos($singleTableLine, " year") !== false){
						$mySQLDataType = "year";
						$currentDataType = "unsignedInteger";
					} else {
						$mySQLDataType = "";
						$currentDataType = "string";
					}
					$singleTableLine = substr($singleTableLine,strlen($mySQLDataType)+1,strlen($singleTableLine));	// Remove DataType Name
					// Check If This Row IS PRIMARY KEY AND AUTO_INCREMENT
					if(strpos($singleTableLine, "AUTO_INCREMENT") !== false){
						$currentDataType = "increments";
						$currentDataType = "bigIncrements";
					}
					// Check If The Row Is UNSIGNED
					$unsigned = "";
					if(strpos($singleTableLine, "unsigned") !== false){
						$unsigned = "->unsigned()";
					}
					// Check If The DEFAULT Value Is NULL
					$default = "";
					if(strpos($singleTableLine, "DEFAULT NULL,") !== false){
						$default = "";
					} else if(strpos($singleTableLine, "DEFAULT '") !== false){
						$str_default = $singleTableLine;
						$str_default = substr($str_default,strpos($str_default,"DEFAULT '"),strlen($str_default));
						$defaultValue = strtok(substr($str_default,strpos($str_default,"'")+1),"'");
						$default = "->default('".$defaultValue."')";
					} 
					// Check If The NULL Is ALLOWED OR NOT
					$nullable = "";
					if(strpos($singleTableLine, " NOT NULL ") !== false){
						$nullable = "";
					} else if(strpos($singleTableLine, " NULL ") !== false){
						$nullable = "->nullable()";
					} 
					// Write The Final Laravel Style Migration Rulei
					//	https://www.codegrepper.com/code-examples/php/laravel+migration+data+types
					if($currentDataType == "bigIncrements" || $currentDataType == "bigInteger" || $currentDataType == "binary" || $currentDataType == "boolean" || $currentDataType == "date" || $currentDataType == "dateTime" || $currentDataType == "float" || $currentDataType == "increments" || $currentDataType == "integer" || $currentDataType == "longText" || $currentDataType == "mediumInteger" || $currentDataType == "mediumText" || $currentDataType == "morphs" || $currentDataType == "nullableTimestamps" || $currentDataType == "smallInteger" || $currentDataType == "tinyInteger" || $currentDataType == "text" || $currentDataType == "time" || $currentDataType == "timestamp"){
						$finalContentToWrite .= '$table->'.$currentDataType.'("'.$columnName.'")'.$nullable.''.$unsigned.';
				';
					} else if($currentDataType == "decimal" || $currentDataType == "double"){
						$finalContentToWrite .= '$table->'.$currentDataType.'("'.$columnName.'"'.str_replace('"', '', $columnSize).')'.$nullable.''.$unsigned.';
				';
					} else {					
						$finalContentToWrite .= '$table->'.$currentDataType.'("'.$columnName.'"'.$columnSize.')'.$nullable.''.$unsigned.''.$default.';
				';
					}
				}
				$j++;
			}
			$finalContentToWrite .= '//$table->timestamps();
				//$table->softDeletes();
				';
			$finalContentToWrite .= '
			});
		}
	
		/**
		* Reverse the migrations.
		*
		* @return void
		*/
		public function down()
		{
			Schema::drop("'.$tableName.'");
		}
	
	}
?>';
		// Create A File And Write The Code
		if($tableName != "migrations"){
			$fp = fopen("migrations/".date('Y_m_d_His')."_".$tableName."_".$i.".php","wb");
			fwrite($fp,$finalContentToWrite);
			fclose($fp);
		}		
		// Create A File And Write The Code
		$i++;
	}
	/*
	** Create And Write All Database Table Migrations
	*/
	
	/*
	** Create And Write Database Updated migrations.sql File
	*/
	$finalContentToWrite = "";
	$finalContentToWrite = 'CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
';
	$directory = "migrations/";
	$phpfiles = glob($directory . "*.php");
	$i = 1;
	foreach($phpfiles as $phpfile)
	{
$finalContentToWrite .= "INSERT INTO `migrations` (`id`, `migration`, `batch`) values('".$i."','".basename($phpfile)."',1);
";
		$i++;
	}
	// Create A File And Write The Code
	$fp = fopen("migrations.sql","wb");
	fwrite($fp,$finalContentToWrite);
	fclose($fp);
	// Create A File And Write The Code
	/*
	** Create And Write Database Updated migrations.sql File
	*/
	
	
	echo '<div class="alert alert-success d-flex align-items-center my-3" role="alert">
		<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
			<use xlink:href="#check-circle-fill"/>
		</svg>
		<div>
			Hurry! The File <b>'.htmlspecialchars( basename( $_FILES["sqlFile"]["name"])).'</b> Is Successfully Converted In Laravel Migrations.
		</div>
	</div>
	';
	
	// Show All File Name And Link To Download
	echo '<div class="alert alert-success align-items-center my-3 output_div" role="alert">
		<h5>List Of Laravel Migration Files:</h5>
		<p><a href="download.php" title="Click Here To Download All In ZIP"><b>&#10173; Download All Migrations In ZIP</b></a> | <a href="migrations.sql" download title="Click Here To Download Updated migrations.sql" class="link-success"><b>&#10173; Download migrations.sql</b></a> </p>
		<i><b>Note: </b>`migrations` Table migration.php is not generated as you have to Download it from above and run directly in Database first.</i><br/><br/>
		<ol>';
		$directory = "migrations/";
		$phpfiles = glob($directory . "*.php");
		foreach($phpfiles as $phpfile)
		{
		echo "<li>".basename($phpfile)."</li>";
		}
	echo '</ol>
	</div>';
	// Show All File Name And Link To Download
	
	/*
	**	END: Main Converter Code
	*/	
}
/*
**	FUNCTION: Get Index Of A Specific Prefix Value Occured First In The Array
*/	
function getFirstIndexOfArray_Prefix($incomingArray, $desiredPrefix){
	for ($i = 0; $i < count($incomingArray); $i++) {
		if( substr($incomingArray[$i], 0, strlen($desiredPrefix)) === $desiredPrefix ){
			return $i;
		}
	}
	return null;
}
/*
**	FUNCTION: Get Index Of A Specific Prefix Value Occured Last In The Array
*/	
function getLastIndexOfArray_Prefix($incomingArray, $desiredPrefix){
	$tempIndex = 0;
	for ($i = 0; $i < count($incomingArray); $i++) {
		if( substr($incomingArray[$i], 0, strlen($desiredPrefix)) === $desiredPrefix ){
			$tempIndex = $i;
		}
	}
	return $tempIndex;
}
/*
**	FUNCTION: Count Specific Prefix Value Occurance In The Array
*/	
function getCountIndexOfArray_Prefix($incomingArray, $desiredPrefix){
	$tempIndex = 0;
	for ($i = 0; $i < count($incomingArray); $i++) {
		if( substr($incomingArray[$i], 0, strlen($desiredPrefix)) === $desiredPrefix ){
			$tempIndex++;
		}
	}
	return $tempIndex;
}
/*
**	FUNCTION: To check the string is starting with given substring or not
*/
function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
/*
**	FUNCTION: To check the string is ends with given substring or not
*/
function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}
/*
**	FUNCTION: Make Class Name for Laravel Migration Class
*/
function makeClassName($str) {
  $frags = explode("_",$str);
  for ($i = 0; $i < count($frags); $i++) {
    $frags[$i] = ucfirst($frags[$i]);
  }
  return implode("",$frags);
}

?>