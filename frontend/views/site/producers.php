<?php
use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => 'Види', 'url' => ['types']];
$this->params['breadcrumbs'][] = ['label' => $type];
foreach ($producers as $key => $value) {
?>
  <a href="<?= Url::to(["lifts", 'type_id' => $type_id, 'producer_id' => $value->id])?>" class="btn btn btn-dark btn-lg btn-block"><?=$value->name?></a>
<?php
}
?>