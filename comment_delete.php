<?php
    
    incluse 'includes.php';
    
    mysql_safe_query('DELETE FROM comments WHERE id=%s LIMIT 1', $_GET['id']);
    mysql_safe_query('UPDATE post SET num_comments-1 WHERE id=%s LIMIT 1', $_GET['id']);
    redirect('post_view.php?id=' . $_GET['post']);
