<?php

for ($i = 1, $j = 1; $i <= 50; $i++){

    $comment = R::dispense('comments');

    $comment->parent_comment_id = $i;
    $comment->user_id = random_int(1, 50);
    $comment->message = 'comment message '.$j;
    $comment->is_hidden = 0;
    $comment->date = time();
    $j++;
    R::store($comment);

    $comment = R::dispense('comments');

    $comment->parent_comment_id = $i;
    $comment->user_id = random_int(1, 50);
    $comment->message = 'comment message '.$j;
    $comment->is_hidden = 0;
    $comment->date = time();
    $j++;
    R::store($comment);
}