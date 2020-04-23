<?php
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Merchant';
?>
<div class="site-index">    

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider
    ]); ?>
    
</div>