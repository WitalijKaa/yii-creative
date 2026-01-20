<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'WK-13';
$justCached = Yii::$app->cache->get('justCached');
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Vitalii Kislitsa Yii2 pet</h1>

        <p class="lead">Just a pet project with code examples.</p>

        <p><a class="btn btn-lg btn-success" href="https://github.com/WitalijKaa">View the GitHub</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>BackEnd</h2>

                <p>PHP 5 7 8<br>Laravel 8-11<br>Yii 1.1 Yii 2</p>

                <p><a class="btn btn-outline-secondary" href="https://github.com/WitalijKaa/special-creativity">Laravel &raquo;</a></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>FrontEnd</h2>

                <p>jQuery<br>VueJS<br>PixiJS</p>

                <p><a class="btn btn-outline-secondary" href="https://github.com/WitalijKaa/magic-stone-circuit">Pixi JS &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>DevOps</h2>

                <p>Ansible<br>Terraform<br>k8s Helm</p>

                <p><a class="btn btn-outline-secondary" href="https://github.com/WitalijKaa/special-creativity-ai">Python &raquo;</a></p>
            </div>
        </div>

    </div>

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <div style="height: 120px;"></div>
        <p class="lead">Redis <?= $justCached ? Html::encode($justCached) : '' ?></p>
    </div>

</div>
