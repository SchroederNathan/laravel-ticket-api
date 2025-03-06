<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class AuthorTicketsController extends ApiController
{
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)
                ->filter($filters)
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($author_id, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id,
        ];


        return new TicketResource(Ticket::create(attributes: $model));

    }

    public function replace($author_id, $ticket_id, ReplaceTicketRequest $request)
    {

            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {


                $model = [
                    'title' => $request->input('data.attributes.title'),
                    'description' => $request->input('data.attributes.description'),
                    'status' => $request->input('data.attributes.status'),
                    'user_id' => $request->input('data.relationships.author.data.id'),
                ];

                $ticket->update($model);
                return new TicketResource(resource: $ticket);

            }

            // TODO: Handle error

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('Ticket deleted successfully');
            }

            return $this->error('Cannot find ticket', 404);
        } catch (ModelNotFoundException $e) {
            return $this->error('Cannot find ticket', 404);
        }
    }
}
