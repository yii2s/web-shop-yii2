<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_210443_create_article_tags_table extends Migration
{
    
    // Связующая таблица "Статья-Теги"
    // ID статьи - integer notNull
    // ID тега - integer notNull
    public function up()
    {
        $this->createTable('{{article_tags}}', [
            'article_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        if ($this->db->schema->getTableSchema('{{article_tags}}', true) !== null) {
            $this->dropTable('{{article_tags}}');
        }
    }

}
