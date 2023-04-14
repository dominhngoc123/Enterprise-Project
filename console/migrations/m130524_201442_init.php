<?php

use common\models\constant\StatusConstant;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'description' => $this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'ideaId' => $this->integer()->notNull(),
            'url' => $this->string(255)->notNull(),
            'file_type' => $this->string(50),
            'original_name' => $this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'description' => $this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%campaign}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'start_date' => $this->string(),
            'closure_date' => $this->string(),
            'end_date' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'full_name' => $this->string(50),
            'email' => $this->string(50)->unique(),
            'dob' => $this->string(20),
            'phone_number' => $this->string(10),
            'avatar' => $this->string(255),
            'address' => $this->string(255),
            'departmentId' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'role' => $this->smallInteger()->notNull(),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%idea}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'content' => $this->text(),
            'parentId' => $this->integer(),
            'userId' => $this->integer(),
            'departmentId' => $this->integer(),
            'categoryId' => $this->integer(),
            'campaignId' => $this->integer(),
            'upvote_count' => $this->integer(),
            'downvote_count' => $this->integer(),
            'view_count' => $this->integer(),
            'post_type' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\IdeaTypeConstant::PUBLIC),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%reaction}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(),
            'ideaId' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(common\models\constant\StatusConstant::ACTIVE),
            'created_at' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%hashtag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->unique()->notNull(),
            'status' => $this->smallInteger()->defaultValue(StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ]);

        $this->createTable('{{%idea_tag}}', [
            'id' => $this->primaryKey(),
            'ideaId' => $this->integer(),
            'hashtagId' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(StatusConstant::ACTIVE),
            'created_at' => $this->string(),
            'created_by' => $this->string(),
            'updated_at' => $this->string(),
            'updated_by' => $this->string(),
        ]);

        $this->addForeignKey('FK_user_department', 'user', 'departmentId', 'department', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_idea_idea', 'idea', 'parentId', 'idea', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_idea_user', 'idea', 'userId', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_idea_department', 'idea', 'departmentId', 'department', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_attachment_idea', 'attachment', 'ideaId', 'idea', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_user_category', 'idea', 'categoryId', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_idea_campaign', 'idea', 'campaignId', 'campaign', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_reaction_user', 'reaction', 'userId', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_reaction_idea', 'reaction', 'ideaId', 'idea', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_idea_hashtag', 'idea_tag', 'ideaId', 'idea', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_hashtag_idea', 'idea_tag', 'hashtagId', 'hashtag', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
