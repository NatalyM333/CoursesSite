<?php
use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => 'Види', 'url' => ['types']];
foreach ($types as $key => $value) {
    $images= json_decode($value->url_image,true);
?>
  
  <a href="<?= Url::to(["producers", 'id' => $value->id])?>" style="width:40%; height:auto;" class="card bg-dark text-white mx-auto m-2 align-middle">
  <img src="<?= $images[0]?>" class="card-img w-100" alt="...">
  <div  class="card-img-overlay mx-auto w-75 text-center" style="line-height: 100%;">
    <h5 class="card-title " style="font-size:2vw; margin: 0; color: black;text-shadow: grey 1px 0 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%); ">
  <?=$value->name?></h5>
</div>
</a>
<?php
}
?>