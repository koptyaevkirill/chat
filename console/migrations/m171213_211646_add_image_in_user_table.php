<?php

use yii\db\Migration;

/**
 * Class m171213_211646_add_image_in_user_table
 */
class m171213_211646_add_image_in_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'image', 'string');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'image');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171213_211646_add_image_in_user_table cannot be reverted.\n";

        return false;
    }
    */
}
