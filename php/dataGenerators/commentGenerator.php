<?php
//include_once "php/dataGenerators/commentGenerator.php";

for ($i = 1, $j = 1; $i <= 50; $i++){

    $comment = R::dispense('comments');

    $comment->parent_comment_id = $i;
    $comment->user_id = random_int(1, 50);
    $comment->message = 'comment message '.$j;
    $comment->is_hidden = 0;
    $comment->date = time();
    R::store($comment);

    $j++;
    $comment = R::dispense('comments');

    $comment->parent_comment_id = $i;
    $comment->user_id = random_int(1, 50);
    $comment->message = 'comment message '.$j;
    $comment->is_hidden = 0;
    $comment->date = time();
    R::store($comment);

    $j++;
}

for ($i = 1, $j = 1; $i <= 10; $i++){
    for ($k = 1; $k <= 5; $k++){
        $connection = R::dispense('announcementcomment');
        $connection->announcement_id = $i;
        $connection->comment_id = $j;
        R::store($connection);
        $j++;
    }
}