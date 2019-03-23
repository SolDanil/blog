<?php
namespace app\models;
use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAdmin','role_id'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
            'role_id'=>'Role ID'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }
    public static function findByEmail($email)
    {
        return User::find()->where(['email'=>$email])->one();
    }
    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }

    public function create()
    {

        return $this->save(false);
    }

    public function saveFromVk($uid, $name, $photo)
    {
        $user = User::findOne($uid);
        if($user)
        {
            return Yii::$app->user->login($user);
        }

        $this->id = $uid;
        $this->name = $name;
        $this->photo = $photo;
        $this->create();

        return Yii::$app->user->login($this);
    }
    public function getImage()
    {
        return $this->photo;
    }
    public function getRoles()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    public function getSelectedRoles()
    {
        $selectedIds = $this->getRoles()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveRoles($role_id)
    {
        $role = Role::findOne($role_id);
        if($role != null)
        {
            $this->link('role', $role);
            return true;
        }
    }

    public function isAdmin($user_id){

        $user=User::findOne($user_id);
        if ($user->roles->name=='admin')
            return true;
        else
            return false;
    }
    public function isAuthor($user_id){

        $user=User::findOne($user_id);
        if ($user->roles->name=='author')
            return true;
        else
            return false;
    }
}