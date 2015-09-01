<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;
use skeeks\cms\models\Tree;
use skeeks\cms\modules\admin\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Tree */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->fieldSet('Основные настройки') ?>

    <?= $form->fieldRadioListBoolean($model, 'active') ?>
    <?= $form->fieldRadioListBoolean($model, 'is_required') ?>


    <?= $form->fieldSelect($model, 'component', [
        'Базовые типы'          => \Yii::$app->cms->basePropertyTypes(),
        'Пользовательские типы' => \Yii::$app->cms->userPropertyTypes(),
    ])
        ->label("Тип свойства")
        ;
    ?>
    <?= $form->field($model, 'component_settings')->label(false)->widget(
        \skeeks\cms\widgets\formInputs\componentSettings\ComponentSettingsWidget::className(),
        [
            'componentSelectId' => Html::getInputId($model, "component")
        ]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'code')->textInput() ?>

<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Дополнительно') ?>
    <?= $form->field($model, 'hint')->textInput() ?>
    <?= $form->fieldInputInt($model, 'priority') ?>

    <?= $form->fieldRadioListBoolean($model, 'searchable') ?>
    <?= $form->fieldRadioListBoolean($model, 'filtrable') ?>
    <?= $form->fieldRadioListBoolean($model, 'smart_filtrable') ?>
    <?= $form->fieldRadioListBoolean($model, 'with_description') ?>
<?= $form->fieldSetEnd(); ?>


<? if (!$model->isNewRecord) : ?>
<?= $form->fieldSet('Значения для списка') ?>

    <?= \skeeks\cms\modules\admin\widgets\RelatedModelsGrid::widget([
        'label'             => "Значения для списка",
        'hint'              => "Вы можете привязать к элементу несколько свойст, и задать им значение",
        'parentModel'       => $model,
        'relation'          => [
            'property_id' => 'id'
        ],

        'sort'              => [
            'defaultOrder' =>
            [
                'priority' => SORT_DESC
            ]
        ],

        'dataProviderCallback' => function($dataProvider)
        {
            /**
             * @var \yii\data\BaseDataProvider $dataProvider
            */
            $dataProvider->getPagination()->defaultPageSize   = 5000;
        },

        'controllerRoute'   => 'cms/admin-cms-user-universal-property-enum',
        'gridViewOptions'   => [
            'sortable' => true,
            'columns' => [
                [
                    'attribute'     => 'id',
                    'enableSorting' => false
                ],

                [
                    'attribute'     => 'code',
                    'enableSorting' => false
                ],

                [
                    'attribute'     => 'value',
                    'enableSorting' => false
                ],

                [
                    'attribute'     => 'priority',
                    'enableSorting' => false
                ],

                [
                    'class'         => \skeeks\cms\grid\BooleanColumn::className(),
                    'attribute'     => 'def',
                    'enableSorting' => false
                ],
            ],
        ],
    ]); ?>

<?= $form->fieldSetEnd(); ?>
<? endif; ?>

<?= $form->buttonsCreateOrUpdate($model); ?>

<?php ActiveForm::end(); ?>




