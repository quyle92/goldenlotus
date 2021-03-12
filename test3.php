<?php
// $dirs = array_filter(glob('*'), 'is_dir');
// $fileName = array();
// foreach ($dirs as $dir)
// {
//   $fileName[] = $dir . '/index.php';
// }
// print_r( $fileName);
// 
$dir = new DirectoryIterator(dirname(__FILE__));
$dirArray = array();
foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $dirArray[] = $fileinfo->getFilename();
    }
}

$indexFiles =array();
foreach($dirArray as $item)
{
      $dir = new DirectoryIterator($item);
      foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDir() && !$fileinfo->isDot()) {
          if( $fileinfo->getFilename() == 'index.php'){
            $indexFiles[] = $item . '/' . $fileinfo->getFilename();
          }
        }
      }
}

print_r( $indexFiles);

$content = "<?php require_once('../helper/security.php'); ?>";
 foreach ($indexFiles as $file)
 {   
    $line = file_get_contents('test4.php');
    $contents = file_get_contents($file);
    $contents = str_replace($line, '', $contents);
    file_put_contents($file, $contents);
 }