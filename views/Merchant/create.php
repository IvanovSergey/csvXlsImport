<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MerchantProducts */

$this->title = 'Create Merchant Products';
$this->params['breadcrumbs'][] = ['label' => 'Merchant Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
