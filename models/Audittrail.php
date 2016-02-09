<?php
namespace exertis\savewithaudittrail\models;

use Yii;

class AuditTrailException extends \Exception {} ;

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
	public static function tableName()
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
			['record_id', 'integer'],
			['table_name', 'string', 'length' => ['max'=>64]],
			['message', 'string', 'length' => ['max'=>1024]],
			['username', 'string', 'length' => ['max'=>128]],
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
         * @param type $tblName Table name of the model being affected
         * @param type $recordId Record ID  of the model being affected
         */
        public function log($msg, $tblName, $recordId, $userDetails=null) {

            if(!$msg || !$tblName || !$recordId)
                throw new AuditTrailException('Invalid Parameters for '.__METHOD__);


            $this->message = $msg;
            $this->table_name = $tblName;
            $this->record_id = $recordId;
            //if (Yii::app() instanceof CConsoleApplication)
            //    $auditentry->username = 'console application';
            //else
            if (!empty($userDetails))
                $this->username = $userDetails->email;
            else {
                $this->username = 'unknown';
            }

            if (!$this->save())
                throw new AuditTrailException('Audittrail filed to save! : '.\yii\helpers\VarDumper::dump($this->getErrors(), 99,TRUE));
        } // log

     
        /**
         * Retrieve all AuditTrail entries for a list of usernames.
         * Useful for showing the activity of all users
         * @param array $usernames
         * @return \yii\data\ActiveDataProvider
         */
        public function getActivityForUsernames(array $usernames) 
        {
            if (!count($usernames)) {
                return null;
            }
            
            $activity = \exertis\savewithaudittrail\models\Audittrail::find()->
                    where(['IN', 'username', $usernames])
                            ->orderBy('timestamp DESC');
        
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $activity,
                'pagination' => [
                    'pageSize' => 7,
                ]
            ]);
            
            return $dataProvider;
        }
}