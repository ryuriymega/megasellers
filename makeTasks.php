<?php
$filesrc=file_get_contents("settings.ini");
 if(preg_match("{path=\"(.*?)\";}si",$filesrc,$arrparams1)){
	$path=$arrparams1[1];
 }else{
	 die("path not found!");
 }
chdir("$path");
function unzip($file){

    $zip=zip_open(realpath(".")."/".$file);
    if(!$zip) {return("Unable to proccess file '{$file}'");}

    $e='';

    while($zip_entry=zip_read($zip)) {
       $zdir=dirname(zip_entry_name($zip_entry));
       $zname=zip_entry_name($zip_entry);

       if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
       if(!is_dir($zdir)) mkdirr($zdir,0777);

       #print "{$zdir} | {$zname} \n";

       $zip_fs=zip_entry_filesize($zip_entry);
       if(empty($zip_fs)) continue;

       $zz=zip_entry_read($zip_entry,$zip_fs);

       $z=fopen($zname,"w");
       fwrite($z,$zz);
       fclose($z);
       zip_entry_close($zip_entry);

    } 
    zip_close($zip);

    return($e);
} 

function mkdirr($pn,$mode=null) {

  if(is_dir($pn)||empty($pn)) return true;
  $pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);

  if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}

  $next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
  if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
  return false;
}

if(file_exists("war.zip")){
	unzip("war.zip");
	unlink("war.zip");
	echo "all done!";
}

?>
