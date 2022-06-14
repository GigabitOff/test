<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testi_otveti".
 *
 * @property int $id
 * @property string $username
 * @property string|null $user_id
 * @property int $ticher_id
 * @property string $country_id
 * @property string|null $city_id
 * @property int $school_id
 * @property string $classnumber_id
 * @property string|null $classlater_id
 * @property string $value_otveta
 * @property string $value_otveta_yes
 * @property string $date
 * @property string $time
 * @property string|null $dateandtime
 * @property string|null $timeendtest
 * @property int $status_test
 * @property string $active
 * @property string $code_test
 */
class TestiOtveti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testi_otveti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'username', 'ticher_id', 'country_id', 'school_id', 'classnumber_id', 'value_otveta', 'value_otveta_yes', 'date', 'time', 'status_test', 'active', 'code_test'], 'required'],
            [['id', 'ticher_id', 'school_id', 'status_test'], 'integer'],
            [['date', 'time', 'dateandtime', 'timeendtest'], 'safe'],
            [['username', 'country_id', 'classnumber_id', 'value_otveta', 'active', 'code_test'], 'string', 'max' => 255],
            [['user_id', 'city_id', 'classlater_id'], 'string', 'max' => 20],
            [['value_otveta_yes'], 'string', 'max' => 22],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'user_id' => 'User ID',
            'ticher_id' => 'Ticher ID',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'school_id' => 'School ID',
            'classnumber_id' => 'Classnumber ID',
            'classlater_id' => 'Classlater ID',
            'value_otveta' => 'Value Otveta',
            'value_otveta_yes' => 'Value Otveta Yes',
            'date' => 'Date',
            'time' => 'Time',
            'dateandtime' => 'Dateandtime',
            'timeendtest' => 'Timeendtest',
            'status_test' => 'Status Test',
            'active' => 'Active',
            'code_test' => 'Code Test',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TestiOtvetiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestiOtvetiQuery(get_called_class());
    }
}
