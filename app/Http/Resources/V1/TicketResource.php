<?php

namespace App\Http\Resources\V1;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Ticket
 *
 */
// VERY HELPFUL and necessary laravel article on resources --> https://laravel.com/docs/11.x/eloquent-resources#main-content
class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array {
        return [
            'type'          => 'ticket',
            'id'            => $this->id,
            'attributes'    => [
                'title'       => $this->title,
                'description' => $this->when($request->routeIs('ticket.show'), $this->description),
                'status'      => $this->status,
                'createdAt'   => $this->created_at,
                'updatedAt'   => $this->updated_at
            ],
            'relationships' => [
                'author' => [
                    'data'  => [
                        'type' => 'user',
                        'id'   => $this->user_id
                    ],
                    'links' => ['self' => 'todo']
                ],
            ],
            'includes'      => [
                new UserResource($this->user)
            ],
            'links'         => [
                'self' => route('ticket.show', ['ticket' => $this->id])
            ]
        ];
    }
}
