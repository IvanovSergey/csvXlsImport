<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Загрузите csv или excel файл</h2>

        <form id="data" method="post" enctype="multipart/form-data">  
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
            <div class="form-group">
                <input class="form-control" name="file" type="file" accept=".csv, .xls, .xlsx" />
            </div>
            <div class="form-group">
                <a href="<?=Yii::$app->homeUrl?>/" class="btn btn-danger">Cancel</a>
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
    
</div>
