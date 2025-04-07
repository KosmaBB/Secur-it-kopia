<?php
    include_once("db_connection.php");
    class db_posts extends db_connection{
        function selectAllPostsById($id_user) {
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT `id_post`, `title`, `content`, `date_added`, `approval_date` FROM `posts` WHERE `id_user` = $id_user";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }
        function selectUnApprovedPost(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT p.id_user, u.username, p.title, p.content, p.date_added, p.id_approving_employee, p.approval_date FROM posts AS p
            JOIN users AS u ON p.id_user = u.id_user
            WHERE p.id_approving_employee IS null;";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function selectApprovedPost(){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT p.id_user, u.username, p.title, p.content, p.date_added, p.id_approving_employee, p.approval_date FROM posts AS p
            JOIN users AS u ON p.id_user = u.id_user
            WHERE p.id_approving_employee != 0";
            $data = mysqli_query($this->connect, $query);
            if (mysqli_num_rows($data) > 0){
            return $data;
            }
        }

        function insertPost ($id_user, $title, $content, $date_added){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "INSERT INTO `posts`( `id_user`, `title`, `content`, `date_added`) VALUES  ('".$id_user."','".$title."','".$content."','".$date_added."');";
            $data = mysqli_query($this->connect, $query);
            $this->close();
        }

        function deletePost ($id_post){
            $query = "Delete from posts where id_post =".$id_post.";";
            $data = mysqli_query($this->connect, $query);
            unset($_GET['id_post']);
            $this->close();
        }

        function updatePost ($id_post, $id_user, $title, $content, $date_added, $id_approving_employee, $approval_date){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `posts` SET `id_user`='".$id_user."',`title`='".$title."',`content`='".$content."',`date_added`='".$date_added."',`id_approving_employee`='".$id_approving_employee."',`approval_date`='".$approval_date."' WHERE `id_post`=".$id_post.";";
            $data = mysqli_query($this->connect, $query);
            $this->close();
        }

        function selectCheckedPost (){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "SELECT `id_post`, `id_user`, `title`, `content`, `date_added`, `approval_date` FROM `posts` WHERE approval_date != 0";
            $data = mysqli_query($this->connect, $query);

            if (mysqli_num_rows($data) > 0) {
                return $data;
            }
        }

        function updateAprovePost ($id_post, $id_employee, $approval_date){
            mysqli_set_charset($this->connect, "utf8mb4");
            $query = "UPDATE `posts` SET `id_approving_employee`='".$id_employee."',`approval_date`='".$approval_date."' WHERE `id_post`=".$id_post.";";
            $data = mysqli_query($this->connect, $query);
            $this->close();
        }

    }
?>

