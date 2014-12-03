<?php
namespace exertis\savewithaudittrail\components;

use Yii;

/**
 * This is the model class for table "audittrail".
 *
 * The followings are the available columns in table 'audittrail':
 * @property integer $id
 * @property string $table_name
 * @property integer $record_id
 * @property string $message
 * @property string $timestamp
 * @property string $username
 */
class Audittrail extends \yii\db\ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Audittrail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audittrail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('timestamp', 'required'),*/
			array('record_id', 'numerical', 'integerOnly'=>true),
			array('table_name', 'length', 'max'=>64),
			array('message', 'length', 'max'=>1024),
			array('username', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, table_name, record_id, message, timestamp, username', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table_name' => 'Table',
			'record_id' => 'Record',
			'message' => 'Message',
			'timestamp' => 'Timestamp',
			'username' => 'Username',
		);
	}


}