<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];

    public static function get($key)
	{
	    $setting = new self();
	    $entry = $setting->where('key', $key)->first();
	    if (!$entry) {
	        return;
	    }
	    return $entry->value;
	}


    public static function set($key, $value = null)
	{
	    $setting = new Setting();
	    $entry = $setting->where('key', $key)->first();
	    //If the key is not available
	    if( !$entry )
	    {
	    	$setting = new Setting();
	    	$setting->key 	= $key;
	    	$setting->value = $value;
	    	$setting->save();
	    }else
	    {
	    	//If the key already Exists.
	    	$entry->value = $value;
	    	$entry->save();
	    }	    
	    //Use Config to get the value
	    Config::set('key', $value);
	    if (Config::get($key) == $value) {
	        return true;
	    }
	    return false;
	}

}
