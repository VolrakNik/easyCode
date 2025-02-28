<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property int id
 * @property string uuid
 * @property int user_id
 * @property string code
 * @property string data
 * @mixin Builder
 */
class Verification extends Model
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    public static function hashCode(int $value): string
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public static function verifyCode(int $value, string $hash): bool
    {
        return password_verify($value, $hash);
    }

    public function setCodeAttribute(int $value): void
    {
        $this->attributes['code'] = self::hashCode($value);
    }
}
