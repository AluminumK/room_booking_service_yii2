<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Application;
use common\models\Room;
use \kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的预约';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-index">
    <h1><?= Html::encode($this->title); ?></h1>
    <p>淡黄色的查看按钮表明该申请与已批准的申请冲突或房间已不可用</p>
    <div class="scrollable">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'attribute' => 'room_number',
                    'label' => '房间号',
                    'value' => 'room.room_number',
                ],
                [
                    'attribute' => 'campus',
                    'label' => '校区',
                    'value' => 'room.campus0.campus_name',
                    'filter' => Room::getAllCampus(),
                ],
                'organization_name',
                [
                    'attribute' => 'start_time',
                    'format' => ['date', 'php: Y-m-d H:i'],
                    'filter' => DateTimePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'start_time_picker',
                        'type' => DateTimePicker::TYPE_INPUT,
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'weekStart' => 1,
                            'minuteStep' => 10,
                        ]
                    ]),
                    'contentOptions' => ['class' => "time-column"],
                ],
                [
                    'attribute' => 'end_time',
                    'format' => ['date', 'php: Y-m-d H:i'],
                    'filter' => DateTimePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'end_time_picker',
                        'type' => DateTimePicker::TYPE_INPUT,
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'weekStart' => 1,
                            'minuteStep' => 10,
                        ]
                    ]),
                    'contentOptions' => ['class' => "time-column"],
                ],
                [
                    'attribute' => 'status',
                    'value' => 'statusStr',
                    'filter' => Application::getAllStatus(),
                    'contentOptions' => function ($model) {
                        /* @var $model Application */
                        $options = $model->getStatusBg();
                        $options['width'] = '80px';
                        return $options;
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => function ($model) {
                        /* @var $model Application */
                        return $model->getActionBg();
                    },
                    'template' => '{view} {print}',
                    'visibleButtons' => [
                        'print' => function ($model) {
                            return $model->status == Application::STATUS_APPROVED;
                        }
                    ],
                    'buttons' => [
                        'print' => function ($url) {
                            $options = [
                                'title' => '打印',
                                'aria-label' => '打印',
                                'data-pjax' => '0',
                                ''
                            ];
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, $options);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
