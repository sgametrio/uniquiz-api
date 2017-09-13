<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Question extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "text" => $this->text,
            "solution_type" => $this->solution_type,
            "answers" => Answer::collection($this->answers)
        ];
    }
}
