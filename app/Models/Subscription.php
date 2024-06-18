<?php

namespace App\Models;

use App\Dto\Subscription\SubscriptionDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $cost
 * @property \Illuminate\Support\Carbon $work_until
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereWorkUntil($value)
 * @mixin \Eloquent
 */
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cost', 'work_until', 'accepted_at'
    ];

    protected $casts = [
        'work_until' => 'datetime',
        'accepted_at' => 'datetime'
    ];

    public function toDto(): SubscriptionDto
    {
        return new SubscriptionDto(
            id: $this->id,
            userId: $this->user_id,
            workUntil: $this->work_until
        );
    }
}
