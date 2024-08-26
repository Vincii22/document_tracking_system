<?php

// file_put_contents: shortcut for fopen/fwrite/fclose
// overwrites existing file by default (so be CAREFUL)
$file = 'sms_outgoing/filetest.sms';
$number = "639173193264";
//$number = "639175610034";
//$number = "639061275582";
//$number = "639178781281";
/*
$msg = "sl-dts update on doc#181103007: Completed @ OSDS-RECORDS.";
$content = "To: ".$number."\n\n".$msg." \n";
//echo $content;
if($size = file_put_contents($file, $content)) {
  echo "A file of {$size} bytes was created.";
}

$file = 'sms_outgoing/filetest1.sms';

$msg = "sl-dts update on doc#181103008: Canceled @ OSDS-RECORDS, Please contact the Division Office (053)570-8933.";
$content = "To: ".$number."\n\n".$msg." \n";
//echo $content;
if($size = file_put_contents($file, $content)) {
  echo "A file of {$size} bytes was created.";
}
*/
$file = 'sms_outgoing/filetest2.sms';

$msg = "sl-dts update on doc#181103009: Remarks Added @ BAC-OFFICE, TITS ARE TOO BIG";
$content = "To: ".$number."\n\n".$msg." \n";
//echo $content;
if($size = file_put_contents($file, $content)) {
  echo "A file of {$size} bytes was created.";
}



?>