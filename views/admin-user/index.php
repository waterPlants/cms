<?php
/**
 * index
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 30.10.2014
 * @since 1.0.0
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?= \skeeks\cms\modules\admin\widgets\GridViewStandart::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'adminController'   => $controller,
    'columns' => [
        ['class' => \skeeks\cms\grid\ImageColumn::className()],

        'username',
        'name',


        ['class' => \skeeks\cms\grid\CreatedAtColumn::className()],
        [
            'class' => \skeeks\cms\grid\DateTimeColumnData::className(),
            'attribute' => 'logged_at'
        ],

        [
            'class'     => \yii\grid\DataColumn::className(),
            'value'     => function(\skeeks\cms\models\User $model)
            {
                $result = [];

                if ($roles = \Yii::$app->authManager->getRolesByUser($model->id))
                {
                    foreach ($roles as $role)
                    {
                        $result[] = $role->description . " ({$role->name})";
                    }
                }

                return implode(', ', $result);
            },
            'format'    => 'html',
            'label'     => 'Роли',
        ],

        [
            'class'         => \skeeks\cms\grid\BooleanColumn::className(),
            'attribute'     => "active",
        ],

    ],
]); ?>
