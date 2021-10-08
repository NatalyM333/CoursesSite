<?php
use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => 'Види', 'url' => ['types']];
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => Url::to(["producers", 'id' => $type_id])];
$this->params['breadcrumbs'][] = ['label' => $producer];
?>
<div id="carouselExampleCaptions" data-interval="false" class="carousel  slide mx-auto" data-ride="carousel" style="width:60%; height:auto;">
<ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <?php
    for($i=1; $i <= count($lifts); $i++){
    ?>
    <li data-target="#carouselExampleCaptions" data-slide-to="<?=$i?>"></li>
    <?php
    }
    ?>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>

  <div class="carousel-inner">
      <?php
      $i=0;
      foreach ($lifts as $key => $value) {
        
        $images= json_decode($value->url_image,true);
        foreach ($images as $key => $image) {
            $i++;
            if($i == 1){
      ?>
    <div class="carousel-item active">
        <?php
            } else{
            ?>
    <div class="carousel-item">
        <?php
            }
        ?>
      <img src="<?= $image?>" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5 style="color:white;"><?=$i ?></h5>
       
      </div>
    </div>
    <?php

        }
      }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php
foreach ($lifts as $key => $value) {
    ?>
      <div class="m-3"><p><?=$value->description?></p></div>
    <?php
    }
    ?>