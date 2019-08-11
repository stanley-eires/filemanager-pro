<?php
     class SiteManager{




        static function get($folder){
            $files = [];
            if(file_exists($folder)){
                foreach (scandir($folder) as $file) {
                    if($file == '.' || $file == '..' || is_dir($file)){
                        continue;
                    }
                    array_push($files,__DIR__.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$file);
                }        
            }
            return ($files);

        }
        static function doUpload($source,$filename){
            return (move_uploaded_file($source,__DIR__.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$filename))?true:false;
        }
        static function move($source,$dest = 'trash'){
            if(copy($source,__DIR__.DIRECTORY_SEPARATOR.$dest.DIRECTORY_SEPARATOR.basename($source))){
                unlink($source);
                return true;
            }
            return false;
        }
        static function drop($source){
            if(unlink($source)){
                return true;
            }
            return false;
        }
        static function rename($from,$to){
            echo "$from = $to";
            return(rename($from,pathinfo($from,PATHINFO_DIRNAME).DIRECTORY_SEPARATOR."$to.".pathinfo($from,PATHINFO_EXTENSION)))?true:false;
        }



    }

    if(isset($_POST['upload'])){
        (SiteManager::doUpload($_FILES['myfile']['tmp_name'],$_FILES['myfile']['name']))?header("Location:."):"";
    }
    if(isset($_POST['rename'])){
        (SiteManager::rename($_POST['myfilenamefull'],$_POST['myfilename']))?header("Location:."):"";
    }
    if(isset($_GET['action']) && $_GET['action']=='delete'){
        $filepath = urldecode($_GET['path']);
        if(SiteManager::move($filepath)){
            header("Location:./");
        }else{
            echo 'error';
        }

    }    
    if(isset($_GET['action']) && $_GET['action']=='restore'){
        $filepath = urldecode($_GET['path']);
        if(SiteManager::move($filepath,'public')){
            header("Location:./");
        }else{
            echo 'error';
        }

    }
    if(isset($_GET['action']) && $_GET['action']=='drop'){
        $filepath = urldecode($_GET['path']);
        if(SiteManager::drop($filepath)){
            header("Location:./");
        }else{
            echo 'error';
        }

    }
    if(isset($_GET['action']) && $_GET['action']=='cleartrash'){
        foreach (scandir('trash') as $file){
            if($file == '.' || $file == '..' || is_dir($file)){
                continue;
            }
            unlink(__DIR__."/trash/".$file);
        }
        header("Location:./");

    }

?>