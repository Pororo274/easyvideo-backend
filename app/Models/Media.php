<?php

namespace App\Models;

use App\Contracts\Observers\ProjectUpdatedContract;
use App\Dto\Media\MediaDto;
use App\Enums\Media\MediaStatusEnum;
use App\Observers\ProjectUpdateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Enums\Media\MediaTypeEnum;

/**
 * 
 *
 * @property int $id
 * @property string $path
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property MediaTypeEnum $type
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @property string $uuid
 * @property bool $is_uploaded
 * @property string $original_name
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereIsUploaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereType($value)
 * @mixin \Eloquent
 */
#[ObservedBy([ProjectUpdateObserver::class])]
class Media extends Model implements ProjectUpdatedContract
{
    use HasFactory;

    protected $fillable = [
        'path', 'project_id', 'original_name', 'is_uploaded', 'uuid', 'type'
    ];

    protected $casts = [
        'type' => MediaTypeEnum::class
    ];

    public function toDto(): MediaDto
    {
        return new MediaDto(
            uuid: $this->uuid,
            originalName: $this->original_name,
            type: Storage::mimeType($this->path),
            status: MediaStatusEnum::fromBool($this->is_uploaded),
            objectURL: url('/api/' . $this->path),
            uploadedBytes: Storage::size($this->path)
        );
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getProjectId(): int
    {
        return $this->project_id;
    }
}
