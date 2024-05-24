<?php

namespace App\Models;

use App\Contracts\Observers\ProjectUpdatedContract;
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\Observers\ProjectUpdateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property VirtualMediaTypeEnum $type
 * @property string $global_start_time
 * @property string $duration
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereGlobalStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereUuid($value)
 * @property string $start_time
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereStartTime($value)
 * @property int $layer
 * @method static \Illuminate\Database\Eloquent\Builder|VirtualMedia whereLayer($value)
 * @mixin \Eloquent
 */
#[ObservedBy([ProjectUpdateObserver::class])]
class VirtualMedia extends Model implements ProjectUpdatedContract
{
    use HasFactory;

    protected $fillable = [
        'type', 'duration', 'global_start_time', 'project_id', 'start_time', 'layer', 'uuid'
    ];

    protected $casts = [
      'type' => VirtualMediaTypeEnum::class
    ];

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getProjectId(): int
    {
        return $this->project_id;
    }
}
