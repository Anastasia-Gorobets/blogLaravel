<?php

namespace App\Listeners;

use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPosted;
use App\Events\CommentPosted as CommentPostedEvent;


class NotifyUsersAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPostedEvent $event)
    {
        ThrottledMail::dispatch(new CommentPosted($event->comment), $event->comment->commentable->user);

        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
