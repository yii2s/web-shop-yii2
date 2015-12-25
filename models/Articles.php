<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Users;
use yii\behaviors\TimestampBehavior;

class Articles extends ActiveRecord
    {

    const VISIBLE = 1;
    const HIDDEN = 0;
    const YES = 1;
    const NO = 0;

    public static function tableName()
    {
        return 'articles';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['article_status', 'comments_status'], 'boolean'],
            ['user_id', 'default', 'value' => \Yii::$app->user->identity->getId()],
            ['created_by', 'default', 'value' => \Yii::$app->user->identity->getId()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'article_id' => 'ID статьи',
            'title' => 'Заголовок',
            'user_id' => 'ID автора',
            'description' => 'Описание',
            'user.username' => 'Имя автора',
            'content' => 'Текст cтатьи',
            'createdBy.username' => 'Автор',
            'time_created' => 'Cоздана',
            'updatedBy.username' => 'Редактировал',
            'time_updated' => 'Изменена',
            'article_status' => 'Статья',
            'comments_status' => 'Комментарии',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'updated_by']);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'time_created',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'time_updated',
                ],
//                'value' => new \yii\db\Expression('NOW()')
                'value' => function() {
            return \Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
        }
            ]
        ];
    }

    public static function articleStatusList()
    {
        return [
            self::HIDDEN => ['Скрыта', 'hidden'],
            self::VISIBLE => ['Опубликована', 'visible'],
        ];
    }

    public static function getArticleStatuses()
    {
        return [self::HIDDEN, self::VISIBLE];
    }

    public static function getArticleStatus($status, $tag = false)
    {
        if ($tag) {
            return self::articleStatusList()[$status][1];
        } else {
            return self::articleStatusList()[$status][0];
        }
    }

    public static function commentsStatusList()
    {
        return [
            self::NO => ['Запрещены', 'disabled'],
            self::YES => ['Разрешены', 'allowed'],
        ];
    }

    public static function getCommentsStatuses()
    {
        return [self::NO, self::YES];
    }

    public static function getCommentsStatus($status, $tag = false)
    {
        if ($tag) {
            return self::commentsStatusList()[$status][1];
        } else {
            return self::commentsStatusList()[$status][0];
        }
    }

    }
