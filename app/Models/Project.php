<?php

namespace App\Models;

use App\Dto\Projects\ProjectDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $width
 * @property int $height
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereWidth($value)
 * @property int $fps
 * @property string|null $preview
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereFps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserId($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'width', 'height', 'fps', 'user_id',
        'updated_at', 'preview'
    ];

    public function toDto(): ProjectDto
    {
        return new ProjectDto(
            id: $this->id,
            name: $this->name,
            width: $this->width,
            height: $this->height,
            fps: $this->fps,
            userId: $this->user_id,
            preview: $this->preview ? asset($this->preview) : null,
            createdAt: $this->updated_at
        );
    }
}
