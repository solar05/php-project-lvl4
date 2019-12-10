<?php

namespace Task_Manager;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->belongsToMany('Task_Manager\Task', 'tag_task');
    }

    public static function prepareTags(string $tags)
    {
        $preparedTags = explode(' ', $tags);
        return array_reduce($preparedTags, function ($acc, $tag) {
            $trimmedTag = trim($tag);
            $tagToSave = Tag::firstOrCreate(['name' => mb_strtolower($trimmedTag)]);
            $tagToSave->save();
            $acc[] = $tagToSave->id;
            return $acc;
        }, []);
    }
}
