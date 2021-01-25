<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'first_name', 'last_name', 'password', 'ip_address', 'os', 'browser',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function register($data, $agent)
    {
        $this->email = $data['email'];
        $this->password = Hash::make($data['password']);
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->ip_address = request()->ip;
        $this->os = $agent->platform();
        $this->browser = $agent->browser();
        $this->save();
        Cart::create(['user_id' => $this->id]);
        UserRoles::create(['user_id' => $this->id, 'role' => 'customer']);
    }

    public function subscribeToNewsLetter()
    {
        Newsletter::create(['email' => $this->email]);
    }

    public function addItemsToCart($items)
    {
        foreach ($items as $item) {
            $item->cart_id = $this->cart->id;
            $item->save();
        }
    }

    public function addPhoneNumber($number)
    {
        $this->phone_number = $number;
        $this->save();
    }

    public function isFromSerbia()
    {
        // $this->address->country == 'Srbija' ? true : false;
        if ($this->isAdmin()) {
            return true;
        } else {
            if ($this->address) {
                return $this->address->country == 'Srbija' ? true : false;
            } else {
                return false;
            }
        }
    }

    public function currency()
    {
        if ($this->isFromSerbia()) {
            return 'RSD';
        } else {
            return 'EUR';
        }
    }

    public function addIpAddress($ip)
    {
        $this->ip_address = $ip;
        $this->update();
    }

    public function addBrowserName($name)
    {
        $this->browser = $name;
        $this->update();
    }

    public function editPhoneNumber($number)
    {
        $this->phone_number = $number;
        $this->update();
    }

    public function isAdmin()
    {
        if ($this->role->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function isCustomer()
    {
        if ($this->role->role == 'customer') {
            return true;
        } else {
            return false;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function getLatestOrder()
    {
        $order = $this->hasOne(Order::class)->latest()->first();
        return $order->isPlaced() ? $order : null;
    }

    public function isFromBalkan()
    {
        $address = $this->address->country;
        if ($address == 'Srbija' || $address == 'Bosna i Hercegovina' || $address == 'Crna Gora' || $address == 'Kosovo') {
            return true;
        } else {
            return false;
        }
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function role()
    {
        return $this->hasOne(UserRoles::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
}
