<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'body' => $this->resource->body,    
            'user_name' => $this->user->name,    
            'user_avatar' =>'https://www.beahero.gg/wp-content/uploads/2019/07/Re-Zero-Rem.jpg',    
            'ago' => $this->created_at->diffForHumans(),   
            'is_liked' =>  $this->isLiked(), 
            'likes_count' =>  $this->likesCount(), 
        
        ];

    }
}
