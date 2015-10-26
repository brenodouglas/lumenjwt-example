<?php
namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model as AbstractModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Model extends AbstractModel implements AuthContract, CanResetPasswordContract
{
    
    use Authenticatable,
        CanResetPassword;

	protected $table = 'user';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token', 'email', 'id', 'created_at', 'updated_at'];
    
    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

}