<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [];

    public function add($data, $agent)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->message = $data['message'];
        $this->ip_address = request()->ip();
        $this->os = $agent->platform();
        $this->browser = $agent->browser();
        $this->save();
    }

    public function read()
    {
        if (!$this->read) {
            $this->read = true;
            $this->update();
        }
    }
}
