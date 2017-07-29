<?php
declare(strict_types = 1);

/*
 * Authenticate the user's personal channel...
 */
Broadcast::channel('App.User.*', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
