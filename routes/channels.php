<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel(
    'send-new-message.{chat_id}',
    function ($user, $chat_id) {
        //user exist in chat or no
        $chat = Chat::find($chat_id);
        $isMember = $chat->users()->wherePivot('user_id', $user->id)->exists();
        //check
        if ($isMember) {
            return true;
        }
        return false;
    }
);
