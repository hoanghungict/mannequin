<?php namespace App\Models;

/**
 * App\Models\AdminUser
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $profile_image_id
 * @property string $remember_token
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Image $profileImage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminUserRole[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereProfileImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminUser whereUpdatedAt($value)
 */
class AdminUser extends AuthenticatableBase
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'facebook_id', 'facebook_token', 'remember_token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'facebook_token'];

    protected $dates  = ['deleted_at'];

    // Relation

    public function profileImage()
    {
        return $this->belongsTo('App\Models\Image', 'profile_image_id', 'id');
    }

    public function roles()
    {
        return $this->hasMany('App\Models\AdminUserRole', 'admin_user_id', 'id');
    }

    // Urility Functions

    /**
     * @return string
     */
    public function getProfileImageUrl()
    {
        $profileImage = $this->profileImage;
        if (empty($profileImage)) {
            return url('static/admin/img/default-user-image.jpg');
        }
    }

    /**
     * @param  string $targetRole
     * @param  bool $checkSubRoles
     * @return bool
     */
    public function hasRole($targetRole, $checkSubRoles = true)
    {
        $roles = $this->roles->lists('role')->toArray();
        if (in_array($targetRole, $roles)) {
            return true;
        }
        if (!$checkSubRoles) {
            return false;
        }
        $roleConfigs = \Config::get('admin_user.roles', []);
        foreach ($roles as $role) {
            $subRoles = array_get($roleConfigs, "$role.sub_roles", []);
            if (in_array($targetRole, $subRoles)) {
                return true;
            }
        }
        return false;
    }

}
