<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['key', 'value', 'description'];
    protected $useTimestamps = true;
    protected $updatedField = 'updated_at';

    public function getSetting($key, $default = null)
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $setting['value'] : $default;
    }

    public function setSetting($key, $value, $description = null)
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['value' => $value]);
        } else {
            return $this->insert([
                'key' => $key,
                'value' => $value,
                'description' => $description,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }
        return $result;
    }
}
