<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TestiVoprosi]].
 *
 * @see TestiVoprosi
 */
class TestiVoprosiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TestiVoprosi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TestiVoprosi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
