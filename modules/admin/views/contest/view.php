<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $newAnnouncement app\models\ContestAnnouncement */
/* @var $announcements yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$problems = $model->problems;
?>
<div class="contest-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <?= Html::a(Yii::t('app', 'Source Print Queue'), ['/print', 'id' => $model->id], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Clarification'), ['clarify', 'id' => $model->id], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
        <?= Html::a(Yii::t('app', 'Submit records'), ['status', 'id' => $model->id], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
    </p>
    <p>
        <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <?= Html::a(Yii::t('app', 'Scroll Board'), ['board', 'id' => $model->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Rated'), ['rated', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Contest User'), ['register', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Editorial'), ['editorial', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?') . ' 该操作不可恢复，会删除所有与该场比赛有关的提交记录及其它信息',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <p>
        <?= Html::a(Yii::t('app', 'Print Problem'), ['print', 'id' => $model->id], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
        <?= Html::a(Yii::t('app', 'Print Rank') . '[用户名]', ['rank', 'id' => $model->id, 'who' => 0], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
        <?= Html::a(Yii::t('app', 'Print Rank') . '[昵称]', ['rank', 'id' => $model->id, 'who' => 1], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
        <?= Html::a(Yii::t('app', 'Print Rank') . '[用户名 & 昵称]', ['rank', 'id' => $model->id, 'who' => 2], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
    <p>打印使用方法：打开链接后，在页面上鼠标“右键”-“打印”，可以导出为 PDF 格式后打印，注意可能存在空白页</p>
    <hr>
    <h3>
        <?= Yii::t('app', 'Information') ?>
        <small><?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></small>
    </h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'start_time',
            'end_time',
            'lock_board_time',
            'description:ntext',
            [
                'label' => Yii::t('app', 'Scenario'),
                'value' => $model->scenario == Contest::SCENARIO_ONLINE ? Yii::t('app', 'Online') : Yii::t('app', 'Offline')
            ]
        ],
    ]) ?>

    <hr>
    <h3>
        <?= Yii::t('app', 'Announcements') ?>
        <?php Modal::begin([
            'header' => '<h3>'.Yii::t('app','Make an announcement').'</h3>',
            'toggleButton' => ['label' => Yii::t('app', 'Create'), 'class' => 'btn btn-success'],
        ]); ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($newAnnouncement, 'content')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <?php Modal::end(); ?>
    </h3>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $announcements,
        'columns' => [
            'content:ntext',
            'created_at:datetime',
        ],
    ]) ?>

    <hr>
    <h3><?= Yii::t('app', 'Problems') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="70px">#</th>
                <th width="120px">Problem ID</th>
                <th>Name</th>
                <th width="200px">Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($problems as $key => $p): ?>
                <tr>
                    <th><?= Html::a(chr(65 + $key), ['view', 'id' => $model->id, 'action' => 'problem', 'problem_id' => $key]) ?></th>
                    <th><?= Html::a($p['problem_id'], '') ?></th>
                    <td><?= Html::a(Html::encode($p['title']), ['view', 'id' => $model->id, 'action' => 'problem', 'problem_id' => $key]) ?></td>
                    <th>
                        <?php Modal::begin([
                            'header' => '<h3>'.Yii::t('app','Update'). ' : ' . chr(65 + $key) . '</h3>',
                            'toggleButton' => ['label' => 'Update', 'class' => 'btn btn-success'],
                        ]); ?>

                        <?= Html::beginForm(['contest/updateproblem', 'id' => $model->id]) ?>

                        <div class="form-group">
                            <?= Html::label(Yii::t('app', 'Current Problem ID'), 'problem_id') ?>
                            <?= Html::textInput('problem_id', $p['problem_id'],['class' => 'form-control', 'readonly' => 1]) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::label(Yii::t('app', 'New Problem ID'), 'new_problem_id') ?>
                            <?= Html::textInput('new_problem_id', $p['problem_id'],['class' => 'form-control']) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?= Html::endForm(); ?>

                        <?php Modal::end(); ?>
                        <?php if ($key == count($problems) - 1): ?>
                        <?= Html::a(Yii::t('app', 'Delete'), [
                                'deleteproblem',
                                'id' => $model->id,
                                'pid' => $p['problem_id']
                            ],[
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?php endif; ?>
                    </th>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th></th>
                <th></th>
                <th>
                    <?php Modal::begin([
                        'header' => '<h3>'.Yii::t('app','Add a problem').'</h3>',
                        'toggleButton' => ['label' => 'Add a problem', 'class' => 'btn btn-success'],
                    ]); ?>

                    <?= Html::beginForm(['contest/addproblem', 'id' => $model->id]) ?>

                    <div class="form-group">
                        <?= Html::label(Yii::t('app', 'Problem ID'), 'problem_id') ?>
                        <?= Html::textInput('problem_id', '',['class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?= Html::endForm(); ?>

                    <?php Modal::end(); ?>
                </th>
                <th></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php Modal::begin([
    'header' => '<h3>'.Yii::t('app','Information').'</h3>',
    'options' => ['id' => 'modal-info'],
    'size' => Modal::SIZE_LARGE
]); ?>
<div id="modal-content">
</div>
<?php Modal::end(); ?>
<?php
$js = "
$('[data-click=modal]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#modal-content').html(html);
            $('#modal-info').modal('show');
        }
    });
});
";
$this->registerJs($js);
?>
