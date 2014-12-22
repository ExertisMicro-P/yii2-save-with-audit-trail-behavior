<?php
namespace exertis\savewithaudittrail;

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
		return [
			/*array('timestamp', 'required'),*/
			['record_id', 'numerical', 'integerOnly'=>true],
			['table_name', 'length', 'max'=>64],
			['message', 'length', 'max'=>1024],
			['username', 'length', 'max'=>128],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			['id, table_name, record_id, message, timestamp, username', 'safe', 'on'=>'search'],
		];
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

        /**
         * Log a message in the Audit Trail table against some Model activity
         *
         * @param type $msg Message to Log
         * @param type $tableName Table name of the model being affected
         * @param type $recordId Record ID  of the model being affected
         */
        public static function log($msg, $tblName, $recordId) {

            if(!$msg || !$tblName || !$recordId)
                throw new Exception('Invalid Parameters for '.__METHOD__);

            $auditentry = new Audittrail();

            $auditentry->message = $msg;
            $auditentry->table_name = $tblName;
            $auditentry->record_id = $recordId;
            //if (Yii::app() instanceof CConsoleApplication)
            //    $auditentry->username = 'console application';
            //else
            $auditentry->username = !empty(Yii::app()->user->name) ? Yii::app()->user->name : Yii::app()->user->email;

            $auditentry->save();
        } // log

}