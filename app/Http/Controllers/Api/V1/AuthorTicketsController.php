<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AuthorTicketsController extends ApiController
{
    protected $policyClass = TicketPolicy::class;
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

        try {
            // policy
            $this->isAble('store', Ticket::class);

            return new TicketResource((Ticket::create($request->mappedAttributes([
                'author' => 'user_id'
            ]))));
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to create that resource', 401);
        }

    }

    public function replace($author_id, $ticket_id, ReplaceTicketRequest $request)
    {
        try {

            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            $this->isAble('replace', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource(resource: $ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error('Cannot find ticket', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update that resource', 401);
        }

    }


    public function update($author_id, $ticket_id, UpdateTicketRequest $request)
    {
        try {

            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource(resource: $ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error('Cannot find ticket', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update that resource', 401);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->firstOrFail();

            $this->isAble('delete', $ticket);

            $ticket->delete();
            return $this->ok('Ticket deleted successfully');

        } catch (ModelNotFoundException $e) {
            return $this->error('Cannot find ticket', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update that resource', 401);
        }

    }
}
