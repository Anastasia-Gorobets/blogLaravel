<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable /*implements ShouldQueue*/
{
    use Queueable, SerializesModels;

    public $comment ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
       $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment was posted on your {$this->comment->commentable->title}";
        return $this->subject($subject)/*->attachFromStorage($this->comment->user->image->path, 'profile.jpeg')*/->from('nastya.gorobets95@gmail.com', 'Nastya')->view('emails.posts.commented', ['comment'=>$this->comment]);
    }
}
