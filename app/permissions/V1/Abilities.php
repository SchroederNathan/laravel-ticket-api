<?php

namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const CreateTicket = 'ticket:create';
    public const UpdateTicket = 'ticket:update';
    public const DeleteTicket = 'ticket:delete';
    public const ReplaceTicket = 'ticket:replace';

    public const CreateOwnTicket = 'ticket:own:create';
    public const UpdateOwnTicket = 'ticket:own:update';
    public const DeleteOwnTicket = 'ticket:own:delete';
    public const ReplaceOwnTicket = 'ticket:own:replace';

    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser = 'user:delete';

    public static function getAbilities(User $user): array
    {
        if ($user->is_manager) {
            return [
                self::CreateTicket,
                self::UpdateTicket,
                self::DeleteTicket,
                self::ReplaceTicket,
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        } else {
            return [
                self::CreateTicket,
                self::UpdateOwnTicket,
                self::DeleteOwnTicket,
            ];
        }
        
    }
}