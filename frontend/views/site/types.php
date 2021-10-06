<?php
use yii\helpers\Url;

foreach ($types as $key => $value) {
    $images= json_decode($value->url_image,true);
?>
  <div  class="w-50 mx-auto">
    <img src="<?= $images[0]?>" style="height: 200px;" alt="...">
  </div>
<?php
}
?>