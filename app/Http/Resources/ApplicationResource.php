<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'тема' => $this->topic,
            'пользователь' => User::find($this->user)->name,
            'сообщение' => $this->message,
            'статус' => $this->status,
            'комментарий' => $this->comment,
            'время создания' => $this->created_at->format('d.m.Y h:i:s'),
        ];
    }
}
