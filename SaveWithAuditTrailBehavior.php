<?php

namespace exertis\savewithaudittrail;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use exertis\savewithaudittrail\models\Audittrail;


class SaveWithAuditTrailBehavior extends Behavior {

    private $_owner;
    public $userClass = '\common\models\User';

    public function init()
    {
        parent::init();

    }


    public function _logToAuditTrail($msg) {

        // check if this is a console app, which has no user
        if (get_class(Yii::$app) !== 'yii\console\Application') {

            try {
              $userObj = new $this->userClass();
              $user = $userObj->findOne(['id'=>Yii::$app->user->id]);
            } catch (Exception $ex) {
              $user = null;
            }
        } else {
            $user = null; // console app without a user
        }

        $at = new Audittrail;
        $at->log($msg, $this->_owner->tableName(), intval($this->_owner->getPrimaryKey()), $user );
    } // _logToAuditTrail

    /**
     * Save this record and add one or more entries to the Audit Trail
     * @param mixed $message Message (string) or Array of Messages to put in the Audit Trail
     */
    public function saveWithAuditTrail($message = '', $runValidation = true, array $attributes = NULL) {

        // @todo RCH Couldn't get is_subclass_of to work
        //if (!is_subclass_of($this->owner, 'BaseActiveRecord')) {
        //    Yii::error('Cannot attach SaveWithAuditTrailBehavior to '.$this->owner->className());
        //    return FALSE;
        //}

        $this->_owner = $this->owner;

        $result = $this->_owner->save($runValidation, $attributes);

        if (!is_array($message))
            $messages = array($message);
        else
            $messages = $message;

        foreach ($messages as $msg) {
            $this->_logToAuditTrail($msg);
        }

        return $result;
    } // saveWithAuditTrail

}
