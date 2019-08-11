<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'SiteManager.php';
$_public = SiteManager::get('public');
$_trash = SiteManager::get('trash');
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/font-awesome-4.7.0/css/font-awesome.min.css">
  </head>
  <body>
      <nav class="navbar navbar-expand-sm navbar-dark bg-secondary shadow-sm">
          <a class="navbar-brand" href="#">FileManger <span class="badge badge-pill badge-warning">Pro</span></a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
              aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavId">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
              <form class="form-inline my-2 my-lg-0">
                  <input class="form-control mr-sm-2 form-control-sm" type="text" placeholder="Search">
                  <button class="btn btn-outline-info btn-sm  my-2 my-sm-0" type="submit">Search</button>
              </form>
          </div>
      </nav>
      <div class="container-fluid mt-1 ">
          <div class="row">
              <div class="col-md-12 ">
                <div class="float-right">
                    <a name="" id="" class="btn btn-info btn-sm" href="#" role="button">New File</a>
                    <a name="" id="" class="btn btn-primary btn-sm " href="#"  data-toggle="modal" data-target="#upload">Upload File</a>
                </div>
              </div>
              
          </div>
      </div>
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="navId">
                    <li class="nav-item">
                        <a href="#allfiles" class="nav-link active" data-toggle='tab'>All Files <span class="badge badge-info"><?php echo count($_public) ?></span></a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#trash" class="nav-link" data-toggle='tab'><i class="fa fa-trash-o" aria-hidden="true"></i> Trash <span class="badge badge-danger"><?php echo count($_trash) ?></span></a>
                    </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="allfiles" role="tabpanel">
                        <div class="container">
                            <div class="row mt-2">
                                <?php
                                    foreach($_public as $file){
                                        $ext = pathinfo($file,PATHINFO_EXTENSION);
                                        $icon = "";
                                        switch($ext){
                                            case 'png':case 'jpg':case 'gif':$icon = '<i class="fa fa-file-image-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'avi':case 'mp4':case '3gp':$icon = '<i class="fa fa-file-movie-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'docx':case 'pdf':case 'txt':$icon = '<i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'mp3':case 'ogg':case 'wma':$icon = '<i class="fa fa-file-audio-o fa-5x" aria-hidden="true"></i>';break;
                                            default:$icon = '<i class="fa fa-file-o fa-5x" aria-hidden="true"></i>';
                                        }
                                ?>
                                <div class="col-md-2 col-sm-3 mb-3">
                                    <div class="card" draggable='true'>
                                        <div class="card-body text-center">
                                        <?php echo $icon ?>
                                            <p class="card-text small"><?php echo ucwords(substr(pathinfo($file,PATHINFO_FILENAME),0,20))?></p>
                                            
                                        </div>
                                        <div class='card-footer p-0'>
                                            
                                            <div class="dropdown">
                                            <span class="badge badge-pill badge-info ml-2"><?php echo $ext ?></span>
                                                <button id="my-dropdown" class="btn  btn-sm float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                                <div class="dropdown-menu">
                                                <?php 
                                                    if($ext == 'jpg' || $ext == 'gif' || $ext == 'png'){
                                                        echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#preview'.md5(pathinfo($file,PATHINFO_FILENAME)).'">Preview</a>';
                                                    }
                                                    if($ext == 'mp4' || $ext == '3gp' || $ext == 'avi'){
                                                        echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#video'.md5(pathinfo($file,PATHINFO_FILENAME)).'">Preview Video</a>';
                                                    }
                                                    if($ext == 'mp3' || $ext == 'ogg' || $ext == 'wma'){
                                                        echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#sound'.md5(pathinfo($file,PATHINFO_FILENAME)).'">Play</a>';
                                                    }
                                                    if($ext == 'pdf' || $ext == 'txt'){
                                                        echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#text'.md5(pathinfo($file,PATHINFO_FILENAME)).'">Preview</a>';
                                                    }

                                                ?>
                                                    
                                                    <a class="dropdown-item" href="./public/<?php echo (pathinfo($file,PATHINFO_BASENAME))?>" download>Download</a>
                                                    <a class="dropdown-item" href="<?php echo 'SiteManager.php?action=delete&path='.urlencode($file); ?>">Move To Trash</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#rename<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>">Rename</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
<div class="modal fade" id="rename<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rename</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php __DIR__.DIRECTORY_SEPARATOR.'SiteManager.php'?>">
                    <div class="form-group">
                        <input id="my-input2" class="form-control" type="text" name="myfilename" required value='<?php echo pathinfo($file,PATHINFO_FILENAME) ?>'>
                        <input  type="hidden" name="myfilenamefull" required value='<?php echo $file ?>'>
                    </div>
                     <div class="form-group mt-3 float-right">
                         <input  class="btn btn-sm btn-info" type="submit" name="rename" value='Rename'>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>

                                <!-- Modal -->
    <div class="modal fade" id="preview<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <img class="img-fluid" src="./public/<?php echo (pathinfo($file,PATHINFO_BASENAME))?>" class='w-100' alt="">
        </div>
    </div>
</div>


                               <!-- Modal -->
    <div class="modal fade" id="video<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-body p-0">
        <video src="./public/<?php echo (pathinfo($file,PATHINFO_BASENAME))?>" class='w-100' controls></video>
        </div>
    </div>
</div>
                              <!-- Modal -->
    <div class="modal fade" id="sound<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-body p-0">
        <audio src="./public/<?php echo (pathinfo($file,PATHINFO_BASENAME))?>" class='w-100' controls></audio>
        </div>
    </div>
</div>

                                <!-- Modal -->
<div class="modal fade" id="text<?php echo md5(pathinfo($file,PATHINFO_FILENAME))?>" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-body p-0" style='height:500px'>
            <embed src="./public/<?php echo (pathinfo($file,PATHINFO_BASENAME))?>" type="" class='w-100 h-100'/>
        </div>
    </div>
</div>
                                <?php
                                    }

                                ?>
                            </div>
                        </div> 
                    </div>




                    <div class="tab-pane fade" id="trash" role="tabpanel">   
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                            <?php 
                            echo (count($_trash))?'<a  class="btn btn-danger btn-sm float-right" href="SiteManager.php?action=cleartrash">Empty Trash</a>
                            </div>':'';
                            
                            ?>
                            
                        </div>
                    </div>    
                        <div class="container">
                            <div class="row mt-2">
                                <?php
                                    foreach($_trash as $file){
                                        $ext = pathinfo($file,PATHINFO_EXTENSION);
                                        $icon = "";
                                        switch($ext){
                                            case 'png':case 'jpg':case 'gif':$icon = '<i class="fa fa-file-image-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'avi':case 'mp4':case '3gp':$icon = '<i class="fa fa-file-movie-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'docx':case 'pdf':case 'txt':$icon = '<i class="fa fa-file-pdf-o fa-5x" aria-hidden="true"></i>';break;
                                            case 'mp3':case 'ogg':case 'wma':$icon = '<i class="fa fa-file-audio-o fa-5x" aria-hidden="true"></i>';break;
                                            default:$icon = '<i class="fa fa-file-o fa-5x" aria-hidden="true"></i>';
                                        }
                                ?>
                                <div class="col-md-2 col-sm-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                        <?php echo $icon ?>
                                            <p class="card-text small"><?php echo substr(pathinfo($file,PATHINFO_FILENAME),0,20)?></p>
                                            
                                        </div>
                                        <div class='card-footer p-0'>
                                            
                                            <div class="dropdown">
                                            <span class="badge badge-pill badge-info ml-2"><?php echo $ext ?></span>
                                                <button id="my-dropdown" class="btn  btn-sm float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?php echo 'SiteManager.php?action=restore&path='.urlencode($file); ?>">Restore</a>
                                                    <a class="dropdown-item" href="<?php echo 'SiteManager.php?action=drop&path='.urlencode($file); ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                    }

                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
                
                
                  
              </div>
              
          </div>
      </div>




<!-- Modal -->
<div class="modal fade" id="upload" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose a file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php __DIR__.DIRECTORY_SEPARATOR.'SiteManager.php'?>" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input id="my-input" class="custom-file-input" type="file" name="myfile" required>
                        <label for="my-input" class="custom-file-label">Select...</label>
                    </div>
                     <div class="form-group mt-3 float-right">
                         <button id="my-input" class="btn btn-sm btn-info loader" type="submit" name="upload" value='Upload'>Upload</button>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.loader').forEach((ele)=>{
    ele.addEventListener('click',(e)=>{
        e.target.innerHTML = "<span class='spinner-border spinner-border-sm'></span>Loading..";
    });
});

</script>



    <script src='bootstrap/js/jquery-3.3.1.js'></script>
    <script src='bootstrap/js/bootstrap.bundle.min.js'></script>
    

  </body>
</html>