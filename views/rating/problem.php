<?php

/* @var $users \app\models\User */
/* @var $top3users \app\models\User */
/* @var $pages \yii\data\Pagination */
/* @var $currentPage integer */
/* @var $defaultPageSize integer */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Rating');
?>
<p style="text-align: center">
    <?= Html::a('段位排行', ['index']) ?>
    <?= Html::a('题数排行', ['problem']) ?>
</p>
<div class="rating-index">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row rating-top">
                <?php if (isset($top3users[1])): ?>
                <div class="col-md-4 col-xs-4">
                    <div class="rating-two">
                        2
                    </div>
                    <h3 class="rating-two-name"><?= Html::a(Html::encode($top3users[1]['nickname']), ['/user/view', 'id' => $top3users[1]['id']]) ?></h3>
                    <span><?= $top3users[1]['solved'] ?></span>
                </div>
                <?php endif; ?>
                <?php if (isset($top3users[0])): ?>
                <div class="col-md-4 col-xs-4">
                    <div class="rating-one">
                        1
                    </div>
                    <h3 class="rating-one-name"><?= Html::a(Html::encode($top3users[0]['nickname']), ['/user/view', 'id' => $top3users[0]['id']]) ?></h3>
                    <span><?= $top3users[0]['solved'] ?></span>
                </div>
                <?php endif; ?>
                <?php if (isset($top3users[2])): ?>
                <div class="col-md-4 col-xs-4">
                    <div class="rating-three">
                        3
                    </div>
                    <h3 class="rating-three-name"><?= Html::a(Html::encode($top3users[2]['nickname']), ['/user/view', 'id' => $top3users[2]['id']]) ?></h3>
                    <span><?= $top3users[2]['solved'] ?></span>
                </div>
                <?php endif; ?>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Who</th>
                        <th>Solved</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $k => $user): ?>
                        <?php $num = $k + $currentPage * $defaultPageSize + 1; ?>
                        <tr>
                            <th scope="row"><?= $num ?></th>
                            <td>
                                <?= Html::a(Html::encode($user['nickname']), ['/user/view', 'id' => $user['id']]) ?>
                            </td>
                            <td>
                                <?= $user['solved'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
        </div>
    </div>
</div>