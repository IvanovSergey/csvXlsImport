<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MerchantProducts */

$this->title = 'Update Merchant Products: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Merchant Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="merchant-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
