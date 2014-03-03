<?php

class Model_Guestbook extends Model
{
    function __construct()
    {
        parent::__construct(); // This line is very important
        $this->comments_table_name = mysql_table_prefix . 'guestbook';
    }

    function get_comments()
    {
        // It is good practice to include this line at the start of all methods using the database
        // in case there are multiple DBs in use
        $this->select_default_db();
        $result = mysql_query("SELECT `author` , `comment` FROM `$this->comments_table_name`", $this->mysql_link);
        if($result === FALSE) {mysql_error();}
        $return = array();
        while ($row = mysql_fetch_assoc($result))
        {
            $return[] = $row;
        }
        return $return;
    }

    function post_comment($author, $comment)
    {
        $this->select_default_db();
        // Make sure that ALL user submitted data is escaped to prevent SQL injection
        $author = mysql_real_escape_string($author, $this->mysql_link);
        $comment = mysql_real_escape_string($comment, $this->mysql_link);
        mysql_query("insert into `$this->comments_table_name` values (null, '$author', '$comment')", $this->mysql_link);
    }

}

?>