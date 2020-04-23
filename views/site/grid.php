<?php
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$this->registerJsFile("@web/js/all.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>
<div class="site-index">
    <select class="merchant_fields" style="display: none;">
        <option value="0">...</option>
        <?php foreach($arrFields as $field){?>
            <option value="<?=$field;?>"><?=$field;?></option>>
        <?php } ?>
    </select>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider
    ]); ?>
    
    <div class="form-group">
        <button id="import" class="btn btn-primary">Импортировать записи</button>
    </div>
    
</div>